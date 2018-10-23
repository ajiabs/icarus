<?php

/*
 * This class can be used to create copies of different sizes from a given image.
 * It is based on ImageMagick library functions.
 */

class imimagehandler extends imagehandler{

    public $createJpegOnly = false;
    public $quality = 90;
    public $padColor = "";


    function __construct($path) {
      parent::__construct($path);
      $this->IM = new imagemagickwrapper();
    }


    public function createThumbnail($target_file_path, $max_width, $max_height) {

        /* if either of the width or height is zero/null then calculate it using aspect ratio
         */
        if(!$max_height){
          $max_height = $max_width / $this->aspect;
        }
        else if(!$max_width) {
          $max_width = $max_height * $this->aspect;
        }

      //  Logger::debug("Source Dim: ($src_width x $src_height) Desired Dim: ($max_width x $max_height)");
        if($this->crop) {
          $this->cropImage($target_file_path, $max_width, $max_height);
        }
        else {
          $this->resizeImage($target_file_path, $max_width, $max_height);
        }
        return true;
    }

    public function executeCommand($target_file_path, $command, $params) {
    	$this->enlargeSmaller = false;
    	 if($command == "b") {
			list($width, $height) = explode("x", $params);
			$this->resizeImage($target_file_path, $width, $height);
    	 }
    	 else if($command == "f") {
			list($width, $height) = explode("x", $params);
			$this->facebookImage($target_file_path, $width, $height);
    	 }
    	 else if($command == "l") {
			list($width, $height) = explode("x", $params);
			$this->cropImage($target_file_path, $width, $height, "west");
    	 }
    	 else if($command == "h") { // Only horizontal padding
			list($width, $height) = explode("x", $params);
			$this->cropImageWithHorizontalPadding($target_file_path, $width, $height, "west");				    		
    	 }
    	 else if($command == "v") { // Only horizontal padding
			list($width, $height) = explode("x", $params);
			$this->cropImageWithVerticalPadding($target_file_path, $width, $height, "west");				    		
    	 }
    	 else if($command == "r") {
			list($width, $height) = explode("x", $params);
			$this->resizeImage($target_file_path, $width, $height, false);
    	 }
    	 else {
			list($width, $height) = explode("x", $params);
			$this->cropImage($target_file_path, $width, $height);
    	 }
    }

    protected function resizeImage($target_file_path, $max_width, $max_height, $padding=true) {
    	if(!$max_height) $max_height = $max_width / $this->aspect;
    	else if(!$max_width) $max_width = $max_height * $this->aspect;

    	$resize = $max_width . "x" . $max_height;
    	if(!$this->enlargeSmaller)  $resize .= ">";

    	$options = array("-resize" => $resize,
      					"-quality" => $this->quality,
      					"-gravity" => "center",
                        "+profile" => "*");
    	if($padding && $this->padColor) {
    		$options += array("-background" => $this->padColor,
      					      "-extent" => $max_width . "x" . $max_height
    		);
    	}

    	$input = new Imagemagickfile($this->filePath, $options);

    	$output = new Imagemagickfile($target_file_path);

    	$this->IM->execute(array($input, $output), "convert");
    }

    protected function cropImageWithHorizontalPadding($target_file_path, $max_width, $max_height, $gravity="center") {
    	if($max_height > $this->height) $max_height = $this->height;
    	$this->cropImage($target_file_path, $max_width, $max_height);
    }
    
    protected function cropImageWithVerticalPadding($target_file_path, $max_width, $max_height, $gravity="center") {
    	if($max_width > $this->width) $max_width = $this->width;
    	$this->cropImage($target_file_path, $max_width, $max_height);
    }
    
    protected function cropImage($target_file_path, $max_width, $max_height, $gravity="center") {
    	if(!$max_height) $max_height = $max_width / $this->aspect;
    	else if(!$max_width) $max_width = $max_height * $this->aspect;

    	$crop_params = $this->getCropParameters($max_width, $max_height);

    	list($new_width, $new_height, $max_width, $max_height, $off_w, $off_h) = $crop_params;

    	$resize = $new_width . "x" . $new_height;
    	if(!$this->enlargeSmaller)  $resize .= ">";

    	$options1 = array("-resize" => $resize);

    	$options2 = array("-quality" => $this->quality,
      					"-gravity" => $gravity,
      					"-extent" => $max_width . 'x' . $max_height );

    	$input = new Imagemagickfile($this->filePath, $options1);

    	$output = new Imagemagickfile($target_file_path, $options2);
    	$this->IM->execute(array($input, $output), "convert");
    }

    protected function facebookImage($target_file_path, $size1, $size2) {
    	$options1 = array("-background" => $this->padColor,
      					"-size" => $size1 . "x" . $size1,
						"-extent" => $size1 . "x" . $size1,
      					"-gravity" => "center");
    	$input = new Imagemagickfile($this->filePath, $options1);

    	$output = new Imagemagickfile($target_file_path, array("-crop" => $size2 . "x" . $size2 . "+0+0"));
    	$this->IM->execute(array($input, $output), "convert");

    }

}

?>
