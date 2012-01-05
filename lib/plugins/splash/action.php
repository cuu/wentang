<?php
if(!defined('DOKU_INC')) die();

require_once( DOKU_INC."function.php");

class action_plugin_splash extends DokuWiki_Action_Plugin {
	
	public $handle="splash";
	public $db = "guu_wentang";
	public $table = "splash";
	public $sqlsrv = "127.0.0.1";
	public $sqlusr = "root";
	public $sqlpas = "";

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
		global $INFO;
		$sql = "select * from ".$this->table;

		$link = connect_mysql();
		$result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());

		while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0:pid 1:thumb 2:data
		{
			if( $INFO["perm"] ==AUTH_ADMIN ) 
			{ 
				echo "<li id='splash".$line[0]."' class='splash_div'>";
				echo "	<img src='".$line[2]."' />";
				echo "<a  href='#' rel=\"".$line[0]."\"  class='close_img' id='close_img' ></a>";
				echo "</li>";
			}else
			{
				echo "<img src='".$line[2]."' />";
			}
//			echo "<a  href='#' rel=\"".$line[0]."\"  class='close_img' id='close_img' ></a>";
				
		}
		mysql_close($link);	
	}// end get_data()

	function result(&$event, $param){
		global $INFO;

		if($event->data != $this->handle) return;
		//DOKU_INC	
		
			if ( $INFO['perm'] != AUTH_ADMIN ) 
			{
				echo '<center><div  id="sb-slider" class="sb-slider" >';
				$this->get_data();
				echo "</div></center>";
			}else
			{
				echo '<ul id="sortable">';
				$this->get_data();
				echo '</ul>';
			}

if($INFO["perm"] ==AUTH_ADMIN )
{   
	echo "<div class='add_splash' >
	<button id='add' >添加 </button>
	<span id='splash_slider_add_splash'>ADD a new Splash</span>
	</div>";
}

if ( $INFO['perm'] == AUTH_ADMIN )
{
	echo <<<EOT
	<div id="add_splash_dialog" style="display:none; background-color:transparent;">
		<div style="clear:both;" class="tips">
			Click add to chose image to upload, once you have done the chosing ,it'll upload autoly right away<br />
			JPG PNG GIF Only
		</div>
		<div id="add_splash" >
			<button id="add" > Add</button>
			<br /> <br />
			<span>Size: ?x? </span>
		</div>
		<div  id="preview" style="width:720px;height:320px;overflow:hidden;" > </div>

		<input type="hidden" id="check" value="-1" />
		<img src = "lib/tpl/guu/images/ajax-loader.gif" id="ajaximg"  style=" margin-right:20px;display:none;" />
		<button id="done" >Done</button>
	</div>
	
EOT;
	//------------------------------------------------------
}
		$event->preventDefault();  
	}

}
