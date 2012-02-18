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
 $DB->car_models->insert(array( 'model'=>'audi' ));
 $DB->car_models->insert(array( 'model'=>'bmw' ));
 $DB->car_models->insert(array( 'model'=>'chevrolet' ));
 $DB->car_models->insert(array( 'model'=>'citroen' ));
 $DB->car_models->insert(array( 'model'=>'ford' ));
 $DB->car_models->insert(array( 'model'=>'honda' ));
 $DB->car_models->insert(array( 'model'=>'hyundai' ));
 $DB->car_models->insert(array( 'model'=>'lada_classic' ));
 $DB->car_models->insert(array( 'model'=>'lada_modern' ));
 $DB->car_models->insert(array( 'model'=>'mazda' ));
 $DB->car_models->insert(array( 'model'=>'mercedes' ));
 $DB->car_models->insert(array( 'model'=>'nissan' ));
 $DB->car_models->insert(array( 'model'=>'opel' ));
 $DB->car_models->insert(array( 'model'=>'peugeot' ));
 $DB->car_models->insert(array( 'model'=>'toyota' ));
 $DB->car_models->insert(array( 'model'=>'volga' ));
 $DB->car_models->insert(array( 'model'=>'volkswagen' ));
 $DB->car_models->insert(array( 'model'=>'volvo' ));
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

