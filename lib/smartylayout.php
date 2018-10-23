<?php
require_once('./public/smarty/SmartyBC.class.php');
Class Smartylayout extends SmartyBC
{
	function __construct()
	{
	
		// Class Constructor.
		// These automatically get set with each new instance.
	
		parent::__construct();
		$basepath=getcwd();
		$this->setCacheDir($basepath."/project/temp/");
		$this->setCompileDir($basepath."/project/temp/templates_c");
		$this->setPluginsDir(array(
				$basepath."/public/smarty/plugins/",
				$basepath."/project/smartyplugin/",
		));
		//$this->caching = Smarty::CACHING_LIFETIME_CURRENT;

		
	}

	
}