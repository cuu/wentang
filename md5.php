<?php
function g_MD5($sMess)
{
	return md5($sMess);
}

function g_CRC32($sMess)
{
	$psw = sprintf( "%u", crc32(strval($sMess."jc")));
	return $psw;
}
?>
