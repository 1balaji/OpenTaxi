<?php
global $DB, $RQ, $USER, $CONFIG;
require_once('../../../inc/bootstrap.inc');

if($RQ['id']) {
 if(preg_match('/\d{11,12}/', $RQ['id'])) {
  if(($len=mb_strlen($RQ['user']['nick']))>=$CONFIG['LIMITS']['NICK_LENGTH']['MIN']) {
   if($len<=$CONFIG['LIMITS']['NICK_LENGTH']['MAX']) {
    if(preg_match('/[\da-f]{40}/',$RQ['user']['password'])) {
     if(!is_array($USER) or ((!$USER['flags']['super']) and (!$USER['flags']['dispatcher']))) {
      require_once('../../../inc/challenge.inc.php');
      challenge_first($CONFIG['REGISTER']['CHALLENGE']);
     }
     // TODO: actual registration
    } else {
     die('{ "err": 400, "errmsg": "invalid_syntax" }');
    }
   } else {
    die('{ "err": 400, "errmsg": "nick_too_long", "errprm": ['.$CONFIG['LIMITS']['NICK_LENGTH']['MAX'].'] }');
   }
  } else {
   die('{ "err": 400, "errmsg": "nick_too_short", "errprm": ['.$CONFIG['LIMITS']['NICK_LENGTH']['MIN'].'] }');
  }
 } else {
  die('{ "err": 400, "errmsg": "invalid_id_given" }');
 }
} else {
 die('{ "err": 400, "errmsg": "no_id_given" }');
}