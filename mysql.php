<?php
include_once "function.php";

if ('cgi-fcgi' != php_sapi_name()) die();

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/auth.php');

//var_dump($INFO);

$sqlsrv = "127.0.0.1";
$sqlusr = "root";
$sqlpas = "";
$sqldb  = "guu_wentang";

$id          = getFormValue("id"    );

$thumb       = getFormValue("thumb" );
$data        = getFormValue("data"  );
$small_thumb = getFormValue("st"    ); // small thumb 

$table		 = getFormValue("tab"   );

$delete      = getFormValue("delete");
$pid		 = getFormValue("pid"   );


function run_sql($sql)
{
	global $id, $sqlsrv,$sqlusr,$sqlpass,$sqldb, $table;
	$link = mysql_connect ( $sqlsrv, $sqlusr,$sqlpas) or die("mysql connect error".mysql_error() );
	mysql_select_db($sqldb,$link);
    if($sql != "") 
    {   
        $result = mysql_query($sql);
        if(!$result)
        {   
            echo "mysql_query error".mysql_error(); mysql_close($link); die();
        }else
        {  
			if( mysql_insert_id() !== FALSE && intval($id) == -1)	
			{
				$id = mysql_insert_id(); 
			}

			mysql_close($link); 
        }   
    }else
    {   
        echo "sql query empty"; mysql_close($link); die();
    }   
}
$sql = "";

	if(strcmp($delete,"yes") == 0 )
	{
		$sql = "delete  from ".$table." where pid=".$pid;
		run_sql($sql);
		die("success");	
	}

$sql = "";
	if( strlen( $thumb ) > 1 /* && strlen($data) <= 1 && strlen($small_thumb) <= 1 */)
	{ //only thumb
		if( intval($id) == -1)
		{
			$sql = "insert into ".$table." (thumb) VALUES('".$thumb."')";
		}
		else if( is_numeric ($id) && intval($id) >= 0 )
		{
			$sql = "update ".$table." set thumb = '".$thumb."' where pid=".$id;
		}
		run_sql($sql);
	}
	if( /*strlen( $thumb ) <= 1  && */  strlen($data) > 1 /* && strlen($small_thumb) <= 1*/ )
	{
		if( intval($id) == -1)
		{
			$sql = "insert into ".$table." (data) VALUES('".$data."')";
		}else if ( is_numeric ($id) && intval($id) >= 0 )
		{
			$sql = "update ".$table." set data='".$data."' where pid=".$id;
		}
		run_sql($sql);
	}
	if( /*strlen( $thumb ) <= 1  &&  strlen($data) <= 1 && */ strlen($small_thumb) > 1 )
	{
		if( intval($id) == -1)
		{
			$sql = "insert into ".$table." (small_thumb) VALUES('".$small_thumb."')";	
		}else if ( is_numeric ($id) && intval($id) >= 0 )
		{
			$sql = "update ".$table." set small_thumb='".$small_thumb."' where pid=".$id;
		}
		run_sql($sql);
	}

	echo $id;

?>
