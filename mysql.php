<?php
include_once "function.php";

//if ('cgi-fcgi' != php_sapi_name()) die();

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/auth.php');
require_once(DOKU_INC.'inc/common.php');
$INFO = pageinfo();
if($INFO["isadmin"] !== TRUE) { die("You dont have access rights"); }


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

$add_album   = getFormValue("addalbum");
$parent		 = getFormValue("parent"  );

$default     = getFormValue("default");

$switch 	 = getFormValue("switch");
$a 			 = getFormValue("a");
$b			 = getFormValue("b");

function connect_mysql()
{
	global $id, $sqlsrv,$sqlusr,$sqlpass,$sqldb, $table; 
	$link = mysql_connect ( $sqlsrv, $sqlusr,$sqlpas) or die("mysql connect error".mysql_error() );
	mysql_select_db($sqldb,$link);

	return $link;
}
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

function delete_from_sql ($a,$b)
{
	// delete from
	 
}

$sql = "";
	if( isset($default) && $default != "")
	{
		$sql = "update pic set data = '".$default."' where pid=".$parent;
		run_sql($sql);
		die("success");
	}
	if(strcmp($add_album,"yes") == 0)
	{
		$sql = "insert into pic values()";
		run_sql($sql);
		die("success");
	}

	if(strcmp($delete,"yes") == 0 )
	{
		$sql = "delete  from ".$table." where pid=".$pid;
		run_sql($sql);
		die("success");	
	}

	if(strcmp( $switch,"yes") == 0)
	{
		$tmp_a = explode(",", $a);
		$tmp_b = explode(",", $b);
		$link = connect_mysql();
		$sql_array=array();
		
		for($i=0;$i< count($tmp_a); $i++)
		{
			$tmp_a_id = substr($tmp_a[$i],6);
			$tmp_b_id = substr($tmp_b[$i],6);
			if(strcmp($tmp_a_id,$tmp_b_id) != 0)
			{
				if($table == "splash")
				{
					$sql1 = "select * from ".$table." where pid=".$tmp_b_id;	
					$result1 = mysql_query($sql1);
					if($result1){ $row1 = mysql_fetch_array($result1,MYSQL_NUM); }

					$sql2 = "update ".$table." set thumb='".$row1[1]."',data='".$row1[2]."' where pid=".$tmp_a_id;
					array_push($sql_array,$sql2);
				}
			}	
		} //end for
		for($i=0;$i< count($sql_array); $i++)
		{
			mysql_query($sql_array[$i]);
		}
		mysql_close($link); die("success");
	}

$sql = "";
	if( strlen( $thumb ) > 1 /* && strlen($data) <= 1 && strlen($small_thumb) <= 1 */)
	{ //only thumb
		if( intval($id) == -1)
		{
			if( $parent == "" || !is_numeric($parent) ) die("You are a fucker");
			$sql = "insert into ".$table." (parent_id,thumb) VALUES(".$parent.",'".$thumb."')";
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
			if( $parent == "" || !is_numeric($parent) ) die("You are a fucker");
			$sql = "insert into ".$table." (data,parent_id) VALUES('".$data."',".$parent.")";
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
