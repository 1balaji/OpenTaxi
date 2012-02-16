function challenge_captcha_generate($RQ) {
 return $RQ['id'];
}

function challenge_captcha_check($data) {
 $key='taxi_captcha_'.$RQ['id'];
 return cache_isset($key) and ( cache_get($key)==$data );
}
