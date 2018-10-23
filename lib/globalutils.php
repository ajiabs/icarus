<?php

class Globalutils{
	
	//create alias for any entity
	public static function checkAndValidateEntityAlias($table_name, $alias_text, $id_column="id",$id = "", $alias_column="alias") {
	
		//format alias 
		$alias = str_replace("&amp;", "and", $alias_text);
		$alias = htmlspecialchars_decode($alias, ENT_QUOTES);
		$alias = str_replace("-", " ", $alias);
		$alias = preg_replace("/[^a-zA-Z0-9\s]/", "", $alias);
		$alias = preg_replace('/[\r\n\s]+/xms', ' ', trim($alias));
		$alias = strtolower(str_replace(" ", "-", $alias));
		
		$dbh = new Db();
		//check for duplicates
		$sql = "select count(*) as total from $table_name where $alias_column = '".$alias."'";
		if ($id) $sql .= " and $id_column <> $id";
		$duplicates = $dbh->fetchSingleRow($sql);

		//if duplicates exist recursively create a new alias and try
		if ($duplicates->total > 0) {
			$rand_str = Globalutils::rand_str(4);
			return self::checkAndValidateEntityAlias($table_name, $alias."-".$rand_str,$id_column, $id,$alias_column);
		}

		return strtolower($alias);
	}
	
	//creates a random string
	public static function rand_str($length = 32, $chars = 'abcdefghijklmnopqrstuvwxyz1234567890')
	{
		// Length of character list
		$chars_length = (strlen($chars) - 1);

		// Start our string
		$string = $chars{rand(0, $chars_length)};

		// Generate random string
		for ($i = 1; $i < $length; $i = strlen($string))
		{
			// Grab a random character from our list
			$r = $chars{rand(0, $chars_length)};

			// Make sure the same two characters don't appear next to each other
			if ($r != $string{$i - 1}) $string .=  $r;
		}

		// Return the string
		return $string;
	}
	
}
?>