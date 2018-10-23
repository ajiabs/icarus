<?php    
    
    echo "<hr/>";
    
    //set it to writable location, a place for temp generated PNG files
    echo$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    echo'<br>'.$PNG_WEB_DIR = 'temp/';

    include "qrlib.php";    
   echo'<br>'. $filename = $PNG_TEMP_DIR.'test.png';
    
    QRcode::png('abcde', $filename, 'L', 6, 2);    
    echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
    
  

    