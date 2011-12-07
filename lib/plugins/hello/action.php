<?php
if(!defined('DOKU_INC')) die();

class action_plugin_hello extends DokuWiki_Action_Plugin {
	
	public $handle="hello";
	public $db = "guu_wentang";
	public $table = "pic";

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
		$sqlserver="127.0.0.1";
		$sqluser="root";
		$sqlpass="";
		$sql = "select * from ".$this->table;

		$link = mysql_connect($sqlserver, $sqluser, $sqlpass) or die('Could not connect: ' . mysql_error());
		mysql_select_db($this->db) or die('Could not select database '.$this->db);

		$result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());

		while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0 pid 1 thumb 2 data
		{
			echo "<div class='pic' >"."<a rel='group1'  href='".$line[2]."'>"."<img src='".$line[1]."' /></a></div>";
		}
		mysql_close($link);	
	}

	function result(&$event, $param){
		global $INFO;
		$file= $INFO["filepath"];

		if($event->data != $this->handle) return;
		//DOKU_INC	

			echo "<center><div class='pic_grid' >";

			$this->get_data();
			echo "<div class='add_pic' ><span id='pic_grid_add_pic'>ADD</span></div>";				
			echo "</div></center>";
echo <<<EOT
<div id="add_pic_dialog" style="display:none; background-color:transparent;">
	<div style="clear:both;" class="tips">
		Click add to chose image to upload, once you have done the chosing ,it'll upload right away<br />
		JPG PNG GIF Only
	</div>
	<div id="add_thumb" >
		<input id="button1"  type='button' value='add'  style="width:55px;height:25px;line-height:25px;" />
		<br /> <br />
		<span>Size: 96x96 </span>
	</div>
	<div id="big_image">
		<input id="button2" type="button" value="add" size=15 style="width:100px;height:25px;line-height:25px;" />
		<br /> <br />
		<span> Size:480x280px </span>
	</div>	
	<div style="clear:both;"></div>
	<br /><br />
	<div id="upload" style="float:right";> 
		<input type="button" value="Done" size=15 style="width:100px;height:25px;line-height:25px;" />
		<br /> <br />
	</div>
	<input type="hidden" id="check" value="-1" />

</div>
EOT;
//------------------------------------------------------

		$event->preventDefault();  
	}

}
