<?php
if(!defined('DOKU_INC')) die();

class action_plugin_hello extends DokuWiki_Action_Plugin {
	
	public $handle="hello";
	public $db = "guu_wentang";
	public $table1 = "pic"; // for album
	public $table2 = "pics";  // for detail
	public $sqlsrv = "127.0.0.1";
	public $sqlusr ="root";
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
		$link = mysql_connect($this->sqlsrv, $this->sqlusr, $this->sqlpas) or die('Could not connect: '.mysql_error());
		mysql_select_db($this->db) or die('Could not select database '.$this->db);
		return $link;
	}

	function get_data( $albumid)
	{
		$sql = "select * from ".$this->table2." where parent_id=".$albumid;

		$link = $this->connect_mysql();

		$result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());

		while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0 pid 1:data 2:parentid 3:thumb 
		{
			
			echo "<div class='pic_container'><div class='pic' >"."<a rel='group1'  href='".$line[1]."'>"."<img alt='pics' src='".$line[3]."' /></a></div> <a  href='#' rel=\"".$line[0]."\"  class='close_img' id='close_img' ></a></div>";
		}
		mysql_close($link);	
	}

	function get_album()
	{
		global $INFO;
		$sql = "select * from ".$this->table1;
		$link = $this->connect_mysql();
		$result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());
        while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0 pid 1 thumb 2 data
        {

            echo "<div class='album_container'>"."<a  href='?do=hello&album=".$line[0]."'>"."<img alt='album' src='".$line[2]."' /></a>
				<a  href='#' rel=\"".$line[0]."\"  class='close_img' id='close_img' ></a></div>";
        }
		
        mysql_close($link);
		if($INFO["perm"] ==AUTH_ADMIN )
		{
			echo "<div class='add_album' >
			<input style='width:80px;height:25px;' id='add' type='button' value='Add' /><br />
			<span id='album_grid_add_album'>ADD Album</span>
			</div>";		

		}

	}
	
	function show_album_detail( $albumid)
	{
			global $INFO;

            echo "<center><div class='pic_grid' >";

            $this->get_data( $albumid );
if ( $INFO['perm'] == AUTH_ADMIN )
{
            echo "<div class='add_pic' ><span id='pic_grid_add_pic'>ADD</span></div>";    
            echo "</div></center>";
echo <<<EOT
<div id="add_pic_dialog" style="display:none; background-color:transparent;">    <div style="clear:both;" class="tips">        Click add to chose image to upload, once you have done the chosing ,it'll upload right away<br />
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
	<input id='make_it_default' type="checkbox"  />Make it be the default front page of this album
    <div id="upload" style="float:right";>
        <input type="button" value="Done" size=15 style="width:100px;height:25px;line-height:25px;" />
        <br /> <br />
    </div>
    <input type="hidden" id="check" value="-1" />

</div>
EOT;
//------------------------------------------------------
}		
	}
	
	function result(&$event, $param){
		global $INFO;

		if($event->data != $this->handle) return;
		//DOKU_INC
		if( is_numeric($_GET["album"] ))
		{
			$this->show_album_detail( $_GET["album"]  );
		}else
		{
			$this->get_album();
		}

		$event->preventDefault();  
	}

}
