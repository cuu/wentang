<!-- <center> -->
<div class="footerinc" >
	<ul class="piped right"> 
<!--	<li><span style="font-size:10px;">
			本网站所有内容版权归玟唐传播所有 ©2011 &nbsp; 
			Copyright &copy 2011 All rights reserverd by Wentang Media Inc </span></li>
-->
<?php
		if($INFO["isadmin"] || $INFO["ismanager"] )
		{
		}
		else
		{
?>
		<li><a href="?do=login" >登录</a></li> 
<?php 
		}
?>
		<li><a href="#">微博</a></li>
		<li><a href="#">博客</a></li>
		<li><a href="#">联系</a></li>
		<li><a href="#">服务</a></li>
		<li><a href="#">团队</a></li>
		<li><a href="#">照片</a></li>
		<li><a href="#">影片</a></li>
		<li><a href="#">首页</a></li>

	</ul>
	<div style="clear:both;"></div>
</div> <!-- end footerinc -->
    <div class="piped right" style="height:100%;width:100%;">
    <span style="font-size:10px;text-align:center;" >
            本网站所有内容版权归<span style="color:#B72E00;">玟唐传播</span>所有 ©2011 &nbsp;<br /> 
            Copyright &copy 2011 All rights reserverd by Wentang Media Inc </span>  
    </div>
	<div style="clear:both;"></div> 
<!-- </center> -->
<?php

?>
