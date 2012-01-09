<?php
/*
	Create preview image
	table pid video file

*/

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/');

include_once (DOKU_INC."function.php");
include_once (DOKU_INC."md5.php");
/*
$INFO = pageinfo();
if($INFO["isadmin"] !== TRUE) { die("You dont have access rights " ); }
*/

function json_return($array)
{
	return htmlspecialchars(json_encode( $array ), ENT_NOQUOTES);
}

function mbmGetFLVDuration($file,$ffbin)
{
	
	$time =  exec($ffbin." -i ".$file." 2>&1 | grep Duration | cut -d ' ' -f 4 | sed s/,//");
	$duration = explode(":",$time);  

	$duration_in_seconds = $duration[0]*3600 + $duration[1]*60+ round($duration[2]);    
	return $duration_in_seconds;  
      
} 

function random_duration($dur)
{
	if( (int)$dur < 11) return 5;

	return rand(1, (int)$dur - 10);
}

function get_out_file_name($format)
{
	return g_CRC32(now()).".".$format;
}

function create_video_thumb($flv,$ffbin)
{
	$output = array();
	$duration = mbmGetFLVDuration($flv,$ffbin);
	$ss = random_duration($duration);
	$outfile = get_out_file_name("jpg");

	$cmd_line = $ffbin."  -ss ".$ss." -i ".$flv." -f image2 -vframes 1 -s 120x90 ".$outfile."  2>&1";
	$ret = exec($cmd_line,$output);
	array_push($output, $outfile);
	return $output;
	
}
function create_image_thumb($fn)
{
    $targ_w = $targ_h = pic_thumb_size();
    
    $quality = 90; 
	$ext = get_ext($fn);

    $src = $fn;
	$ret= "";
	if($ext == "jpg" || $ext == "jpeg")
	{
	    $img_r = imagecreatefromjpeg($src);
		$ret = data_dir(). get_out_file_name("jpg");
	}
	if($ext == "png")
	{
		$img_r = imagecreatefrompng($src);
		$ret = data_dir().get_out_file_name("png");
	}
    $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

    imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
    $targ_w,$targ_h,$_POST['w'],$_POST['h']);

	if($ext == "jpg" || $ext == "jpeg")
	{
	    imagejpeg($dst_r, $ret,$quality);
		return $ret;
	}

	if($ext == "png")
	{
		imagepng($dst_r, $ret,$quality);
		return $ret;
	}

	return FALSE;	
}

function create_thumb( $f ,$type)
{
	//type v or i ,video or image
	//f == filename
	if( !file_exists($f) )  { die("File not exists");  }	


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
		die("No FFmpeg binary found");
	}
	if($ifgd == 0)
	{
		die("No GD library for php Found,will exit now");
	}
	
	if($type =="v")
	{
		$res = create_video_thumb($f,$ffmpeg_bin);
		return array_pop($res);	
	}else if($type == "i")
	{
		return create_image_thumb($f);
	}
	

	return "None";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  // create image thumb 
{    
	

    $src = getFormValue("src");
//	$id = getFormValue("id");  // the sql id of this image	
	$id = $_POST["id"];
	if(!is_numeric($id) ) die("fuckid ".$id);
	if(strlen($src) < 3) die("fucksrc ".$src);

	$tfile = create_thumb($src,"i");
	if($tfile !== FALSE)
	{
		/// mysql update this record
		$link = connect_mysql();
		$sql = "update pics set thumb='".$tfile."' where pid=".$id;
		$result = mysql_query($sql);
		if($result)
		{
			mysql_close($link);
			echo  json_return ( array('success'=> $tfile) );
		}else
		{
			die(  json_return( array("error" =>mysql_error() ) ));
		}
	}
	else
	{
		echo  json_return( array("error" =>"create image thumb failed" ) );
	}
}
else  /// here is video thumb
{

}

?>
