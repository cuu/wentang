<?php
if(!defined('DOKU_INC')) die();

class action_plugin_splash extends DokuWiki_Action_Plugin {
	
	public $handle="splash";
	public $db = "guu_wentang";
	public $table = "splash";

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

		while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0:pid 1:thumb 2:data
		{
			
		}
		mysql_close($link);	
	}

	function result(&$event, $param){
		global $INFO;

		if($event->data != $this->handle) return;
		//DOKU_INC	

			echo "<center><div class='splash_slider' >";

			$this->get_data();
if ( $INFO['perm'] == AUTH_ADMIN )
{
			echo "<div class='add_splash' ><span id=''>ADD</span></div>";				
			echo "</div></center>";
	echo <<<EOT
	<div id="add_splash_dialog" style="display:none; background-color:transparent;">
		<div style="clear:both;" class="tips">
			Click add to chose image to upload, once you have done the chosing ,it'll upload autoly right away<br />
			JPG PNG GIF Only
		</div>
		<div id="add_splash" >
			<input id="button4"  type='button' value='add'  style="width:55px;height:25px;line-height:25px;" />
			<br /> <br />
			<span>Size: ?x? </span>
		</div>

		<input type="hidden" id="check" value="-1" />

	</div>
	
EOT;
	//------------------------------------------------------
}
		$event->preventDefault();  
	}

}
