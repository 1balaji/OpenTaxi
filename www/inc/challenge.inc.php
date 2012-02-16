global $RQ;

function challenge_avail($type) {
 if(cache_isset('taxi_challenge_avail_'.$type)) {
  return cache_get('taxi_challenge_avail_'.$type);
 } else
  $result=is_file(__DIR__.'/challenge/'.$type.'.inc.php');
  cache_set('taxi_challenge_avail_'.$type, $result);
  return $result;
 }
}

function challenge($type) {
 require_once(__DIR__.'/challenge/'.$type.'.inc.php');
 if($RQ['response'] and $RQ['response']['type']==$type) {
  return eval('challenge_'.$type.'_check($RQ["response"]["data"]);');
 } else {
  $data=eval('challenge_'.$type.'_generate($RQ);');
  die('{ "err": 411, "errmsg": "challenge", "challenge": { "type": '.json_encode($type).', "data": '.json_encode($data).' } }');
 }
}

function challenge_first($types) {
 foreach($types as $type) {
  if(challenge_avail($type)) {
   return challenge($type, $msg);
  }
 }
}