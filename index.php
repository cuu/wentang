<?php
/**
 * Forwarder to doku.php
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 */
if( count($_GET) == 0)
{
	header("Location: index.php?id=start&do=splash");
}
else
{
	include_once "doku.php";
}
?>
