<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : Utils.php                                         		  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Utils {
    /*
     * Function to escape string before db operation
     */

    public static function escapeString($data) {
        // return mysql_real_escape_string($data);
        return $data;
    }

    /*
     * function to set the table prefix
     */

    public static function setTablePrefix($tableName) {
        return MYSQL_TABLE_PREFIX . $tableName;
    }

    /*
     * function to return the static page details
     */

    public static function getPage($alias) {
        if ($alias) {
            $db = new Db();
            $pageData = $db->selectRecord('contents', 'cnt_title,cnt_content', " cnt_alias='" . $alias . "'");
            return $pageData;
        }
    }

    /*
     * function to get the settings values
     */

    public static function getSettings($alias) {
        if ($alias) {
            $db 		= new Db();
            $pageData 	= $db->selectRecord('lookup', 'vLookUp_Value', " vLookUp_Name='" . $alias . "'");
            return $pageData->vLookUp_Value;
        }
    }
    
    
    
	/*
     * function to get the user settings values
     */
    public static function getUserSettings($alias,$appid=null){
    	if ($alias) {
    		if(is_null($appid))
    			{
    				$objUserDb 				= Appdbmanager::getUserConnection();
    			}
    		else
    				$objUserDb 				= Appdbmanager::getUserConnection($appid);
        	$db 					= new Db($objUserDb);
        	$settingsValue			= $db->selectRow("settings","settings_value","settings_name='".$alias."'");
			return $settingsValue;
    	}
    }
    
    /*
     * function to return the user settings row
     */
    public static function getUserSettingsRow($alias){
    	if ($alias) {
    		$objUserDb 				= Appdbmanager::getUserConnection();
        	$db 					= new Db($objUserDb);
        	$settingsValue			= $db->selectRecord("settings","*","settings_name='".$alias."'");
			return $settingsValue;
    	}
    }
    
    
    /*
     * function to check the listing mode
     */
    public static function getListingMode(){
    	$userType = Utils::checkUserPermission();
    	if($userType == true)
    		return '0';
    	else 
    		return Utils::getUserSettings('showitemsmode'); 
    }
    
    

    /*
     * functio to ge the user session
     */
    public static function getUserSession() {
        $objSession = new LibSession();
        $values 	= json_decode($objSession->get('kb_user', 'default'));
      
        return $values;
    }
    
    
    /*
     * function to get the logined user name
     */
    public static function getLoginUserName(){
    	
    	$values 					= Utils::getUserSession();
     	
    	if($values->first_name != '')
    		return $values->first_name.' '.$values->last_name;
		 
    }
    
    /*
     * function to get logined user id
     */
    public static function getLoginedUserId(){
    	$values 					= Utils::getUserSession(); 
    	if($values->agent_id  != '')
    		return $values->agent_id;
    }
    
    
    
    /*
     * function to return logined users/agents appid
     */
    public static function getLoginedUserApp(){
    	$values 					= Utils::getUserSession();
    	if($values->smb_id  != '')
    		return $values->smb_id;
    }
    
    
    /*
     * function to get logined user extension number
     */
    public static function getLoginedUserExtension(){
    	$values 					= Utils::getUserSession();
    	if($values->agent_extn  != '')
    		return $values->agent_extn;
    }
    
    
    /*
     * function to get the last login of the agent
     */
    public static function getAgentLastLogin(){
    	$values 					= Utils::getUserSession();
    	if($values->agent_lastlogin  != '')
    		return $values->agent_lastlogin;
    }
    
    
    /*
     * check whether the user is logined or not
     */
    public static function checkUserLoginStatus(){
    	
    	
    	$userApp 	= self::getLoginedUserApp();
		PageContext::addJsVar("smbid_exten", $userApp.'_'.self::getLoginedUserExtension());

		
		PageContext::addJsVar("APP_ID", $userApp);
		
        $objSession 	= new LibSession();
        $values 		= json_decode($objSession->get('kb_user', 'default'));
        //echopre($values);
        if($values->user_id >0) 
            return true;
        else 
        	Utils::redirecttohome();
     }
     
     
	/*
	 * function to check the user roles
	 * TODO: we can add section wise permission in this function
	 */
	public static function checkUserPermission($section) {
		$objSession 	= new LibSession();
        $values 		= json_decode($objSession->get('kb_user', 'default'));
        if($values->agent_master != 0){
             return true;
        }
        else
        	return false;
     }
     
     
     /*
      * function to check the logined user is master or not
      */
     public static function checkMaster(){
     	$objSession = new LibSession();
        $values = json_decode($objSession->get('kb_user', 'default'));
        if($values->agent_master != 0) 
             return true;
        else
        	return false;
     }
     
     /*
      * check the user is permitted to view this page and
      */
     public static function checkPagePermission($section) {
     	
     	 if(Utils::checkUserPermission($section))
     	 	return true;
     	 else
     	 	  header("Location:".BASE_URL.'app/nopermission');
     	 	  
        exit;
     }
     
     
     
     
     public function redirecttohome()
	{
        header("Location:".BASE_URL);
        exit;
    }
     public static function imageUpload($data) {
       if ($data['tmp_name'] != "") {
            $maximum_allowed_file_size  = 1024 * 1024;
            $upload_image_directory     = ConfigPath::base() . "project/files/";
            $width_of_first_image_file  = $data['width1'];      // You may adjust the width here as you wish
            $width_of_second_image_file = $data['width2'];     // You may adjust the height here as you wish
            $image_filename             = $data["name"];
            $file_tmp_name              = $data['tmp_name'];
            $file_extensions            = pathinfo($image_filename, PATHINFO_EXTENSION); //get extension
            $file_size                  = filesize($file_tmp_name);

            if ($file_extensions != "gif" && $file_extensions != "jpg" && $file_extensions != "jpeg" && $file_extensions != "png") {
                //Invalid image type 
                $messageArray['message']        = 'Sorry, the file type you attempted to upload is invalid. <br>This system only accepts gif, jpg, jpeg or png image ';
                $messageArray['message_class']  = "error_message";
                $messageArray['message_status'] = 'False';
            } 
            elseif ($file_size > $maximum_allowed_file_size) { //Validate attached file to avoid large files
                $messageArray['message']        = "Sorry, you have exceeded this systems maximum upload file size limit of <b>" . $maximum_allowed_file_size;
                $messageArray['message_class']  = "error_message";
                $messageArray['message_status'] = false;
            } 
            else {
                if ($file_extensions == "gif") { //If the attached file extension is a gif, carry out the below action
                    $image_src = imagecreatefromgif($file_tmp_name); //This will create a gif image file
                } 
                elseif ($file_extensions == "jpg" || $file_extensions == "jpeg") { //If the attached file is a jpg or jpeg, carry out the below action
                    $image_src = imagecreatefromjpeg($file_tmp_name); //This will create a jpg or jpeg image file
                } 
                else if ($file_extensions == "png") { //If the attached file extension is a png, carry out the below action
                    $image_src = imagecreatefrompng($file_tmp_name); //This will create a png image file
                }

                //Get the size of the attached image file from where the resize process will take place from the width and height of the image
                list($image_width, $image_height) = getimagesize($file_tmp_name);
                /* The uploaded image file is supposed to be just one image file but 
                  we are going to split the uploaded image file into two images with different sizes for demonstration purpose and that process
                  starts from below */

                //This is the width of the first image file from where its height will be determined
                $first_image_new_width = $width_of_first_image_file;
                $first_image_new_height = ($image_height / $image_width) * $first_image_new_width;
                $first_image_tmp = imagecreatetruecolor($first_image_new_width, $first_image_new_height);

                //This is the width of the second image file from where its height will be determined
                $second_image_new_width = $width_of_second_image_file;
                $second_image_new_height = ($image_height / $image_width) * $second_image_new_width;
                $second_image_tmp = imagecreatetruecolor($second_image_new_width, $second_image_new_height);

                //Resize the first image file
                imagecopyresampled($first_image_tmp, $image_src, 0, 0, 0, 0, $first_image_new_width, $first_image_new_height, $image_width, $image_height);

                //Resize the second image file
                imagecopyresampled($second_image_tmp, $image_src, 0, 0, 0, 0, $second_image_new_width, $second_image_new_height, $image_width, $image_height);

                //Pass the attached file to the uploads directory for the first image file
                $vpb_uploaded_file_movement_one = $upload_image_directory .$image_filename;

                //Pass the attached file to the uploads directory for the second image file
                $vpb_uploaded_file_movement_two = $upload_image_directory . "thumb_" . $image_filename;

                //Upload the first and second images
                imagejpeg($first_image_tmp, $vpb_uploaded_file_movement_one, 100);
                imagejpeg($second_image_tmp, $vpb_uploaded_file_movement_two, 100);
                imagedestroy($image_src);
                imagedestroy($first_image_tmp);
                imagedestroy($second_image_tmp);

                $messageArray['message']        = 'The image file has been uploaded and resized into two different images with different sizes for demonstration purpose as shown below</div><br><span class="vpb_image_style"><img src="' . $vpb_uploaded_file_movement_one . '"></span><br clear="all" /><br clear="all" /><span class="vpb_image_style"><img src="' . $vpb_uploaded_file_movement_two . '"></span><br clear="all" />';
                $messageArray['message_class']  = "success_message";
                $messageArray['message_status'] = true;
                $messageArray['image_name']     = $image_filename;
            }
            return $messageArray;
            exit;
        }
    }
    
    
    /*
     * function to return sort up arrow
     */
    public static function sortuparrow(){
    	return '&nbsp;&nbsp;&nbsp;<img src="'.IMAGE_MAIN_URL.'uparrow.png">';
    	//return '&nbsp;&nbsp;&nbsp;&#9660;';
    }
    
    /*
     * function to return sort down arrow
     */
   	public static function sortdownarrow(){
   		return '&nbsp;&nbsp;&nbsp;<img src="'.IMAGE_MAIN_URL.'downarrow.png">';
    	//return '&nbsp;&nbsp;&nbsp;&#9650;';
    } 
	
    /*
     * function to return the sort link
     */
    public static function sortarrow(){
    	return '&nbsp;&nbsp;&nbsp;<img src="'.IMAGE_MAIN_URL.'updown.png">';
    	//return '&nbsp;&nbsp;&nbsp;&#9830;';
    } 
    
    
    /*
     * function to make a curl call
     */
	public static function get_url($request_url,$port=80) {
		
		$ch = curl_init();
  		curl_setopt($ch, CURLOPT_URL, $request_url);
  		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
  		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  		curl_setopt($ch, CURLOPT_PORT, $port);  		
  		$response = curl_exec($ch);
  		curl_close($ch);
  		return $response;
	}
	
	/*
	 * function to get the sorting order of the field
	 */
	public static function getsortorder($order){ 
		if($order == 'DESC') return Utils::sortuparrow();
        else if($order == 'ASC') return Utils::sortdownarrow();
	}
	
	/*
	 * function to get todays date
	 */
	public static function getTodaysDate(){
		return date('m/d/Y');
	}
	
	
	
	
 
	/*
	 * function to generate a random number
	 */
    public static function getRandom($length=10) {
        $chars 	= "abcdefghijklmnopqrstuvwxyz1234567890";
        $size 	= strlen( $chars );
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }
    
    
    /*
     * function to create a random verification key
     */
    public static function createVerificationKey($input){
    	$generatedKey = sha1(mt_rand(10000,99999).time().$input);
    	return $generatedKey;
    	
    }
    
    
    
    
    /*
     * function to show images in the system.
     */
	public static function imageCheck($source_file,$destination_prefix,$default_file,$additional_file=''){ 
        global $imageTypes;
        $finalImage = '';
        if($source_file && file_exists(FILE_UPLOAD_DIR.'/'.$source_file)) { 
            $imgName 			= $imageTypes[$destination_prefix]['prefix'].$source_file;
            if(file_exists(FILE_UPLOAD_DIR.'/'.$imgName)){
                $imgUrl 		= USER_IMAGE_URL.$imgName;
                $finalImage 	= $imgName;
            }else {
                $newImage 		= Utils::generateImage($source_file, $imgName, $imageTypes[$destination_prefix]['width'], $imageTypes[$destination_prefix]['height'],true);
                $imgUrl 		= USER_IMAGE_URL.$newImage;
                $finalImage 	= $newImage;
            }
         }else if($additional_file!=''){ 
            if($additional_file && file_exists(FILE_UPLOAD_DIR.'/'.$additional_file)) {
                $imgUrl 		= USER_IMAGE_URL.$additional_file;
                $finalImage 	= $additional_file;
                $newThumbImg 	= self::generateThumbnail($finalImage,'classThumb',true);
         		if($newThumbImg != '')
                	 $imgUrl 	= USER_IMAGE_URL.$newThumbImg;
            }
         }else{ 
            $imgUrl 			= USER_IMAGE_URL.$default_file;
            $finalImage 		= $default_file;
         } 
         $imagPath = '<img src="'.$imgUrl.'" width="'.$imageTypes[$destination_prefix]["width"].'" height="'.$imageTypes[$destination_prefix]["height"].'"  >';
         return $imagPath;
    }
    
    /*
     * generate thumbnail if the image not exist
     */
    public static function generateImage($sourceimage,$newimagename,$width,$height,$crop=false){
    	$sourceFile = FILE_UPLOAD_DIR.'/'. $sourceimage;
    	$destFile  	= FILE_UPLOAD_DIR.'/'.$newimagename;
    	$ih 		= new Gdimagehandler($sourceFile);   	
      	$ih->generateThumbnail($destFile,$width,$height,$crop);
      	return $newimagename;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    

	/*
	 * function to encrypt the item
	 */
	public static function encrypt($text) {
			$key = ENCRYPT_KEY;
			$iv = ENCRYPT_IV;
			$bit_check = ENCRYPT_BIT;
			
			$text_num =str_split($text,$bit_check);
			$text_num = $bit_check-strlen($text_num[count($text_num)-1]);
			for ($i=0;$i<$text_num; $i++) {$text = $text . chr($text_num);}
			$cipher = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
			mcrypt_generic_init($cipher, $key, $iv);
			$decrypted = mcrypt_generic($cipher,$text);
			mcrypt_generic_deinit($cipher);
			return base64_encode($decrypted);
	}
	
	/*
	 * function to decypt the item
	 */
	public static function decrypt($encrypted_text){
			
			$key = ENCRYPT_KEY;
			$iv = ENCRYPT_IV;
			$bit_check = ENCRYPT_BIT;
			
			$cipher = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
			mcrypt_generic_init($cipher, $key, $iv);
			$decrypted = mdecrypt_generic($cipher,base64_decode($encrypted_text));
			mcrypt_generic_deinit($cipher);
			$last_char=substr($decrypted,-1);
			for($i=0;$i<$bit_check-1; $i++){
		    	if(chr($i)==$last_char){
			        $decrypted=substr($decrypted,0,strlen($decrypted)-$i);
		    	    break;
		    	}
			}
			return $decrypted;
		}

		
	/*
	 * function to create a verification code
	 */
	public static function createVerificationCode($email,$data_array){
		if($email != ''){
			$activationKey		= self::createVerificationKey($email);
			$data_array['vkey']	= $activationKey;
		}
        $db                   	= new Db();
        $verifykey            	= $db->addFields('verification_keys', $data_array);
        return $activationKey;
	}

	
	/*
	 * function to check the verification code
	 */
	public static function checkVerificationCode($key){
        $db                     = new Db();
        $condition              = "vkey='".$key."'";
        $keyDetails           = $db->selectRecord("verification_keys", "*", $condition);
        return $keyDetails;
	}
	
	
	/*
	 * function to show the image
	 */
	public static function showImage($imageName,$imgType){
		global $imageTypes;
		//echopre($imageTypes[$imgType]);
		 
		//TODO: add image exist checking
		$placeholder = $imageTypes[$imgType]['placeholder'];
		if($imageName != '')
           	return '<img   src="'.USER_IMAGE_URL . $imageName.'" style="max-width:'.$imageTypes[$imgType]['maxwidth'].'px;">';
        else
           	return  '<img  src="'.USER_IMAGE_URL .$placeholder.'" style="max-width:'.$imageTypes[$imgType]['maxwidth'].'px;">';  	
	}
	 
	
	/*
	 * using this function we make the initial checkings or validations
	 */
	public static function initialLoader() {
		$appid  = self::getLoginedUserApp();
		// make custom logo and title
		if($appid != '') {
			PageContext::$response->companyName = Settings::getCustomSettingsInfo($appid,'company-name');
			$companyLogo = Settings::getCustomSettingsInfo($appid,'companylogo');
			if($companyLogo != '') {
				global $imageTypes;
				PageContext::$response->companylogo =  '<img   src="'.USER_IMAGE_URL .$imageTypes['companylogothumb']['prefix']. $companyLogo.'">';
			}
		}
	}
	
	
	/*
	 * function to add visit page to session
	 */
	public static function addVisitPage($page){
	 	if($page != '') {
			if(!isset($_SESSION['smb_kb_user_visitpages'])) {
				$_SESSION['smb_kb_user_visitpages'] 		= array();
				$_SESSION['smb_kb_user_visitpages'][$page] 	= $page;
			}
			else
				$_SESSION['smb_kb_user_visitpages'][$page] 	= $page;
		}
	}
	
	/*
	 * function to check the page is visited or not
	 */
	public static function checkVisitedPage($page){
		//echopre($_SESSION['smb_kb_user_visitpages']);
		if(isset($_SESSION['smb_kb_user_visitpages'])){
		if(array_key_exists ( $page , $_SESSION['smb_kb_user_visitpages'] ))
			return true;
		else  
		 	return false;
		}
	}
	
	
	
	/*
	 * function to send email to admin
	 */
	public static function sendEmailToadmin($emailType,$replaceparams){
		$adminEmail				= Utils::getSettings('admin_email');					
     	$adminEmailAddress		= array($adminEmail=>'Admin');
     	$objMailer 				= new Mailer();
	    $objMailer->sendMail($adminEmailAddress, $emailType, $replaceparams); 
		
	}
        public static function parseContentHtml($html) { 
        $count = 0;
        $findStart = "{{";
        $findEnd = "}}";
        $positions = array();
        $imageIdArray = array();
        for ($i = 0; $i < strlen($html); $i++) {
            $startPos = strpos($html, $findStart, $count);
            $endPos = strpos($html, $findEnd, $count);
            if ($startPos == $count) {
                $positions[$startPos] = $endPos;
                $length = abs(($startPos + 2) - $endPos);
                $imageIdArray[] = substr($html, ($startPos + 2), $length);
            }
            $count++;
        }

        if ($imageIdArray) {
            foreach ($imageIdArray as $key => $value) {
                if ($value)
                    $fileArray = Managecmsdata::getFileId($value);
                if ($fileArray) {
                    $fileContent = '<img class="inside-image" src="' . Utils::getProjectFilePath($fileArray[0]->file_id) . '"';
                    if ($fileArray[0]->display_width)
                        $fileContent .= ' width="' . $fileArray[0]->display_width . '"';
                    if ($fileArray[0]->display_height)
                        $fileContent .= ' height="' . $fileArray[0]->display_height . '"';
                    if ($fileArray[0]->title)
                        $fileContent .= ' alt="' . $fileArray[0]->title . '"';
                    $fileContent .= " />";
                }
                $html = str_replace('{{' . $value . '}}', $fileContent, $html); 
            }
        } 

        return html_entity_decode(stripslashes($html));
        //return html_entity_decode(htmlentities(stripcslashes($html)));
    }



    public static function generateStrongPassword($length = 6, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }
}

?>