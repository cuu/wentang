<?php
if(!defined('DOKU_INC')) die();

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
	function connect_mysql()
	{
        $link = mysql_connect($this->sqlsrv, $this->sqlusr, $this->sqlpas) or die('Could not connect: ' . mysql_error());
		mysql_select_db($this->db) or die('Could not select database '.$this->db);

		return $link;
	}
	function get_data()
	{
		global $INFO;
		$sql = "select * from ".$this->table;

		$link = $this->connect_mysql();
		$result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());

		while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0:pid 1:thumb 2:data
		{
			if( $INFO["perm"] ==AUTH_ADMIN ) 
			{ 
				echo "<div class='splash_div'>";
				echo "	<img src='".$line[2]."' />";
				echo "<a  href='#' rel=\"".$line[0]."\"  class='close_img' id='close_img' ></a>";
				echo "</div>";
			}else
			{
				echo "<img src='".$line[2]."' />";
			}
//			echo "<a  href='#' rel=\"".$line[0]."\"  class='close_img' id='close_img' ></a>";
				
		}
		mysql_close($link);	
		if($INFO["perm"] ==AUTH_ADMIN )
		{
            echo "<div class='add_splash' >
			<button id='add' >添加 </button>
            <span id='splash_slider_add_splash'>ADD a new Splash</span>
            </div>";
		}
	}

	function result(&$event, $param){
		global $INFO;

		if($event->data != $this->handle) return;
		//DOKU_INC	

			echo '<center><div  id="sb-slider" class="sb-slider" >';

			$this->get_data();
if ( $INFO['perm'] == AUTH_ADMIN )
{
			echo "</div></center>";
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
		<div  id="preview" style="width:480px;height:320px;overflow:hidden;" > </div>

		<input type="hidden" id="check" value="-1" />
		<button id="done" >Done</button>
	</div>
	
EOT;
	//------------------------------------------------------
}
		$event->preventDefault();  
	}

}
