<?php

// +----------------------------------------------------------------------+
// | File name : File Handler  	                                          |
// |(All file handling logics in the project will be through this class)  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: ARUN SADASIVAN<arun.s@armiasystems.com>              		  |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+


class Filehandler{


    public 		$errors = array();
    protected 	$table = "tbl_files";
    protected 	$allowed_extensions = array("gif", "jpeg", "jpg", "png", "bmp");
    public 	$file_upload_dir = FILE_UPLOAD_DIR;
    public    	$file_store = "Localfilestore";
    public    	$file_store_options = array("base_dir" => FILE_UPLOAD_DIR);
    const DIR_SIZE = 1000;
    private $rand = '';

    private $uploadErrors = array(
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION => 'File upload stopped by extension.',
    );

    public function handleUploads() {
        $files = array();
        foreach($_FILES as $name => $details) {
            $file = $this->handleUpload($details);
            $files[] = $file;
        }
        return $files;
    }


    public function handleUpload($upload_file,$random="") {

      //  print_r( $upload_file);die();

		$this->file_store_options = array("base_dir" => $this->file_upload_dir);

    	if (empty($upload_file) && empty($_FILES) && empty($_POST) && isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    		throw new FileHandlerException($error_msg, Error::FILE_SIZE_EXCEEDED, "upload_err_size_exceeded");
    	}

        $file  = new Filesobject();
        $file->file_orig_name = $upload_file['name'];
        $file->file_size	  = $upload_file['size'];
        $path_parts = pathinfo($file->file_orig_name);
        $file->file_extension = strtolower($path_parts['extension']);
        $file->file_mime_type = $upload_file['type'];
        $file->file_tmp_name = $upload_file['tmp_name'];
        $file->random_key = $random;

        $error = $upload_file['error'];

        if($error) {
            $error_msg = $this->uploadErrors[$error];
            if($error == UPLOAD_ERR_INI_SIZE || $error == UPLOAD_ERR_FORM_SIZE) {
                throw new FileHandlerException($error_msg, Error::FILE_SIZE_EXCEEDED, "upload_err_size_exceeded");
            }
            else if($error == UPLOAD_ERR_NO_FILE) {
                throw new FileHandlerException($error_msg, Error::FILE_EMPTY, "upload_err_empty");
            }
            else {
                throw new Exception($error_msg, Error::FILE_UNKNOWN_UPLOAD_ERROR);
            }
        }

        return $this->handleFile($file);
    }


    public function handleUrl($url, $curl_options = array()) {

        $file  = new Filesobject();
        $tmpfile = tempnam(sys_get_temp_dir(), "UIMG");
        //$tmpfile = tempnam("project/files/temp/", "UIMG");
        if(!$tmpfile) {
            throw new Exception("Could not create temp file", Error::FILE_URL_TMPFILE_CREATION_ERROR);
        }
        Logger::info("Downloading the file from url to tmp file");
        try {
            $curl = new Curlwrapper($url);
            if($curl_options) {
              foreach($curl_options as $curl_opt => $val) {
                $curl->setOpt($curl_opt, $val);
              }
            }
            $curl->copyToFile($tmpfile);
        }
        catch(Exception $e) {
            Logger::info($e);
            unlink($tmpfile);
            throw new FileHandlerException("Could not download file from url[$url]. Error: [". $e->getMessage() . "]", Error::FILE_URL_DOWNLOAD_ERROR, "upload_err_url_download_error");
        }
        try {
	        $arr = parse_url($url);
	        $path_info = pathinfo( $arr['path'] );
	        $file->file_orig_name = $path_info['basename'];
	        $file->file_extension = $path_info['extension'];
	        $file->file_size 	  = filesize($tmpfile);
	        $file->file_mime_type = $curl->getContentType();
	        $file->file_tmp_name = $tmpfile;
	        $file = $this->handleFile($file);

	        unlink($tmpfile);
			return $file;
        }
        catch(Exception $e) {
        	unlink($tmpfile);
            throw $e;
        }
    }

    // process the file locally stored on the disk
    public function handleLocalFile($file_path, $file_mime_type="") {
    	if(!file_exists($file_path)) {
    		throw new Exception("The file [$file_path] does not exist");
    	}
        $file  = new Filesobject();
        $path_info = pathinfo($file_path);
        $file->file_orig_name = $path_info['basename'];
        $file->file_extension = $path_info['extension'];
        $file->file_mime_type = $file_mime_type;
        $file->file_size      = filesize($file_path);
        $file->file_tmp_name = $file_path;
    	return $this->handleFile($file);
    }

    // process the file based on the mime type
    protected function handleFileTypes(Filesobject $file) {
         if(strstr($file->file_mime_type, 'pdf')){
             if($file->file_size > 10485760 ){
            throw new Exception("File size too big.Should not be more than 10MB", Error::FILE_URL_TMPFILE_CREATION_ERROR);

            }
        }
        if(strstr($file->file_mime_type, 'image')) {
            $size = getimagesize($file->file_tmp_name);
            $file->file_width  = $size[0];
            $file->file_height = $size[1];
            if(!$file->file_extension) {
                if($size[2]) $file->file_extension = image_type_to_extension($size[2]);
                if(!$file->file_extension) {
                    throw new FileHandlerException("Could not determine the file extension", Error::FILE_NOT_AN_IMAGE, "upload_err_invalid_format");
                }
            }
            $file->file_extension = ltrim(strtolower($file->file_extension), '.');
            if(!in_array($file->file_extension, $this->allowed_extensions)) {
                throw new FileHandlerException("File extension [$file->file_extension] not supported", Error::FILE_NOT_AN_IMAGE, "upload_err_invalid_format");
            }
        }
    }

    // Saves the file record to database.
    // populates the unique file_id and unique file_path
    protected function preProcessFile(Filesobject $file) {

		    if(FILE_UPLOAD_TABLE && FILE_UPLOAD_TABLE!=""){
				$this->table = FILE_UPLOAD_TABLE;
			}

			$dbh	 = new ModelCommon();
      		// Store the file record in DB
      		Logger::info("Saving the file into DB");
     		$file = $this->saveFileToDB($file, $this->table);
      		//$file->file_path = $this->createStoreKey($file);
			$file->file_path = $this->rand_str(4)."-".$file->file_orig_name;
    		$dbh->execute("update ".$this->table." set file_path = '".$file->file_path."' where file_id = '".$file->file_id."'");
    }


    protected function saveFileToDB(Filesobject $file, $table){
    	$created_by = '';
    	//TODO: handle created user codnition using Session User
//        if(User::$user_id) {
//            $created_by = User::$user_id;
//        }
        $data = array('file_orig_name' 	=>  $file->file_orig_name,
                    'file_extension' 	=> $file->file_extension,
                    'file_mime_type' 	=> $file->file_mime_type,
                    'file_size' 		=> $file->file_size,
                    'file_width' 		=> $file->file_width,
                    'file_height' 		=> $file->file_height,
                    'file_play_time' 	=> $file->file_play_time,
                    'file_type' 		=> $file->file_type,
                    'random_key'         => $file->random_key,
                    'created_by'		=> $created_by);

        $dbh = new ModelCommon();
        $file_id = $dbh->insert($table, $data);
        if(!$file_id) {
            throw new Exception("Failed to insert file into database");
        }
        $file->file_id = $file_id;
        return $file;
    }


    protected function handleFile(Filesobject $file) {
    	$this->handleFileTypes($file);
    	$this->preProcessFile($file);
    	$this->processFile($file);
    	try {
    	 $this->storeFile($file->file_path, $file->file_tmp_name);
    	}
    	catch(Exception $e) {
    		throw new FileHandlerException("Could not store file. Error [" . $e->getMessage() . "]",Error::FILE_STORE_ERROR,  "upload_error_store");
    	}
    	return $file;
    }

    protected function createStoreKey(Filesobject $file) {
		$rand = base_convert(time(),10,36) . $this->rand_str(5);
    	return $rand .  '.' . $file->file_extension;
    }

    // Generate a random character string
    private function rand_str($length = 32, $chars = 'abcdefghijklmnopqrstuvwxyz1234567890')
    {
        $chars_length = (strlen($chars) - 1);
        $string = $chars{rand(0, $chars_length)};
        for ($i = 1; $i < $length; $i = strlen($string))
        {
            $r = $chars{rand(0, $chars_length)};
            if ($r != $string{$i - 1}) $string .=  $r;
        }
        return $string;
    }

    protected function processFile(Filesobject $file) {
    }

    // Override this function if you want to change the way the files are stored.
    protected function storeFile($file_path, $tmp_file) {
	    	$file_store = $this->file_store;
	    	$obj = new $file_store($this->file_store_options);
	    	$obj->storeFile($file_path, $tmp_file);
    }

}

class FileHandlerException extends Exception {
    private $error_key;
    public function FileHandlerException($message, $code, $error_key="") {
        parent::__construct($message, $code);
        $this->error_key = $error_key;
    }
    public function getErrorKey() {
        return $this->error_key;
    }
}


class Filesobject{
	public $file_id;
    public $file_orig_name;
    public $file_extension;
    public $file_mime_type;
    public $file_type;
    public $file_width;
    public $file_height;
    public $file_play_time;
    public $file_size;
    public $file_path;
    public $file_status;
    public $file_title;
    public $file_caption;
    public $file_tmp_name;
    public $random_key;
    public $created_on;
    public $created_by;
}
?>
