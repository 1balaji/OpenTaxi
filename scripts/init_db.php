<?php

$Mongo=new Mongo();
$DB=$Mongo->selectDB('opentaxi');

$DB->users->ensureIndex(array('id'=>1),array('unique'=>true));
$DB->users->ensureIndex(array('nick'=>1),array('unique'=>true));
$DB->users->ensureIndex(array('location_current'=>'2d'));
$DB->users->ensureIndex(array('location_target'=>'2d'));

if(!is_array($DB->users->findOne(array('id'=>0)))) {
 $DB->users->insert(
  array(
   'id'=>'0',
   'nick'=>'root',
   'password'=>sha1('opentaxi'),
   'flags'=>array('super'=>true)
  )
 );
}
