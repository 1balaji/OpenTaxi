<?php

function make_captcha($id) {
 require('kcaptcha/kcaptcha.php');
 $captcha = new KCAPTCHA();
 cache_set('taxi_captcha_'.$id, $captcha->getKeyString() );
 die();
}

if($id=intval($_GET['id']) and preg_match('/\d{11,12}/',$_GET['id'])){
 require('inc/dbcm.php');
 if(cache_isset('taxi_captcha_'.$id)) {
  make_captcha($id);
 } else {
  if(fetch_user_by_id($id)) {
   make_captcha($id);
  } else {
   header('HTTP/1.0 404 Not Found');
  }
 }
} else {
 header('HTTP/1.0 400 Bad Request');
}

?>