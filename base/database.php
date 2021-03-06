<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | Singleton Database Class                                             |
// | File name : database.php                                             |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// | Author: Armia Systems<info@armia.com>              |
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems &copy; 2018                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// |   ICARUS is free software: you can redistribute it and/or modify
// |   it under the terms of the GNU General Public License as published by
// |   the Free Software Foundation, either version 3 of the License, or
// |   (at your option) any later version.

// |   ICARUS is distributed in the hope that it will be useful,
// |   but WITHOUT ANY WARRANTY; without even the implied warranty of
// |   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// |   GNU General Public License for more details.

// |   You should have received a copy of the GNU General Public License
// |   along with ICARUS.  If not, see <https://www.gnu.org/licenses/>.   
// |
// +----------------------------------------------------------------------+

class BaseDatabase
{
    /**
    * Instance of this
    * @var instance
    **/
    private static $_instance = null;
    /**
    * Database connection
    * @var object
    **/
    private static $_connection = null;



    /**
    * constructor
    **/
    public function __construct()
    {
        
    }
    /**
    * Method to get instance of AbstractDatabase
    * @return object $_instance
    **/
    public static function getInstance()
    {
        if (self::$_instance == null) 
        {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    /**
    * Method to connect mysql server
    **/
    public function _connect($host='',$uname='',$pwd='',$database='')
    {
    
         
        if($host){
            if (!empty(self::$_connection)) 
                self::$_connection = null;//@mysql_close(self::$_connection);
         if (!is_resource(self::$_connection)) {
            
            
               
                
                try {
                    // echo $host.'*****'.$uname.'******'.$pwd.'<br/>';
                    self::$_connection =  new PDO('mysql:host='.$host.';dbname='.$database, $uname, $pwd);
                    $options = array(
                        PDO::ATTR_PERSISTENT => true, 
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    );
                } catch (PDOException $e) {
                    echo 'Connection failed: ' . $e->getMessage();die;
                }
            }
        }else{
            if (!is_resource(self::$_connection)) {
               
                if (self::$_connection != null && empty(self::$_connection) != false) {
                    
                     @mysqli_close(self::$_connection);
                }
                 
                 
                // self::$_connection = @mysql_connect(MYSQL_HOST, MYSQL_USERNAME, MYSQL_PASSWORD)
                //$this->_connection =  new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB, MYSQL_USERNAME, MYSQL_PASSWORD);
                //        or die(mysql_error());
                // mysql_select_db(MYSQL_DB);
            }
        }

    }

    public function getDb() {
       // if ($this->_connection instanceof PDO) {
       //      return $this->_connection;
       // }
       if (self::$_connection instanceof PDO) {
            return self::$_connection;
       }
    }  





    /**
    * Method to close mysql connection
    **/
    public function close()
    {
        if (is_resource(self::$_connection)) 
        {
            // mysql_close(self::$_connection);
            $this->_connection =null;
        }
    }
    /**
    * Destructor
    **/
    public function __destruct()
    {
        //Close sql connection
       $this->close();
    }
}
?>