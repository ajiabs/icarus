<?php

class Cache {

	const CACHE_TYPE_APC = "apc";
	const CACHE_TYPE_MEMCACHE = "memcache";
	
    const REMOTE 	 = "remote";
    const LOCAL 	 = "local";
    
    const REMOTE_CACHE = Cache::CACHE_TYPE_APC; 
    const LOCAL_CACHE = Cache::CACHE_TYPE_APC;

    public static $disabled = false;
    public static $prefix = ENVIRONMENT;
    public static $type = Cache::REMOTE;

    public static function getInstance($type='') {
    	if(!CACHE_ENABLED)return null;
    	if(self::$disabled) return null;
        $instance = new Memcacheimpl;
        if(!$instance) return null;
        return $instance;
    }

    public static function add($key, $value, $expire = 0) {
        $instance = Cache::getInstance();
        if(!$instance)return;
        $instance->add($key, $value, $expire);
    }
    public static function set($key, $value, $expire = 0) {
        $instance = Cache::getInstance();
        if(!$instance) return;
        $instance->set($key, $value, $expire);
       
    }

    public static function get($key, $nodebug=0) {

      //  if(PageContext::$nocache) return false;
        $instance = Cache::getInstance();
        if(!$instance) return false;
        return $instance->get($key);

    }

    public static function delete($key) {
        $instance = Cache::getInstance();
        if(!$instance) return;
        $instance->delete($key);
    }

    public static function increment($key, $value=1) {
        $instance = Cache::getInstance();
        if(!$instance) return;    	
        return $instance->increment($key, $value);
    }
    
    public static function decrement($key, $value=1) {
        $instance = Cache::getInstance();
        if(!$instance) return;
        return $instance->decrement($key, $value);
    }
}
?>