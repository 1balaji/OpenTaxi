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

$DB->car_models->ensureIndex(array('model'=>1),array('unique'=>true));
if($DB->car_models->count()==0) {
 $DB->car_models->insert(array( 'model'=>'alfaromeo' ));
}

$DB->car_colors->ensureIndex(array('color'=>1),array('unique'=>true));
if($DB->car_colors->count()==0) {
 $DB->car_colors->insert(array( 'color'=>'black' ));
 $DB->car_colors->insert(array( 'color'=>'white' ));
 $DB->car_colors->insert(array( 'color'=>'red' ));
 $DB->car_colors->insert(array( 'color'=>'yellow' ));
 $DB->car_colors->insert(array( 'color'=>'green' ));
 $DB->car_colors->insert(array( 'color'=>'blue' ));
 $DB->car_colors->insert(array( 'color'=>'purple' ));
 $DB->car_colors->insert(array( 'color'=>'maroon' ));
 $DB->car_colors->insert(array( 'color'=>'beige' ));
 $DB->car_colors->insert(array( 'color'=>'silver' ));
 $DB->car_colors->insert(array( 'color'=>'golden' ));
 $DB->car_colors->insert(array( 'color'=>'other_dark' ));
 $DB->car_colors->insert(array( 'color'=>'other_bright' ));
}

