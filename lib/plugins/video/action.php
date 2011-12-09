<?php
if(!defined('DOKU_INC')) die();
class action_plugin_video extends DokuWiki_Action_Plugin {
	
	public $handle="video";
    public $db = "guu_wentang";
    public $table = "video";

	function register(&$controller) {	
		$controller->register_hook('ACTION_ACT_PREPROCESS','BEFORE', $this, 'preprocess');
		$controller->register_hook('TPL_ACT_UNKNOWN', 'BEFORE', $this, 'result');
	}

	function preprocess(&$event, $param){
		if($event->data != $this->handle) return;
		// ok - we handle the action
		$event->preventDefault();
		return true;
	}

	function get_video_data($pid)
	{
        $sqlserver ="127.0.0.1";
        $sqluser="root";
        $sqlpass="";
        $sql = "select * from ".$this->table." where pid=".$pid;

        $link = mysql_connect($sqlserver, $sqluser, $sqlpass) or die('Could not connect: ' . mysql_error());
        mysql_select_db($this->db) or die('Could not select database '.$this->db);
        $result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());

        while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0 pid 1 thumb 2 data
        {
			if(strpos($line[2],"<embed") !==FALSE)
			{
				echo $line[2];  // youku or tudou
			}else
			{
				echo 
	'<embed type="application/x-shockwave-flash" src="player.swf?v1.3" id="f4Player" '.
' flashvars="video='.$line[2].'&thumbnail='.$line[1].'" allowscriptaccess="always" allowfullscreen="true" bgcolor="#000000" height="270" width="480">'.'<noembed>You need Adobe Flash Player to watch this video. &lt;br&gt; &lt;</noembed>';

			}
		}		
		mysql_close($link);
	}

	function get_data()
	{
		//get data from  mysql databases
		$sqlserver ="127.0.0.1";
		$sqluser="root";
		$sqlpass="";
        $sql = "select * from ".$this->table;
        $link = mysql_connect($sqlserver, $sqluser, $sqlpass) or die('Could not connect: ' . mysql_error());
        mysql_select_db($this->db) or die('Could not select database '.$this->db);
        $result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());

        while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0 pid 1 thumb 2 data
        {
			echo '
			<div id="video_thumb_container" class="video_thumb_container">
			<div class="video_small_thumb">
			<a id="to_show_video" href="?id=video&do=video&pid='.$line[0].'"><img src="'.$line[3].'" alt="No img" /></a>
			</div>
			<a  href="#" rel="'.$line[0].'" class="close_img" id="close_img" ></a>
			</div>';

        }
		
		mysql_close($link);
	}

	function result(&$event, $param){
		if($event->data != $this->handle) return;
			echo "<center id='video_big_area'>";
			if( isset($_GET["pid"]))
			{
				$this->get_video_data($_GET["pid"]);	
			}else
			{
				echo "<div class='add_big_img' id='add_big_video' style='overflow:hidden;' ><center>";
				echo "<input style='width:80px;height:25px;' id='add' type='button' value='Add' /><br />";
				echo "<span>Add image/video ,Size Max layout 798x798 px,Only <b>flv</b> can be supported ".
				"Video upload Max:".ini_get('upload_max_filesize').
				"</span>"; 
				echo "</center></div>";
			}
			echo "</center>";


			echo "<div id='left_scroll' style='background:black;height:96px;'><img src='lib/tpl/guu/images/scroll_left.png' style='margin-top:39px;' > </div>";

			echo "<div id='bottom_bar' style=' width:933px;'>";
				
			$this->get_data();
			echo "<div class='add_thumb' id='add_video_thumb'>";
			echo "<input style='width:60px;height:25px;' id='button3' type='button' value='Add' /> <br />";
			echo "<span> Add thumb for video, 96x96</span>";
			echo "</div>";
				
			echo "<div style='clear:both;'></div>";
			echo "</div>";

			echo "<div id='right_scroll' style='background:black;height:96px;'><img src='lib/tpl/guu/images/scroll_right.png'  style='margin-top:39px;'></div>";
echo <<<EOF
<div id="add_video_dialog" style="display:none; background-color:transparent;">
	<input type="button" value="upload video" id="add_video" style="height:25px;width:120px;" /> 
	<input type="button" value="upload video thumb" id="add_video_thumb_pic" style="height:25px; width:160px; margin-left:15px;" />
	<input type="button" value="upload small thumb" id="add_video_small_thumb" style="height:25px; width:160px; margin-left:15px;" />

	<br />
	<span id='info'></span>	
	<br />
	<div id="video_area" >
	</div>
	<br /> Or&nbsp; you can embed a video from youku or tudou <br /> 
	<span>URL:&nbsp;</span>
	<textarea id="url_bar" cols="60" rows="10" ></textarea> <br /> <br />
	<input type="button" id="done" value="Done" style="height:25px;width:80px;"/>
	<span id='ert' ></span>
	<input type="hidden" id="check" value="-1" />
</div>

EOF;
		$event->preventDefault();  
	}

}
