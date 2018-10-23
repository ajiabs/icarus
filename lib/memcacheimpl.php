<?php

class Memcacheimpl extends Cacheimpl {

    private $memcache = null;
    public function __construct() {
        $this->memcache = new Memcache();
        try{
        	$this->memcache->addServer(CACHE_SERVER, CACHE_PORT);
        }catch(error $e){
        	return false; //connection issue
        }
		//        $servers = explode(',', MEMCACHE_SERVERS);
		//        foreach($servers as $server) {
		//            $this->memcache->addServer($server);
		//        }
    }

    public function add($key, $value, $expire = 0) {
         return $this->memcache->add($key, $value, 0, $expire);
    }

     public function set($key, $value, $expire = 0) {
         return $this->memcache->set($key, $value, 0, $expire);
     }
     public function get($key) {
         return $this->memcache->get($key);
     }
     public function delete($key, $timeout = 0) {
         return $this->memcache->delete($key, $timeout);
     }
     public function replace($key, $value, $expire) {
         return $this->memcache->replace($key, $value, 0, $expire);
     }
     public function increment($key, $value = 1) {
          $this->memcache->add($key, 0);
          return $this->memcache->increment($key, $value);
     }
     public function decrement($key, $value = 1) {
         return $this->memcache->decrement($key, $value);
     }
}

?>