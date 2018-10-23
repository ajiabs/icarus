<?php

class imagemagickwrapper {

	private $cmd_path;
	
	public function imagemagickwrapper() {
		$this->cmd_path = defined('IMAGE_MAGICK_PATH')?IMAGE_MAGICK_PATH:"";
	}

	public function version() {
		$cmd = $this->cmd_path . " -version";
		return exec($cmd, $out, $ret);
	}

	public function execute($files, $command, $options="", $stoponerror=true){
		$cmd = $this->cmd_path . "$command";
		if($options) {
			$cmd .= " " . $this->serializeOptions($options);
		}

		if($files) {
			if($files instanceof Imagemagickfile) {
				$files = array($files);
			}
			foreach($files as $file) {
				$cmd .= " " . $this->serializeOptions($file->options) . " " . $file->path;
			}
		}

		$cmd .= " 2>&1";
		$this->debug($cmd);
		exec($cmd, $out, $ret);
		//$this->debug(implode("\n", $out));
		if($ret != 0 && $stoponerror) {
			throw new Exception("Command [$cmd] failed");
		}
		return implode("\n", $out);
	}

	private function serializeOptions($options) {
		$out = "";
		foreach((array)$options as $key => $value) {
			if(is_numeric($key)) {
				$out .= " $value";
			}
			else {
				$out .= " $key";
				if($value) $out .= " \"$value\"";
			}
		}
		return $out;

	}

	public function debug($msg) {
		$debug = 1;
		if($debug) {
			Logger::info($msg);
		}
	}
	public function help() {
		return $this->execute("", "help");
	}
	
  private function getValue($value) {
    $value = preg_replace('/[\s,]+/', '', $value);
    if(preg_match('/(k|m)$/i', $value, $matches)) {
      $mult = (strtolower($matches[1]) == 'k')?1000:1000000;
      return $mult * $value;      
    } 
    return $value;
  }

	public function identify($file) {
		$data = $this->execute(new Imagemagickfile($file), "identify", array("-verbose"));
    preg_match_all("/^\s\s(\w+):(.*?)$/msi", $data, $matches);
    $values = array();
    for($i=0;$i<count($matches[1]);$i++) {
    	$values[$matches[1][$i]] = trim($matches[2][$i]);
    }
    $info = array();
    list($info['width'], $info['height']) = explode("x", $values['Geometry']);
    $info['format'] = preg_replace("/^(\w+).*/", "$1", $values['Format']);
    $info['filesize'] = $this->getValue($values['Filesize']);
  	 return $info;
  }
  
}

class Imagemagickfile {
	public $path;
	public $options;
	public function Imagemagickfile($path, $options=array()) {
		$this->path = escapeshellarg($path);
		$this->options = $options;
	}
}

?>