global $CONFIG;

$CONFIG=array(
 'MONGO' => array(
  'DB' => 'opentaxi',
 ),
 'DEFAULTS' => array(
  'LANG' => 'en',
 ),
 'LIMITS' => array(
  'NICK_LENGTH' => array( 'MIN'=> 6, 'MAX'=>64 ),
  'PD_PRIVATE_LENGTH' => 16384,
  'PD_PUBLIC_LENGTH' => 16384,
//  'ID_REGEX' => '/79\d{9}/', // Additional ID constraint: Russian mobile phones
 ),
 'REGISTER' => array (
  'CHALLENGE' => array( 'sms', 'captcha' ),
 ),
 'API' => array(
  'ALLOWED_CLOCK_SKEW' => array ( -2, +1 ), // *10 seconds, inclusive. Warning! Extending skew limits affects performance and CPU load
  'ALLOWED_UNAUTH_METHODS' => array('user/register', 'car/list_colors', 'car/list_models'),
 ),
);