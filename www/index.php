<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="styles.css"/>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/opentaxi.js"></script>
<script type="text/javascript">
<?php

if($_GET['lang']) {
 $lang=$_GET['lang'];
 setcookie('lang',$lang);
} else {
 require_once('inc/cache.inc.php');
 cache_init();
 if(cache_isset('taxi_lang_available')) {
  $lang_avail=cache_get('taxi_lang_available');
 } else {
  $lang_avail=json_decode(file_get_contents('lang/index.json'),true);
  cache_set('taxi_lang_available',$lang_avail,3600);
 }
 foreach(explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']) as $l) {
  $l=explode(';',$l);
  $l=explode('-',$l[0]);
  if(in_array($lang[0],$lang_avail)) {
   $lang_detect=$l[0];
   break;
  }
 }
 $lang=$lang_detect?$lang_detect:'en';
}

echo "var lang_detect='".$lang."';";

?>
</script>
</head>
<body>
</body>
</html>