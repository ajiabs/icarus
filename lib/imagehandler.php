<?php

abstract class imagehandler  {

    protected $filePath = "";
    protected $type = "";
    protected $imageType = "";
    protected $width = 0;
    protected $height = 0;
    protected $bgcolor = null;
    protected $quality = 80;
    protected $aspect = null;
    protected $enlargeSmaller = false;
    protected $crop = false;
    protected $faceDetect = false;

    function __construct($path) {
        if(!file_exists($path) || !filesize($path)) {
            throw new Exception("The image [$path] does not exists or is empty.");
        }
        $this->filePath = $path;
        $imageInfo = getimagesize($this->filePath);
        if(!$imageInfo) {
          throw new Exception("Failed to get image size");
        }

        if ($imageInfo['mime'] != '') {
            $this->type = $imageInfo['mime'];
            $this->width = $imageInfo[0];
            $this->height = $imageInfo[1];
            $this->imageType = $imageInfo[2];
            $this->aspect = ($this->width)/($this->height);
        }
        $this->bgcolor  = array(0, 0, 0);
    }

    public abstract function createThumbnail($target_file_path, $max_width, $max_height);
    
    private function getFaceRectangle(){
    	$cmd = "/var/www/facedetect/facedetect --cascade=\"/var/www/facedetect/haarcascades/haarcascade_frontalface_alt.xml\" --scale=1.3 ";
    	$cmd .= $this->filePath;
    	exec($cmd, $out, $ret);
    	$out = implode("\n", $out);
    	Logger::info($out);
    	if($ret != 0) {
    	  throw new Exception("Command [$cmd] failed");
    	}
    	$count = preg_match_all("/FACE:(.*?):/", $out, $matches);
    	if(!$count) {
	      return null;
    	}
    	// return the biggest face
    	$face = null;
    	$last_radius = 0;
    	Logger::info($matches);
    	for($i=0;$i<$count;$i++) {
	      $str = $matches[1][$i];
	      $obj = new stdClass();
	      list($obj->x, $obj->y, $obj->radius) = explode("-", $str);
	      if($obj->radius > $last_radius) $face = $obj;
	      $last_radius = $obj->radius;
    	}
    	Logger::info($face);
    	return $face;
    }

    protected function getCropParameters($max_width, $max_height) {
      $face_detect = $this->faceDetect;
    	
      $src_width  = $this->width;
      $src_height = $this->height;

      $height_ratio = $src_height / $max_height;
      $width_ratio  = $src_width / $max_width;
      $off_h = 0;
      $off_w = 0;

      Logger::info("Height ratio: $height_ratio, Width ratio: $width_ratio");
      if( $height_ratio > $width_ratio ) {
        // height need to be altered. Find the offset 
        
        $new_height = $this->height * ( $max_width / $this->width );
        $new_width  = $max_width;

  
        
        if($new_height > $max_height) {
          if(!$face_detect || !($face = $this->getFaceRectangle())) {
            $off_h = floor(( $new_height - $max_height ) / 2);
          }
          else {
            $relative_y = $face->y / $this->height;
            $face_y = $relative_y * $new_height;
            $off_h = $face_y - $max_height/2;
            if($off_h < 0) $off_h = 0;
            if($off_h + $max_height > $new_height) $off_h = $new_height - $max_height;
            $off_h = floor($off_h);
          }
        }
      }
      else {
        $new_width = $this->width * ( $max_height / $this->height );
        $new_height  = $max_height;

        if($new_width > $max_width) {
          if(!$face_detect || !($face = $this->getFaceRectangle())) {
             $off_w = floor(( $new_width - $max_width ) / 2);
          }
          else {
            $relative_x = $face->x / $this->width;
            $face_x = $relative_x * $new_width;
            $off_w = $face_x - $max_width/2;
            if($off_w < 0) $off_w = 0;
            if($off_w + $max_width > $new_width) $off_w = $new_width - $max_width;
            $off_w = floor($off_w);
          }
        }
      }
      return array(intval($new_width), intval($new_height), $max_width, $max_height, $off_w, $off_h);
      
    }
    
    public static function getInstance($path, $master=false) {
      if(defined('IMAGE_MAGICK_PATH')) {
        return new imimagehandler($path, 90, $master);
      }
      else {
        return new gdimagehandler($path);
      }
    }
}

?>
