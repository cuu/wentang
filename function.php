<?php

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/auth.php');
require_once(DOKU_INC.'inc/common.php');

/// below is some wapper funcs forasp2php
function now()
{
	return date( "Y-m-d   H:i:s ",time()); 
}

function get_ext($str) {
    $i = strrpos($str,".");
    if (!$i) { return ""; }
    $l = strlen($str) - $i; 
    $ext = substr($str,$i+1,$l);
    return $ext;
	// return like jpg ,png gif avi mov...etc
}


function DateDiff($part, $begin, $end)
{
	$diff = (is_numeric($end) ? $end : strtotime($end)) - (is_numeric($begin) ? $begin : strtotime($begin));
	switch ($part)
	{
		case "y": $retval = bcdiv($diff, (60 * 60 * 24 * 365)); break;
		case "m": $retval = bcdiv($diff, (60 * 60 * 24 * 30)); break;
		case "w": $retval = bcdiv($diff, (60 * 60 * 24 * 7)); break;
		case "d": $retval = bcdiv($diff, (60 * 60 * 24)); break;
		case "h": $retval = bcdiv($diff, (60 * 60)); break;
		case "n": $retval = bcdiv($diff, 60); break;
		case "s": $retval = $diff; break;
	}
	return $retval;
}

function DateAdd($part, $num, $date, $rtype)
{
	$date = is_numeric($date) ? $date : strtotime($date);
	$dArr = getdate($date);
	$hor = $dArr["hours"];
	$min = $dArr["minutes"];
	$sec = $dArr["seconds"];
	$mon = $dArr["mon"];
	$day = $dArr["mday"];
	$yar = $dArr["year"];
	switch ($part)
	{
    		case "y": $yar += $num; break;
    		case "q": $mon += ($num * 3); break;
    		case "m": $mon += $num; break;
    		case "w": $day += ($num * 7); break;
    		case "d": $day += $num; break;
    		case "h": $hor += $num; break;
    		case "n": $min += $num; break;
    		case "s": $sec += $num; break;
	}
	$dnum = mktime($hor, $min, $sec, $mon, $day, $yar);
	return $rtype == 1 ? date("Y-m-d H:i:s", $dnum): $dnum;
	// rtype==1 return string date, 2 for unix timestamp
}


function Right($value, $count){
    return substr($value, ($count*-1));
}
 
function Left($string, $count){
    return substr($string, 0, $count);
}
 

function Format_Date( $t)
{
	if ($t != "" && !is_null($t))
		return date("Y-m-d",$t);
	else 
		return "";
}

function Format_Time( $t)
{
	if($t !="" && !is_null($t))
		return date("H:i:s",$t);
	else 
		return "";
}	

/// get POST or GET values
// formName is query string's name

function getFormValue( $formName)
{
	//return $_REQUEST[$formName];

	if( $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$formName]) )
		return $_POST[$formName];
	else if( $_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET[$formName]) ) 
		return $_GET[$formName];

	return "";
}

function GetURLSort( $f_pxgz, $f_pxgz_type)
{
	$result_url="";
	$search_str = "pxgz=";
	$strurl = $_SERVER['REQUEST_URI'];
	$Strurl = explode("/",$strurl);
	$i = count($Strurl);

	$str_url = $Strurl[$i-1]; // *.php name
	if( strpos($str_url,"?")!==false) 
	{
		$str_url = explode("?",$str_url);
		$str_url = $str_url[0];	
	}
	$str_params = trim($_SERVER['QUERY_STRING']);
	$request_form = http_build_query($_POST);
	// the ordinarly data like aa=bb&cc=dd&ee=ff
	if( trim( $request_form) != "")
	{
		if( $str_params !="")
		{
			$str_params = $str_params."&". trim($request_form);
		} else
		{
			$str_params = trim($request_form);
		}
	}
	if ($str_params =="") return $str_url ."?pxgz=";
	else
	{
		if( strpos( $str_params, $search_str) ===false )
		{
			return $str_url."?".$str_params."&pxgz=".$f_pxgz."&pxgz_type=".$f_pxgz_type;
		}else
		{
			$j = strpos($str_params,$search_str);
			$str_params1 = Left($str_params,$j-1);
			$str_params2 = substr($str_params,$j+5, strlen($str_params));

			$j = strpos($str_params2,"pxgz_type=");
			if($j != 0&& $j!== false)
			{
				$str_params2 = substr($str_params2, $j+10,strlen($str_params2));
			}
			//echo "2str_params2= ".$str_params2."<br />";
			$j = strpos($str_params2,"&");
			$str_params2 = substr( $str_params2, $j, strlen($str_params2));
			
			//echo "3 str_params2 = ". $str_params2."<br />";	
			//echo $str_url."<br />";
			return $str_url . "?". $str_params1."&pxgz=".$f_pxgz."&pxgz_type=".$f_pxgz_type.$str_params2;
			// meselft.php?a=b&pxgz=c&pxgz_type=d&etc...; 
		}
	}

}	


function build_sql_query($c, $s,$o,$sql,$t1,$t2)  // $yhmc ,"yhmc" ,"like" $sql,%,%
{
        $res = "";
        if ( $c != "")
        {
                if( strpos( $sql, "where") )
                {
                        $res = " and ".$s." ".$o." '".$t1.$c.$t2."'";
                }
                else
                {
                        $res = " where ".$s." ".$o." '".$t1.$c.$t2."'";
                }

                return $res;
        }
        else return   "";

}

function check_root()
{
  if(isset($_SESSION["zz"]))
  {
        if( intval($_SESSION["zz"]) != 1)
        {
          echo "<script language=javascript>alert('用户权限错误,您不是超级管理员！');window.parent.location.reload();</script>";
          die();
  
        }
  }
  else
  {
    	echo "<script language=javascript>alert('会话错误！');window.parent.location.reload();</script>";
        die();
  }
}

function connect_mysql()
{

if( strstr( $_SERVER["SERVER_NAME"],"127.0.0.1"))
{
	$sqlsrv = "127.0.0.1";
	$sqlusr = "root";
	$sqlpas = ""; 
	$sqldb  = "guu_wentang";
}
if( strstr( $_SERVER["SERVER_NAME"],"wentang"))
{
	$sqlsrv = "127.0.0.1";
	$sqlusr = "dphysus_wentang";
	$sqlpas = "e=mc2"; 
	$sqldb  = "dphysus_wentang";
}

 
    $link = mysql_connect ( $sqlsrv, $sqlusr,$sqlpas) or die("mysql connect error".mysql_error() );
    mysql_select_db($sqldb,$link);

    return $link;
}
function data_dir()
{
	return "data/media/";
}
function pic_thumb_size()
{
	return array(184,184);
}
function pic_thumb_w()
{
	return 184;
}
function pic_thumb_h()
{
	return 184;
}

function dwp_display_wiki_page($wikipagename) 
{
	global $conf, $lang;
	global $auth;
	global $ID, $REV;

	//save status
	$backup['ID']	= $ID; 
	$backup['REV']	= $REV;

	$result = '';

	//Check user permissions...
	$perm = auth_quickaclcheck(trim(strtolower($wikipagename),":"));

	if(@file_exists(wikiFN($wikipagename)))
	{
		if ($perm >= AUTH_READ)
		{
			//check page permissions
			if ($perm >= AUTH_READ)
			{
				$result = p_wiki_xhtml($wikipagename,'',false);
			}
			else	//show access denied
			{
				$result = p_locale_xhtml('<b>Access Denied</b>');
			}
		}
	}
	else
	{
		$result = p_locale_xhtml('<b>Page not found</b>');
	}

	$ID = $backup['ID'];
	$REV = $backup['REV'];


	return $result;
}

$data_dir = "data/media/";

?>
