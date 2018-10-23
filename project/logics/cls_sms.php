<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : Payment.php                                         		  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems ï¿½ 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Sms{
	
	/**
	 * Function to test the login credentials for BBN
	 * @param unknown $appid
	 * @param unknown $userName
	 * @param unknown $password
	 * @return Ambigous <string, mixed>
	 */
	public static function testLogin($appid=null,$userName=null,$password=null,$gateway="BBN")
	{
		
		switch($gateway)
		{
			case "BBN":
				{
					if(is_null($appid) || is_null($userName) || is_null($password))
					{
						return "Invalid Credentials";
						exit();
					}
					PageContext::includePath('smsgateways/bbn');
					$config = array('appid'=>$appid,'callback'=>1);
					$messageObj = new BSGateway($config);
					return $messageObj->tryLogin($userName,$password);
					break;
				}
		}
		
	}
	/**
	 * Fuction to check accoutn balance
	 * @param string $appid
	 * @param string $userName
	 * @param string $password
	 * @param string $gateway
	 * @return Ambigous <string, mixed>
	 */
	
	public static function checkBalance($appid=null,$userName=null,$password=null,$gateway="BBN") 
	{
		switch($gateway)
		{
			case "BBN":
				{
					if(is_null($appid) || is_null($userName) || is_null($password))
					{
						return "Invalid Credentials";
						exit();
					}
					PageContext::includePath('smsgateways/bbn');
					$config = array('appid'=>$appid,'callback'=>1);
					$messageObj = new BSGateway($config);
					$account_balance=$messageObj->checkBalance($userName,$password);
					return $account_balance;
					break;
				}
		}
		
	}
	/**
	 * 
	 * @param string $appid
	 * @param string $userName
	 * @param string $password
	 * @param string $senderName A 14 digit number or 11 characters alphanumeric text
	 * @param string $toNumberArray 
	 * @param unknown $message  The content of the text which is targeted at the recipient
	 * @param string $messageUniqeid
	 * @param string $gateway
	 * @return Ambigous <string, mixed>
	 */
	public static function sendMessage($appid=null,$userName=null,$password=null,$senderName=null,$toNumberArray=null,$message,$messageUniqeid=null,$gateway="BBN")
	{
		//Converting Number Array to comma seperted values
		foreach ($toNumberArray as $to)
		{
			$toNumber=$to.",";
		}
		
		$toNumber=rtrim($toNumber, ",");
		
		
		// Validations
		
		if(is_numeric($senderName))
		{
			if($senderName>99999999999999)
			{
				return "Invalid Sender Name";
				exit();
			}
		}
		else if (count($var)>11)
		{
			return "Invalid Sender Name";
			exit();
		}
		
		if (is_null($message))
		{
			return "Invalid Message";
			exit();
			
		}
		
		if(count($message)>160)
		{
			return "Message should be less than 160 character";
			exit();
		}

		//Sending SMS based on Gateways
		
		switch($gateway)
		{
			case "BBN":
				{
					if(is_null($appid) || is_null($userName) || is_null($password))
					{
						return "Invalid Credentials";
						exit();
					}
					$BBN_Errors=array("1800" => "Request timeout",
									  "1801 " => "Message successfully sent",
									  "1802 " => "Invalid username",
							          "1803 " => "Incorrect password",
							          "1804 " => "Insufficient credit",
							          "1806 " => "Invalid mobile",
									  "1807 " => "Invalid sender id",
									  "1808 " => "Message too long",
									  "1809 " => "Empty Message");
						
					PageContext::includePath('smsgateways/bbn');
					$config = array('appid'=>$appid,'callback'=>1);
					$messageObj = new BSGateway($config);
					$message_response=$messageObj->sendMessage($userName,$password,$senderName,$toNumber,$message,0,$messageUniqeid);
					return $message_response;
					break;
				}
		}
	
	}
	
	
}
