<?php

// Database and cache management
// =============================

global $DB;

require_once(__DIR__.'/cache.inc.php');
cache_init();

// User functions
// ~~~~~~~~~~~~~~

// Fetch user by ID
function fetch_user_by_id($id) {
 if(cache_isset('taxi_uid_'.$id)) {
  return cache_get('taxi_uid_'.$id);
 } else {
  $result=$DB->users->findOne(['id'=>$id]);
  if(is_array($result)) {
   cache_set('taxi_uid_'.$id,$result);
  }
  return $result;
 }
}

// Fetch user by nick
function fetch_user_by_nick($nick) {
 if(cache_isset('taxi_un_'.$nick)) {
  return fetch_user_by_id(cache_get('taxi_un_'.$nick));
 } else {
  $result=$DB->users->findOne(['nick'=>$nick]);
  if(is_array($result)) {
   cache_set('taxi_uid_'.$result['id'],$result);
   cache_set('taxi_un_'.$result['nick'],$result['id']);
  }
  return $result;
 }
}

// Update user
function update_user($user) {
 $DB->users->update(
  array('id'=>$user['id']),
  $user,
  array('upsert'=>true)
 );
 cache_set('taxi_uid_'.$user['id'],$user);
 cache_set('taxi_un_'.$user['nick'],$user['id']);
}

// Cache cleanup
function cleanup_user($user) {
 cache_unset('taxi_uid_'.$user['id'],$user);
 cache_unset('taxi_un_'.$user['nick'],$user['id']);
}

// Utility functions
// ~~~~~~~~~~~~~~~~~

function fill_if_nonempty(&$data, &$src_data, $field) {
 if($src_data[$field]) {
  $data[$field]=$src_data[$field];
 }
}

function fill_if_published(&$data, &$src_data, $field) {
 if($src_data[$field.'_published']) {
  $data[$field]=$src_data[$field];
 }
}
