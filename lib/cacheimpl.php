<?php

// Default implementation of Cache
abstract class Cacheimpl {

    abstract public function add($key, $value, $expire = 0);
    abstract public function set($key, $value, $expire = 0);
    abstract public function get($key);
    abstract public function delete($key);
}

?>