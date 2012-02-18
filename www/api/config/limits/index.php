<?php
global $DB, $RQ, $USER, $CONFIG;
require_once('../../../inc/bootstrap.inc');

return json_encode($CONFIG['LIMITS']);
