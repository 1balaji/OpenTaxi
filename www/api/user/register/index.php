<?php
global $DB, $RQ, $USER, $CONFIG;
require_once('../../../inc/bootstrap.inc');

if($RQ['user']['id']) {
 if(check_user_id($RQ['user']['id'])) {
  if(!is_array(fetch_user_by_id($id=intval($RQ['user']['id'])))) {
   if(($len=mb_strlen($RQ['user']['nick']))>=$CONFIG['LIMITS']['NICK_LENGTH']['MIN']) {
    if($len<=$CONFIG['LIMITS']['NICK_LENGTH']['MAX']) {
     if(!is_array(fetch_user_by_nick($RQ['user']['nick']))) {
      if(preg_match('/[\da-f]{40}/',$RQ['user']['password'])) {
       if(!is_array($USER) or ((!$USER['flags']['super']) and (!$USER['flags']['dispatcher']))) {
        require_once('../../../inc/challenge.inc.php');
        challenge_first($CONFIG['REGISTER']['CHALLENGE']);
       }
       $user=array(
        'id' => $id,
        'nick' => $RQ['user']['nick'],
        'password' => $RQ['user']['password'],
        'fullname_published' => $RQ['user']['fullname_published']?true:false,
        'email_published' => $RQ['user']['email_published']?true:false
       );
       fill_if_nonempty($user,$RQ['user'],'fullname');
       fill_if_nonempty($user,$RQ['user'],'email');
       if($CONFIG['REGISTER']['DEFAULT_BLOCKED'])
       {
        $user['flags']['blocked']=true;
       }
       if($RQ['user']['flags'] and $USER['flags']['super']) {
        $user['flags']=$RQ['user']['flags'];
       }
       if(is_array($RQ['user']['car']) and car_model_exists($RQ['user']['car']['model']) and car_color_exists($RQ['user']['car']['model']) and check_car_number($RQ['user']['car']['number'])) {
        $user['car']=array(
         'model' => $RQ['user']['car']['model'],
         'color' => $RQ['user']['car']['color'],
         'number' => $RQ['user']['car']['number']
        );
        if($RQ['user']['driving']) {
         $user['driving']=true;
        }
       }
       update_user($user);
      } else {
       die('{ "err": 400, "errmsg": "invalid_syntax" }');
      }
     } else {
      die('{ "err": 405, "errmsg": "nick_taken" }');
     }
    } else {
     die('{ "err": 400, "errmsg": "nick_too_long", "errprm": ['.$CONFIG['LIMITS']['NICK_LENGTH']['MAX'].'] }');
    }
   } else {
    die('{ "err": 400, "errmsg": "nick_too_short", "errprm": ['.$CONFIG['LIMITS']['NICK_LENGTH']['MIN'].'] }');
   }
  } else {
   die('{ "err": 405, "errmsg": "id_taken" }');
  }
 } else {
  die('{ "err": 400, "errmsg": "invalid_id_given" }');
 }
} else {
 die('{ "err": 400, "errmsg": "no_id_given" }');
}