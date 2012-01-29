<?php
global $DB, $RQ, $USER;
require_once('../../../inc/bootstrap.inc');

if($RQ['nick']) {
 if(is_array($user=fetch_user_by_nick($RQ['nick']))) {
  if($USER['flags']['super']) {
   echo json_encode($user);
  } else {
   $result=array('nick'=>$user['nick']);
   fill_if_published($result,$user,'fullname');
   fill_if_published($result,$user,'email');
   fill_if_nonempty($result,$user,'car');
   fill_if_nonempty($result,$user,'driving');
   fill_if_nonempty($result,$user,'PD_public');
   echo json_encode($result);
  }
 } else {
  die('{ "err": 404 }');
 }
} else {
 echo json_encode($USER);
}