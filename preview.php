<?php
/*
	Create preview image
	table pid video file

*/
$ffmpegs = array('/usr/bin/ffmpeg','/usr/local/bin/ffmpeg','/opt/bin/ffmpeg',"/home/dphysus/bin/ffmpeg");
$ffmpeg_bin = "None";
$ifgd = 0;
foreach($ffmpegs as $bin)
{
	if( file_exists ($bin))
	{
		$ffmpeg_bin = $bin;
		break;
	}
}

if(function_exists ("gd_info"))
{
	$ifgd =1;	
}

if( $ffmpeg_bin == "None")
{
	printf("No FFmpeg binary found");
}
if($ifgd == 0)
{
	die("No GD library for php Found,will exit now");
}


?>
