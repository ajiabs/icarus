<?php
class LanguageTranslator
{
	public static $lang="en";
	
	
	
	private function getTranslator($message)
	{
		
		
		if(is_file($file="./project/resources/lang_".LanguageTranslator::$lang.".txt"))
			{
				
				if($data=file_get_contents($file))
					{
						$data_array=explode(";", $data);
						foreach ($data_array as $data)
						{	$pair=explode("=",$data);
							if(strcmp(trim($pair[0]), $message)==0)
							{
								return $pair[1];
							}
						}
						
			
			
					}
			}
		elseif(is_file($file="./resources/lang_".LanguageTranslator::$lang.".txt"))
			{
			
				if($data=file_get_contents($file))
					{
						$data_array=explode(";", $data);
						
						foreach ($data_array as $data)
						{	$pair=explode("=",$data);
							if(strcmp(trim($pair[0]), $message)==0)
							{
								return $pair[1];
							}
						}
						
			
			
					}
			}
		
		
		
			

	}
		

	public static function translator($message,$replacement)
	{

	$transmessage=LanguageTranslator::getTranslator($message);
	$i=0;
	while(!(strpos($transmessage,"[]")===FALSE))
	{
	$transmessage=preg_replace('/\[\]/', $replacement[$i], $transmessage, 1);
	$i=$i+1;
	
	}
	return 	$transmessage;
	}
	
	public static function translator_constant() ///Function to support previous compactablity issue
	{
		
		if(is_file($file="./project/resources/lang_".LanguageTranslator::$lang.".txt"))
		{
		
			if($data=file_get_contents($file))
			{
				$data_array=explode(";", $data);
				foreach ($data_array as $data)
				{	
					$pair=explode("=",$data);
					if(!defined ($pair[0]))
					define(trim($pair[0]),$pair[1]);
				}
		
					
					
			}
		}
		if(is_file($file="./resources/lang_".LanguageTranslator::$lang.".txt"))
			{
				if($data=file_get_contents($file))
					{
						$data_array=explode(";", $data);
						foreach ($data_array as $data)
							{	
								$pair=explode("=",$data);
								if(!defined ($pair[0]))
								define(trim($pair[0]),$pair[1]);
							}
		
					
					
					}
			}
		
	}
	
	public static function getLocalization()
	{
		if(isSet($_GET['lang']))
		{
			
			LanguageTranslator::$lang = $_GET['lang'];
			$_SESSION['lang'] = $lang;
			setcookie('lang', $lang, time() + (3600 * 24 * 30));
		}
		elseif(isSet($_SESSION['lang']))
		{
			LanguageTranslator::$lang = $_SESSION['lang'];
		}
		elseif(isSet($_COOKIE['lang']))
		{
			LanguageTranslator::$lang=$_COOKIE['lang'];
		}
		else
		{
			LanguageTranslator::$lang=DEFAULT_LANGUAGE;
		}
		
		if(!is_file("./resources/lang_".LanguageTranslator::$lang.".txt") && !is_file("./project/resources/lang_".LanguageTranslator::$lang.".txt"))
		{
			LanguageTranslator::$lang=DEFAULT_LANGUAGE;
		}
	}
}
?>
