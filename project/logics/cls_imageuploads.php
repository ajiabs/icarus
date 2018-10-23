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

class Imageuploads {
    /*
     * Function to upload and resize image
     */

    public static function imageUpload($data) {
        die("1");
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

}

?>