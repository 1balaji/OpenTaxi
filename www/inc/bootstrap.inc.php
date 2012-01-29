<?php

global $DB, $RQ, $USER;

if(is_array($RQ=json_decode(file_get_contents('php://input'),true))) {
 $RQ['id']=intval($RQ['id']);
 if($RQ['id'] and $RQ['signature']) {
  try {
   $Mongo=new Mongo();
   $DB=$Mongo->selectDB('opentaxi');
  } catch (MongoConnectionException $e) {
   die('{ "err": 500, "errmsg": "'.$e->getMessage().'" }');
  }
  require_once(__DIR__.'/dbcm.inc.php');
  if(!is_array($USER=fetch_user_by_id($RQ['id']))) {
   die('{ "err": 401 }');
  }
  if($USER['flags']['blocked']) {
   die('{ "err": 401 }');
  }
  list(,$method)=explode('/',trim($_SERVER['REQUEST_URI'],'/'),2);
  $t=(gmmktime()/10);
  $found=false;
  $mup=$method.$USER['id'].$USER['password'];
  for($i=t-1;$i<t+2;$i++) {
   if(sha1($mup.$i)==$RQ['signature']) {
    $found=true;
    break;
   }
  }
  if(!$found) {
   die('{ "err": 401 }');
  }
 } else {
  die('{ "err": 400, "errmsg": "No ID and/or signature" }');
 }
} else {
 die('{ "err": 400, "errmsg": "Bad JSON syntax" }');
}
