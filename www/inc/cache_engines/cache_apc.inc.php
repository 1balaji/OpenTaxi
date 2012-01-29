<?php

function cache_init() {
}

function cache_isset($key) {
 return apc_exists($key);
}

function cache_get($key) {
 return apc_fetch($key);
}

function cache_set($key, $value, $TTL=300) { //Default TTL=5min
 return apc_store($key, $value, $TTL); 
}

function cache_unset($key) {
 return apc_delete($key);
}