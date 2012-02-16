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
 ),
 'REGISTER' => array (
  'CHALLENGE' => array( 'sms', 'captcha' ),
//  'ID_REGEX' => '/79\d{9}/', // Russian mobile phones
 ),
 'API' => array(
  'CLOCK_SKEW' => array ( -1, +2 ), // Warning! Affects performance and CPU load
  'ALLOWED_UNAUTH_METHODS' => array('user/register'),
 ),
);