<?php

function coded_get($str)
{
	$file = getFormValue($str);

	$dbdir = "";
	$ext = strrchr($file,'.');
	$name = substr($file,0, -(strlen($ext)));
		
//	return $dbdir.base64_encode($name).$ext;
	return $dbdir.$name.$ext;
}


//if ('cgi-fcgi' != php_sapi_name()) die();

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/auth.php');
require_once(DOKU_INC.'inc/common.php');


include_once (DOKU_INC."function.php");

$INFO = pageinfo();
if($INFO["isadmin"] !== TRUE) { die("You dont have access rights " ); }


$id          = getFormValue("id"    );

$thumb       = coded_get("thumb" );
$data        = coded_get("data"  );

$small_thumb = coded_get("st"    ); // small thumb 

$table		 = getFormValue("tab"   );

$delete      = getFormValue("delete");
$pid		 = getFormValue("pid"   );

$add_album   = getFormValue("addalbum");
$parent		 = getFormValue("parent"  );

$default     = getFormValue("default");

$switch 	 = getFormValue("switch");
$a 			 = getFormValue("a");
$b			 = getFormValue("b");

function run_sql($sql)
{
	global $id, $table;
	$link = connect_mysql();
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

function delete_from_sql_with_noexisted ()
{
    // delete from pics splash video;
	$data_dir = data_dir();

	if( $data_dir == "" || empty($data_dir) || !isset($data_dir))
	{
			printf("set data dir error ". $data_dir);
			return;
	}
		
	$files = array();
    $link = connect_mysql();
    $sql = "select * from pics,splash,video";
    $result = mysql_query($sql);
    if($result)
    {   
		while( $row = mysql_fetch_array($result,MYSQL_NUM ) )
		{
			foreach($row as $r)
			{
				if( !is_numeric($r) && !empty($r) )
				$files[] = $r;
			}
		}
    }
	mysql_close($link); 
	
	$dir    = $data_dir;
	$files1 = scandir($dir);
	foreach ($files1 as $ff)
	{
		if(!in_array( $dir.$ff ,$files) && !is_dir($dir.$ff) && $ff[0] != '.' ) // Not in sql ,not dir ,not a file like .xxxx
		{
	//		printf("found file to delete: " .$dir. $ff. "<br />");
			if( unlink ($dir.$ff) === FALSE) {printf ("delete ".$dir.$ff. " errored"); }
		}
	}
	
	
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
		if($table == "" || $pid == "")
		{
			die("DEL input data not correct");
		}
		$sql = "delete  from ".$table." where pid=".$pid;
		run_sql($sql);
		if( $table == "pic")
		{
			$sql = "delete from pics where parent_id=".$pid;
			run_sql($sql);
		}
		delete_from_sql_with_noexisted();
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
