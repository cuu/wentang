<?php
include_once "function.php";

require_once "VideoUrlParser.class.php";

if ('cgi-fcgi' != php_sapi_name()) die("not cgi-fcgi");

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/auth.php');



$url = getFormValue("url");

if( strpos ($url,"youku"))
{
/*
	$pos_id = strpos($url,"id_");
	$last_pos = strpos($url,strrchr($url, '.'));
	if($pos_id !==FALSE && $last_pos !==FALSE)
	{
		$id = substr($url,$pos_id +3, $last_pos - $pos_id - 3);
	
	echo '<embed src="http://player.youku.com/player.php/sid/'.$id.'/v.swf" allowFullScreen="true" quality="high" width="480" height="400" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>';
	
	}
	else 
	{
		$homepage = file_get_contents($url);
		$pos1 = strpos($homepage , "<embed");
		$pos2 = strpos( $homepage ,"/embed>");
		
		if( $pos1 !==FALSE && $pos2 !== FALSE)
		{
			echo  substr($homepage, $pos1, $pos2 - $pos1 + 7);
		}
		else
		{
			echo $url;
		}
	}
*/
    $result['data'] = VideoUrlParser::parse($url);
    if(!$result['data'])
        $result['status'] = 0;
    else
        $result['status'] = 1;

    echo json_encode($result);
	
}
else if( strpos ($url,"tudou.com"))
{

	$result['data'] = VideoUrlParser::parse($url);
	if(!$result['data'])
    	$result['status'] = 0;
	else
    	$result['status'] = 1;

	echo json_encode($result);

/*
array(5) {
  ["img"]=>
  string(37) "http://i4.tdimg.com/114/284/153/w.jpg"
  ["title"]=>
  string(6) "�_��_�"
  ["url"]=>
  string(47) "http://www.tudou.com/programs/view/hfHp2__Khmw/"
  ["swf"]=>
  string(40) "http://www.tudou.com/v/hfHp2__Khmw/v.swf"
  ["object"]=>
  string(203) "<embed src="http://www.tudou.com/v/hfHp2__Khmw/v.swf" quality="high" width="480" height="400" align="middle" allowNetworking="all" allowScriptAccess="always" type="application/x-shockwave-flash"></embed>"
}

*/	
/*
	$id = substr($url, strpos($url,"view")+1, strlen($url) - strpos($url,"view") -2);
	if($id)
	{

echo '<embed src="http://www.tudou.com/v/'.$id.'/v.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="480" height="400"></embed>';
	
	} else { echo $url; }
}
else
{
	echo $url;
}
*/
}
?>
