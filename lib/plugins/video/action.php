<?php
if(!defined('DOKU_INC')) die();
require_once( DOKU_INC."function.php");

class action_plugin_video extends DokuWiki_Action_Plugin {
	
	public $handle="video";
    public $table = "video";


        function getInfo(){
            return array(
                'author' => 'dexter kidd',
                'email'  => 'dexter@dphys.us',
                'date'   => '2011-12-31',
                'name'   => 'Video page plugin',
                'desc'   => 'Put videos to show ',
                'url'    => 'http://dphys.us/',
            );  
        } 

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
	function echo_video_swf($file)
	{

		echo '
        <a  
             href="'.$file.'" 
             style="display:block;width:800px;height:450px"  
             id="player"> 
        </a> 
    
        <!-- this will install flowplayer inside previous A- tag. -->
        <script>
            flowplayer("player", "lib/tpl/guu/js/flowplayer-3.2.7.swf",
			{
				clip: {
					autoPlay: false,
					autoBuffering: true
				}
			}
			);
			
        </script>
		';
	}
	function get_first_video()
	{
        $sql = "select * from ".$this->table."  ORDER BY pid desc LIMIT 1";

        $link = connect_mysql();

        $result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());

        while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0 pid 1 thumb 2 data
        {
            if(strpos($line[2],"<embed") !==FALSE)
            {
                echo $line[2];  // youku or tudou
            }else
            {
/*
                echo
    '<embed type="application/x-shockwave-flash" src="player.swf?v1.3" id="f4Player" '.
' flashvars="video='.$line[2].'&thumbnail='.$line[1].'" allowscriptaccess="always" allowfullscreen="true"     bgcolor="#000000" height="270" width="480">'.'<noembed>You need Adobe Flash Player to watch this video. &lt;  br&gt; &lt;</noembed>';
*/
				$this->echo_video_swf($line[2]);
            }
        }
        mysql_close($link);

	}

	function get_video_data($pid)
	{
        $sql = "select * from ".$this->table." where pid=".$pid;

        $link = connect_mysql();
        $result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());

       	while ($line = mysql_fetch_array($result, MYSQL_NUM))  //0 pid 1 thumb 2 data
        {
			if(strpos($line[2],"<embed") !==FALSE)
			{
				echo $line[2];  // youku or tudou
			}else
			{
/*
				echo 
	'<embed type="application/x-shockwave-flash" src="player.swf?v1.3" id="f4Player" '.
' flashvars="video='.$line[2].'&thumbnail='.$line[1].'" allowscriptaccess="always" allowfullscreen="true" bgcolor="#000000" height="270" width="480">'.'<noembed>You need Adobe Flash Player to watch this video. &lt;br&gt; &lt;</noembed>';
*/
				$this->echo_video_swf($line[2]);
			}
		} 				
		mysql_close($link);
	}

	function get_data()
	{
		//get data from  mysql databases
        $sql = "select * from ".$this->table ." ORDER BY pid desc";
        $link = connect_mysql();
        $result = mysql_query( $sql ) or die('Query failed: ' . mysql_error());
		
		if ( mysql_num_rows($result) == 0)
		{
                echo '
                <li class="video_thumb_container" style="display:none;">
            <!--    <div class="video_small_thumb"> -->
                <a class="to_show_video" href="?id=video&do=video&pid=9999"><img src=""  alt="No img" /></a>
<!--            </div> -->
                <a  href="#" rel="" class="close_img" id="close_img" ></a>
				<button  class="edit_img" id="edit_img" ></button>
				<a href="#"  class="play_img" id="play_img" ></a>
                </li>';
		}
		else
		{
			while ($line = mysql_fetch_array($result, MYSQL_NUM)) //0 pid 1 thumb 2 data
    	    {
				echo '
				<li class="video_thumb_container">
			<!--	<div class="video_small_thumb"> -->
				<a class="to_show_video" href="?id=video&do=video&pid='.$line[0].'"><img src="'.$line[1].'" alt="No img" /></a>
<!--			</div> -->
				<a  href="#" rel="'.$line[0].'" class="close_img" id="close_img" ></a>
				<button rel="'.$line[0].'" class="edit_img" id="edit_img" ></button>
				<a href="?id=video&do=video&pid='.$line[0].'"  class="play_img" id="play_img" ></a>
				</li>';

			}
		}
		mysql_close($link);
	}

	function result(&$event, $param){
		global $INFO;
		if($event->data != $this->handle) return;
			echo "<div id='video_big_area'>";
			if( isset($_GET["pid"]) && trim($_GET["pid"]) != "" )
			{
				$this->get_video_data($_GET["pid"]);	
			}else
			{
				if ( $INFO['perm'] == AUTH_ADMIN )
				{
					echo "<div class='add_big_img' id='add_big_video' style='overflow:hidden;' ><center>";
					echo "<br /><br /><input class='nor_button' style='width:80px;height:25px;' id='add' type='button' value='Add' /><br />";
					echo "<span>Add video,Layout 16:9, Only <b>flv,m4v,mov,avi,wmv,mp4,mpeg</b> can be supported ".
					"Video upload Max:".ini_get('upload_max_filesize').
					"</span>"; 
					echo "</center></div>";
				}else { $this->get_first_video(); }
			}
			echo "</div> <!-- end of video_big_area -->";

			echo "<div class='bottom_container'>";
			echo '<ul id="screen">';
			echo '<li><a id="left_scr" href="#">&lt;&lt;</a></li>';
			
			echo '<li id="view">';
			echo '<ul id="images">';
				
			$this->get_data();
			if( $INFO['perm'] == AUTH_ADMIN ) 
			{
				echo "<li class='add_thumb' id='add_video_thumb' style='text-align:center;'>";
				echo "<input style='width:60px;height:25px; padding:4px 12px 4px 12px;border-radius:4px; background:#0072BC;border:none; color:white; font-weight:bold;margin-left:0px;margin-top:30px;' id='button3' type='button' value='Add' /> <br />";
				echo "<span style='font-size:10px;'> Thumbnail 120x90</span>";
				echo "</li>";
			}
			echo '<li class="video_thumb_container_blank"><a style="display:none;" class="to_show_video" href="#"><img style="display:none;"  src="" /></a></li></ul></li>';
			echo '<li><a id="right_scr" href="#">&gt;&gt;</a></li>';
			echo '</ul>';

			echo "<div style='clear:left;'></div>";
			echo "<div id='video_thumb_upload_progress_bar'><img src='lib/tpl/guu/images/ajax-loader.gif' /></div>";
			echo "<div style='clear:both;'></div>";
			echo "</div>";

echo <<<EOF
<div id="add_video_dialog" style="display:none; background-color:transparent;">

    <div id="add_video" style="float:left;">   
        <noscript>    
            <p>Please enable JavaScript to use file uploader.</p>
            <!-- or put a simple form for upload here -->
        </noscript>    
    </div>

	<!-- <input type="button" value="upload video thumb" id="add_video_thumb_pic" style="height:25px; width:160px; margin-left:15px;" /> -->
	
    <div id="add_video_small_thumb" style="float:left;display:none;">
           <noscript> 
			<p>Please enable JavaScript to use file uploader.</p>
			<!-- or put a simple form for upload here -->        
		 </noscript>         
    </div>

<!--	<input type="button" value="upload small thumb" id="add_video_small_thumb" style="height:25px; width:160px; margin-left:15px;" /> -->
	<div style="clear:both;"></div>

	<br />
	<span id='info'></span>	
	<br />
	<div id="video_area">
	</div>
	<div style="display:none;">
		<br /> Or&nbsp; you can embed a video from youku or tudou <br /> 
		<span>URL:&nbsp;</span>
		<textarea id="url_bar" cols="60" rows="10" ></textarea> <br /> <br />
	</div>
	
	<img src ="lib/tpl/guu/images/ajax-loader.gif" id="ajaximg" style="display:none;" /> <br />
	<input type="button" id="done" value="Done" style="height:25px;width:80px;"/>
	<span id='ert' ></span>
	<input type="hidden" id="check" value="-1" />
</div>

EOF;
		$event->preventDefault();  
	}

}
