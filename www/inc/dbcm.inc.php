<?php

// Database and cache management
// =============================

global $DB, $CONFIG;

require_once(__DIR__.'/config.inc.php');
require_once(__DIR__.'/cache.inc.php');
cache_init();

function connect_db() {
 global $DB, $CONFIG;
 if(!is_a($DB,'MongoDB')) {
  try {
   $Mongo=new Mongo();
   $DB=$Mongo->selectDB($CONFIG['MONGO']['DB']);
  } catch (MongoConnectionException $e) {
   header('HTTP/1.0 500 Internal Server Error');
   die();
  }
 }
}

// User functions
// ~~~~~~~~~~~~~~

// Fetch user by ID
function fetch_user_by_id($id) {
 if(!cache_isset('taxi_!uid_'.$id)) {
  if(cache_isset('taxi_uid_'.$id)) {
   return cache_get('taxi_uid_'.$id);
  } else {
   global $DB;
   connect_db();
   $result=$DB->users->findOne(['id'=>$id]);
   if(is_array($result)) {
    cache_set('taxi_uid_'.$id,$result);
   } else {
    cache_set('taxi_!uid_'.$id,true)
   }
   return $result;
  }
 }
}

// Fetch user by nick
function fetch_user_by_nick($nick) {
 if(!cache_isset('taxi_!un_'.$nick)) {
  if(cache_isset('taxi_un_'.$nick)) {
   return fetch_user_by_id(cache_get('taxi_un_'.$nick));
  } else {
   global $DB;
   connect_db();
   $result=$DB->users->findOne(['nick'=>$nick]);
   if(is_array($result)) {
    cache_set('taxi_uid_'.$result['id'],$result);
    cache_set('taxi_un_'.$result['nick'],$result['id']);
   } else {
    cache_set('taxi_!un_'.$nick);
   }
   return $result;
  }
 }
}

// Update user
function update_user($user) {
 global $DB;
 connect_db();
 $DB->users->update(
  array('id'=>$user['id']),
  $user,
  array('upsert'=>true)
 );
 cache_unset('taxi_!uid_'.$user['id']);
 cache_set('taxi_uid_'.$user['id'],$user);
 cache_unset('taxi_!un_'.$user['nick']);
 cache_set('taxi_un_'.$user['nick'],$user['id']);
}

// Cache cleanup
function cleanup_user($user) {
 cache_unset('taxi_!uid_'.$user['id']);
 cache_unset('taxi_uid_'.$user['id']);
 cache_unset('taxi_!un_'.$user['nick']);
 cache_unset('taxi_un_'.$user['nick']);
}

// Car functions
// ~~~~~~~~~~~~~
function get_car_models() {
 if(cache_isset('taxi_car_models')) {
  return cache_get('taxi_car_models');
 } else {
  global $DB;
  connect_db();
  $models=iterator_to_array($DB->car_models->find());
  cache_set('taxi_car_models',$models);
  return $models;
 }
}

function model_exists($model) {
 return in_array($model,get_car_models());
}

function get_car_colors() {
 if(cache_isset('taxi_car_colors')) {
  return cache_get('taxi_car_colors');
 } else {
  global $DB;
  connect_db();
  $colors=iterator_to_array($DB->car_colors->find());
  cache_set('taxi_car_colors',$colors);
  return $colors;
 }
}

function color_exists($color) {
 return in_array($color,get_car_colors());
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

function check_user_id($id) {
 global $CONFIG;
 return preg_match('/\d{11,12}/', $id) and ((!$CONFIG['REGISTER']['ID_REGEX']) or preg_match($CONFIG['REGISTER']['ID_REGEX'],$id));
}

function check_car_number($id) {
 global $CONFIG;
 return (!$CONFIG['REGISTER']['CAR_NUMBER_REGEX']) or preg_match($CONFIG['REGISTER']['CAR_NUMBER_REGEX'],$id);
}
