<?php
if(!defined('DOKU_INC')) die();
class action_plugin_video extends DokuWiki_Action_Plugin {
	
	public $handle="video";

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

	function get_data()
	{
		//get data from  mysql databases
		$sqlserver ="127.0.0.1";
		$sqluser="root";
		$sqlpass="";
		
		

	}

	function result(&$event, $param){
		if($event->data != $this->handle) return;

			echo "<center><div class='add_big_img' id='add_big_video' >";
			echo "<input style='width:80px;height:25px;' id='add' type='button' value='Add' /><br />";
				echo "<span>Add image/video ,Size Max layout 798x798 px,Only <b>flv</b> can be supported ".
				"Video upload Max:".ini_get('upload_max_filesize').
				"</span>"; 
			echo "</div></center>";
//------------------------------------------------------
			echo "<div id='left_scroll'><img src='lib/tpl/guu/images/left_scroll.png' > </div>";

			echo "<div id='bottom_bar' style='background:#888; width:933px;height:96px;'>";
			echo "<div class='add_thumb' id='add_video_thumb'>";
			echo "<input style='width:60px;height:25px;' id='button3' type='button' value='Add' /> <br />";
			echo "<span> Add thumb for video, 96x96</span>";
			echo "</div>";
			echo "</div>";

			echo "<div id='right_scroll'><img src='lib/tpl/guu/images/right_scroll.png' ></div>";
echo <<<EOF
<div id="add_video_dialog" style="display:none; background-color:transparent;">
	<input type="button" value="upload video" id="add_video" style="height:25px;width:120px;" /> 
	<input type="button" value="upload thumb" id="add_video_thumb" style="height:25px; width:120px; margin-left:15px;" />
	<br />
	
	<br /> Or&nbsp; you can embed a video from youku or tudou <br /> 
	<span>URL:&nbsp;</span>
	<textarea id="url_bar" cols="60" rows="10" ></textarea> <br /> <br />
	<input type="button" id="done" value="Done" style="height:25px;width:80px;"/>
</div>
<input type="hidden" id="check" value="-1" />

EOF;
		$event->preventDefault();  
	}

}
