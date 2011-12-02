<?php
if(!defined('DOKU_INC')) die();



class action_plugin_video extends DokuWiki_Action_Plugin {
	
	public $handle="video";

	function register(&$controller) {	
		$controller->register_hook('ACTION_ACT_PREPROCESS','BEFORE', $this, 'preprocess_hello');
		$controller->register_hook('TPL_ACT_UNKNOWN', 'BEFORE', $this, 'result_hello');
	}

	function preprocess_hello(&$event, $param){
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

	function result_hello(&$event, $param){
		global $INFO;
		$file= $INFO["filepath"];

		if($event->data != $this->handle) return;
		// ok - we handle the action  
		//DOKU_INC	

			echo "<center><div class='add_big_img' >";

			echo "</div></center>";
//------------------------------------------------------
			echo "<div id='left_scroll'><img src='lib/tpl/guu/images/left_scroll.png' > </div>";

			echo "<div id='bottom_bar' style='background:#888; width:933px;height:96px;'>";
			echo "<div class='add_thumb'></div>";

			echo "</div>";

			echo "<div id='right_scroll'><img src='lib/tpl/guu/images/right_scroll.png' ></div>";

		$event->preventDefault();  
	}

}
