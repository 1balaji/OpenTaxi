<?php

global $DB, $RQ, $USER;

function try_auth($id, $signature) {
}

if(is_array($RQ=json_decode(file_get_contents('php://input'),true))) {
 $RQ['id']=intval($RQ['id']);
 list(,$method)=explode('/',trim($_SERVER['REQUEST_URI'],'/'),2);
 if($RQ['id'] and preg_match('/\d{11,12}/', $RQ['id'])) {
  require_once(__DIR__.'/config.inc.php');
  require_once(__DIR__.'/dbcm.inc.php');
  if(is_array($USER=fetch_user_by_id($RQ['id']))) {
   if($USER['flags']['blocked']) {
    die('{ "err": 401, "errmsg": "bad_id_or_signature" }');
   }
   $t=(gmmktime()/10);
   $signed=false;
   $mup=$method.$USER['id'].$USER['password'];
   for($i=t+$CONFIG['API']['CLOCK_SKEW'][0];$i<t+$CONFIG['API']['CLOCK_SKEW'][1];$i++) {
    if(sha1($mup.$i)==$RQ['signature']) {
     $signed=true;
     break;
    }
   }
   if(!$signed) {
    die('{ "err": 401, "errmsg": "bad_id_or_signature" }');
   }
  } else {
   die('{ "err": 401, "errmsg": "bad_id_or_signature" }');
  }
 } else {
  if($allowed_unauth=in_array($method,$CONFIG['API']['ALLOWED_UNAUTH_METHODS'])) {
   require_once(__DIR__.'/config.inc.php');
   require_once(__DIR__.'/dbcm.inc.php');
  } else {
   die('{ "err": 401, "errmsg": "bad_id_or_signature" }');
  }
 }
} else {
 die('{ "err": 400, "errmsg": "bad_json_syntax" }');
}
