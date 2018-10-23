<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// +----------------------------------------------------------------------+
// | File name : cls_kliqboothfilehandler.php                                         		  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+ 
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems   2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+



/*
 * this class overrides the filehandler class for kliqbooth functionalities
 */
class Kliqboothfilehandler extends Filehandler{
	
	public function __construct() {
        parent::__construct();
       
    } 
	
    
    /*
     * function to make the file upload
     */
	public static function uploadfile($upload_file){
		
		$file_store_options = array("base_dir" => $file_upload_dir);
		
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
        return self::handleKliqBoothFile($file);
	}
	
	
	 public static function handleKliqBoothFile(Filesobject $file) {
    	$fh = new Filehandler();
    	$fh->handleFileTypes($file);
		self::preProcessFileKliqBooth($file);
		$fh->processFile($file);
    	try {
     		$fh->storeFile($file->file_path, $file->file_tmp_name);
    	}
    	catch(Exception $e) {
    		throw new FileHandlerException("Could not store file. Error [" . $e->getMessage() . "]",Error::FILE_STORE_ERROR,  "upload_error_store");
    	}
    	return $file;
    }
    
    
    
    
 	// Saves the file record to database.
    // populates the unique file_id and unique file_path
    public static  function preProcessFileKliqBooth(Filesobject $file) {
		$fh 				= new Filehandler();
		$fh->table 			= 'apptbl_files';
		$objUserDb 			= Appdbmanager::getUserConnection();
        $dbh 				= new Db($objUserDb);
      	// Store the file record in DB
      	Logger::info("Saving the file into DB");
     	$file 				= self::saveFileToDBkliqBooth($file,$fh->table);      
      	$file->file_path 	= $fh->createStoreKey($file);    
    	$dbh->execute("update ".$fh->table." set file_path = '".$file->file_path."' where file_id = '".$file->file_id."'");
    }
	
    
    
    
    
    
	public static function saveFileToDBkliqBooth(Filesobject $file, $table){
    	$created_by = '';
        $data = array('file_orig_name' 	=>  $file->file_orig_name,
                    'file_extension' 	=> $file->file_extension,
                    'file_mime_type' 	=> $file->file_mime_type,
                    'file_size' 		=> $file->file_size,
                    'file_width' 		=> $file->file_width,
                    'file_height' 		=> $file->file_height,
                    'file_play_time' 	=> $file->file_play_time,
                    'file_type' 		=> $file->file_type,
                    'created_by'		=> $created_by);

    	$objUserDb 				= Appdbmanager::getUserConnection();
        $dbh 					= new Db($objUserDb);
        $file_id = $dbh->insert($table, $data);
        if(!$file_id) {
            throw new Exception("Failed to insert file into database");
        }
        $file->file_id = $file_id;
        return $file;
    }
    
    
    
    /*
     * function to check the image uploading format,size and dimnentions
     */
    public static function checkUserImageUpload($tempfile,$imgheight='',$imgwidth='',$uploadtype ='temp')  {
    	 if($uploadtype == 'file') 	 {
         	$upfilename 	= $tempfile;
    	 	$tempfilename = $tempfile;
    	 }
    	 else 	 {
    	 	 
    	 	$upfilename 	= $tempfile['name'];
    	 	$tempfilename = $tempfile['tmp_name'];
    	 }
    	 
    
    	if ($tempfile) 
    	{
    		$errors = 0;
    		//echopre($tempfile);
    		$filename 	= stripslashes($upfilename);
    		$extension 	= self::getFileExtension($filename);	// get the file extention
    		$extension 	= strtolower($extension);
    	
    		if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif"))
    		{  
    			$errors=1; //  Unknown Image extension ';	 
    		}
    		else
    		{
    			$size	=filesize($tempfilename);
    			if ($size > MAX_UPLOAD_SIZE*1024)
    			{
    				$errors=2;  // "You have exceeded the size limit";
    			}
    			else 
    			{
    				if($imgheight >0 && $imgwidth > 0)
    				{
	    				list($width,$height)=getimagesize($tempfilename);
	    				//echo $width.':'.$height;
	    				//echo '<br>'.$imgwidth.':'.$imgheight;
	    				if( $height < $imgheight  || $width < $imgwidth)
	    					$errors = 3;		// image size not matching
    				}
    			}
    		}
    		return $errors;
    	}
    }
    
    
    /*
     * function to get the file extemsntion of a file
     */
    public static function getFileExtension($str) {
    	$i 		= strrpos($str,".");
    	if (!$i) { return ""; }
    	$l 		= strlen($str) - $i;
    	$ext 	= substr($str,$i+1,$l);
    	return $ext;
    }
    
    
       /*
     * function to generate thumbnail
     */
    public function createThumbnail($photoid,$thumbtype,$crop=true)
    {
    	
    	 
    	global $imageTypes;
    	 
    	$objUserDb 				= Appdbmanager::getUserConnection();
        $model 					= new Db($objUserDb);
        
    	$fileDet 	= $model->selectRecord("files","file_orig_name,file_path","file_id=".$photoid);
    	$sourceFile = FILE_UPLOAD_DIR.'/'. $fileDet->file_path;
    	$destFile  = FILE_UPLOAD_DIR.'/'.$imageTypes[$thumbtype]['prefix']. $fileDet->file_path;
    	 
    	$ih = new Gdimagehandler($sourceFile);   	
      	$ih->generateThumbnail($destFile,$imageTypes[$thumbtype]['width'],$imageTypes[$thumbtype]['height'],$crop);
 
    }
    
    
}

?>