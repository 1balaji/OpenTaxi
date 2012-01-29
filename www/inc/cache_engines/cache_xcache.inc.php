<?php

function cache_init() {
}

function cache_isset($key) {
 return xcache_isset($key);
}

function cache_get($key) {
 return xcache_get($key);
}

function cache_set($key, $value, $TTL=300) { //Default TTL=5min
 return xcache_set($key, $value, $TTL);
}

function cache_unset($key) {
 return xcache_unset($key);
}