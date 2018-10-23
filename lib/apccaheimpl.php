<?php

class Apccacheimpl extends Cacheimpl {

    private $apccache = null;
    public function __construct() {
        $this->apccache = new apccache();
       
    }

    public function add($key, $value, $expire = 0) {
       return $this->apccache->apc_add($key, $value, 0, $expire);
    }

     public function set($key, $value, $expire = 0) {
        return $this->apccache->apc_store($key, $value, 0, $expire);
     }
     public function get($key) {
         return $this->apccache->apc_fetch($key);    
     }
     public function delete($key) {
         return $this->apccache->apc_delete($key);
        }
}
?>
