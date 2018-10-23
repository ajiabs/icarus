<?php

/*
 * This class can be used to create copies of different sizes from a given image.
 * It is based on GD library functions.
 */

class gdimagehandler  extends imagehandler{

    public $createJpegOnly = true;

    private function memNew ($bgcolor = array(0, 0, 0), $width = null, $height = null) {

        if (null == $width) $width = $this->width;
        if (null == $height) $height = $this->height;

        $dstImage = imagecreatetruecolor($width, $height);
        $color = imagecolorallocate($dstImage, $bgcolor[0], $bgcolor[1], $bgcolor[2]);
        imagecolortransparent($dstImage, $color);
        if($this->type == 'image/png') {
            imagealphablending($dstImage, false);
            imagesavealpha($dstImage, true);
        }
        return $dstImage;
    }

    private function releaseMem ($image) {
        imagedestroy($image);
    }

    public function generateThumbnail($target_file_path,$max_width,$max_height,$crop=false){
    	$this->crop = $crop;
    	$this->createThumbnail($target_file_path,$max_width,$max_height);
    }
    
    public function createThumbnail($target_file_path, $max_width, $max_height) {
    
         /*
          * Use the original image 
          *  if target dimensions are not present OR
          *  if source image is smaller than target image then leave unchanged (we never enlarge the image).
         */
  
    	if(!$this->enlargeSmaller) {
	        if((!$max_width && !$max_height) ||
	        ( $this->width <= $max_width &&  $this->height <= $max_height))
	        {
	          if (!copy($this->filePath, $target_file_path)) {
	            throw new Exception("Could not save thumbnail to [$target_file_path]");
	          }
	          return true;
	        }	        
    	}

        /* if either of the width or height is zero/null then calculate it using aspect ratio
         */
        if(!$max_height){
          $max_height = $max_width / $this->aspect;
        }
        else if(!$max_width) {
          $max_width = $max_height * $this->aspect;
        }
		
        Logger::info("Source Dim: ($src_width x $src_height) Desired Dim: ($max_width x $max_height)");
        if($this->crop) {
          $this->cropImage($target_file_path, $max_width, $max_height);
        }
        else {
          $this->resizeImage($target_file_path, $max_width, $max_height);
        }
        return true;
    }
    
    private function memCopy () {
        switch ($this->type) {
            case 'image/gif':
                if (imagetypes() & IMG_GIF)
                    $srcImage = imageCreateFromGIF($this->filePath);
                else
                    return false;
                break;

            case 'image/jpeg':
                if (imagetypes() & IMG_JPG)
                    $srcImage = imageCreateFromJPEG($this->filePath) ;
                else
                    return false;
                break;

            case 'image/png':
                if (imagetypes() & IMG_PNG) {
                    $srcImage = imageCreateFromPNG($this->filePath) ;
                    imagealphablending($srcImage, true);
                    imagesavealpha($srcImage, true);
                }
                else
                    return false;
                break;

            case 'image/wbmp':
                if (imagetypes() & IMG_WBMP)
                    $srcImage = imageCreateFromWBMP($this->filePath) ;
                else
                    return false;
                break;

            default:
                throw new Exception("The source file [$this->filePath] is not a valid image [Mimetype: $this->type]");
                break;
        }

        return $srcImage;
    }

    public function saveImage($image, $filePath, $quality) {
        if($this->createJpegOnly) {
            Logger::info("Using quality: $quality");
            return imagejpeg($image, $filePath, $quality);
        }

        switch ($this->type) {
            case 'image/gif':
                return imagegif($image, $filePath);
            case 'image/png':
                return imagepng($image, $filePath);
            case 'image/jpeg':
                return imagejpeg($image, $filePath, $quality);
            case 'image/wbmp':
                return imagewbmp($image, $filePath);
            default:
                return false;
        }
    }


    protected function resizeImage($target_file_path, $max_width, $max_height) {

        $srcImage = $this->memCopy();
        if (!$srcImage) {
            throw new Exception("Could not create instance of source image");
        }

        $src_width  = $this->width;
        $src_height = $this->height;

        $height_ratio = $src_height / $max_height;
        $width_ratio  = $src_width / $max_width;

        if( $height_ratio > $width_ratio ){
            $max_width  = round($src_width * $max_height / $src_height);
        }
        else {
            $max_height = round($src_height * $max_width / $src_width);
        }

        if (!$destImage = $this->memNew($this->bgcolor, $max_width, $max_height)) {
            throw new Exception("Could not create a new empty image");
        }

        Logger::info("Resizing from ($src_width x $src_height) to ($max_width x $max_height)");
        if (!imagecopyresampled($destImage, $srcImage, 0, 0, 0, 0, $max_width, $max_height, $src_width, $src_height)) {
            throw new Exception("Could not resize image to required dimensions");
        }
        imagedestroy($srcImage);

		// imageantialias() doesn't work on Debian because of the way GD is installed
        if (function_exists("imageantialias") && !imageantialias($destImage, true)) {
            throw new Exception("imageantialias was unsuccessful on destination image");
        }
        if (!$this->saveImage($destImage, $target_file_path, $this->quality)) {
            throw new Exception("Could not create the thumnail[$thumbnail] image from dest image");
        }
        imagedestroy($destImage);

        return true;
    }

    protected function cropImage($target_file_path,  $max_width, $max_height) {
    	$crop_params = $this->getCropParameters($max_width, $max_height);
   		//Logger::info($target_file_path, $crop_params);
        $srcImage = $this->memCopy();
        if (!$srcImage) {
            throw new Exception("Could not create instance of source image");
        }

        list($new_width, $new_height, $max_width, $max_height, $off_w, $off_h) = $crop_params;

        $src_width  = $this->width;
        $src_height = $this->height;

        // First resize source image to an intermediate image
        if (!$destImage1 = $this->memNew($this->bgcolor, $new_width, $new_height)) {
            throw new Exception("Could not create a new empty image");
        }

        Logger::info("Resizing from ($src_width x $src_height) to ($new_width x $new_height)");
        if (!imagecopyresampled($destImage1, $srcImage, 0, 0, 0, 0, $new_width, $new_height, $src_width, $src_height)) {
            throw new Exception("Could not resize image to required dimensions");
        }
        imagedestroy($srcImage);

        $destImage = $destImage1;
        // Then crop it to required dimensions
        if($off_w || $off_h) {
            if (!$destImage = $this->memNew($this->bgcolor, $max_width, $max_height)) {
                throw new Exception("Could not create a new empty image");
            }
            Logger::info("Applying offset of ($off_w x $off_h) to ($new_width x $new_height) to reach target ($max_width x $max_height) ");
            if (!imagecopyresampled($destImage, $destImage1, 0, 0, $off_w, $off_h, $max_width, $max_height, ($new_width - 2*$off_w), ($new_height - 2*$off_h))) {
                throw new Exception("Could not resize image to required dimensions");
            }
            imagedestroy($destImage1);
        }

		// imageantialias() doesn't work on Debian because of the way GD is installed
        if (function_exists("imageantialias") && !imageantialias($destImage, true)) {
            throw new Exception("imageantialias was unsuccessful on destination image");
        }

        if (!$this->saveImage($destImage, $target_file_path, $this->quality)) {
            throw new Exception("Could not create the thumnail[$thumbnail] image from dest image");
        }

        imagedestroy($destImage);

        return true;

    }
    
    
//         	$ih = new gdimagehandler("C:\wamp\www\prostructor\project\images\coursr_bannersmaple.jpg");   	
//     	$ih->generateThumbnail("C:\wamp\www\prostructor\project\images\coursr_bannersmaple_thumb.jpg",120,120,true);
//		echo "hi";
//		exit;
}
?>