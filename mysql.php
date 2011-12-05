<?php

if ('cgi-fcgi' != php_sapi_name()) die();

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/');
require_once(DOKU_INC.'inc/init.php');

$sqlsrv = "127.0.0.1";
$sqlusr = "root";
$sqlpas = "";
$sqldb  = "guu_wentang";



?>
