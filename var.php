<?php

//if ('cgi-fcgi' != php_sapi_name()) die();

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/auth.php');
require_once(DOKU_INC.'inc/common.php');

echo DOKU_INC;

?>
