
<script type="text/javascript" charset="utf-8" src="lib/tpl/guu/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" charset="utf-8" src="lib/tpl/guu/js/jquery.json-2.3.min.js"></script>

<script type="text/javascript" >

function validateURL(textval) {
	if(textval.indexOf("http") == -1) return false;
	else return true;
}


jQuery.noConflict();	
jQuery(document).ready(function($) {


$("#container").fadeIn(3400);	
$("#container").css("display","show");


	$.easing.backout = function(x, t, b, c, d){
		var s=1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	};

	$.easing.easeInQuad =  function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	};	

	$('#screen').scrollShow({
		view:'#view',
		content:'#images',
		easing:'backout',
		wrappers:'link,crop',
		navigators:'a[id=left_scr],a[id=right_scr]',
		navigationMode:'s',
		circular:true,
		start:0
	});

	$("#add_pic_dialog #make_it_default").change( function()
	{
		if( $(this).attr('checked') == "checked")
		{
			var thumb_img = $("#add_pic_dialog #add_thumb img:last-child").attr("src");

			if( thumb_img != undefined )
			{
				$.ajax({
					url:"mysql.php?default="+thumb_img+"&parent=<?php echo $_GET["album"]; ?>",
					success:function(data)
					{
						
					}
				});
			}else
			{
				alert("亲，请先选择一张存在的缩略图吧");
			}
		}
    
	});

	$('#add_pic_dialog').bind('dialogclose', function(event) {
		$("#big_image img:last-child").remove();
		$("#big_image").children().each( function() {
			$(this).show();
		});
		
		$("#add_pic_dialog #check").val("-1");
		// this is to clean the output from last time
 	});
	
	$('#add_video_dialog').bind('dialogclose', function(event) {

		$("#add_video_dialog #check").val("-1");
		
	});
	 
	$("#pic_grid_add_pic").click( function()
	{
		$("#add_pic_dialog").dialog({width:'auto',height:'auto',resizable: false });  	
		
	});
	
	$("button").button();
	
	$(".add_splash #add").click (function()
	{
		$("#add_splash_dialog").dialog({width:'auto',height:'auto',resizable: false });
	});
	
	$("#add_splash_dialog #done").click(function()
	{
		$("#add_splash_dialog").dialog("close");
		location.reload(true);
	});

	$("#add_pic_dialog  #upload  input").click ( function()
	{
		$("#add_pic_dialog").dialog('close');
		location.reload(true);	
	});
	
	$(".add_album #add ").click (function()
	{
		$.ajax({
			url:"mysql.php?addalbum=yes",
			success:function(data)
			{
				if(data == "success")
				{
					location.reload(true);
				}else
				{
					alert("创建相册失败："+data);
				}
			}
		});
	});	

	$("#add_big_video  input").click (function()
	{
		$("#add_video_dialog").dialog( {width:'auto',height:'auto',resizable: false } );
		$("#add_video_dialog #url_bar ").val("");
	});

	$("#add_video_thumb #button3").click (function ()
	{
		$("#add_video_dialog").dialog( {width:'auto',height:'auto',resizable: false } );
	});	

	$("#add_video_dialog  #done").click (function ()
	{
		$("#add_video_dialog").dialog('close');
//		$("#add_video_thumb #check").val("-1");
		$("#add_video_dialog #url_bar").val("");
		location.reload(true);
	});

	/*
	$("#add_video_thumb").click( function ()
	{
		var html= "<?php 

echo   "<div class='add_big_img' id='add_big_video' style='overflow:hidden;' ><center>";
echo "<input style='width:80px;height:25px;' id='add' type='button' value='Add' /><br />";
echo "<span>Add image/video ,Size Max layout 798x798 px,Only <b>flv</b> can be supported "."Video upload Max:".ini_get('upload_max_filesize')."</span>";
echo "</center></div>";
?>";
		$("#video_big_area").fadeOut("slow").html(html).fadeIn("slow");

	});
	*/

	$("#to_show_video").click(function()
	{
		
	});
	
	var splash_pos = new Array();

	$(".splash_div").each (function(index)
	{
		splash_pos.push(  $(this).position()  );
	
	});

	splash_pos.push( $("center").position() );

	$(".splash_div").draggable( { zIndex: 2700  ,
		axis: 'y',
		cursor: 'crosshair',
		start: function(event, ui) 
		{
			 
		},
		drag: function(event, ui) {
			
			$("#splash_slider_add_splash").html( splash_pos[0].top + " "+ splash_pos[1].top );
		}
	});


	$(".splash_div").hover(function()
	{
		$(this).find("#close_img").fadeIn("fast");
	},function()
	{
		$(this).find("#close_img").fadeOut("fast");
	});

    $(".splash_div .close_img").click(function()
    {
        if (confirm("要删掉这个［首页图片］么？不要后悔哟"))
        {
            
            $.ajax({
                url:"mysql.php?delete=yes&tab=splash&pid="+$(this).attr('rel'),
                success:function(data)
                {
                    if(data == "success")
                    {
                        alert("删除成功");
                        location.reload(true);
                    }else
                    {
                        alert("删除失败，错误:"+data);
                    }
                    
                }
            }); 
        }   
    });





	$(".album_container").hover (function()
	{
		$(this).find("#close_img").fadeIn("fast");
	},function()
	{
		$(this).find("#close_img").fadeOut("fast");
	});

    $(".album_container .close_img").click(function()
    {
        if (confirm("要删掉这个［相册］么？不要后悔哟"))
        {
            
            $.ajax({
                url:"mysql.php?delete=yes&tab=pic&pid="+$(this).attr('rel'),
                success:function(data)
                {
                    if(data == "success")
                    {
                        alert("删除成功");
                        location.reload(true);
                    }else
                    {
                        alert("删除失败，错误:"+data);
                    }
                    
                }
            }); 
        }   
    });

	$(".pic_container").hover(function()
	{
		$(this).find("#close_img").fadeIn("fast");
	},function()
	{
		$(this).find("#close_img").fadeOut("fast");
	});

	$(".pic_container .close_img").click(function()
	{
        if (confirm("要删掉这个图片么？不要后悔哟"))
        {
            
            $.ajax({
                url:"mysql.php?delete=yes&tab=pics&pid="+$(this).attr('rel'),
                success:function(data)
                {
                    if(data == "success")
                    {
                        alert("删除成功");
                        location.reload(true);
                    }else
                    {
                        alert("删除失败，错误:"+data);
                    }
                    
                }
            }); 
        }	
	});

	$(".video_thumb_container").hover(function()
	{
		
		$(this).find("#close_img").fadeIn("fast");
	},function()
	{
		$(this).find("#close_img").fadeOut("fast");
	});
	
	$(".video_thumb_container .close_img").click(function()
	{
		if (confirm("要删掉这个视频么？不要后悔哟"))
		{
			
			$.ajax({
				url:"mysql.php?delete=yes&tab=video&pid="+$(this).attr('rel'),
				success:function(data)
				{
					if(data == "success")
					{
						alert("删除成功");
						location.reload(true);
					}else
					{
						alert("删除失败，错误:"+data);
					}
					
				}
			}); 
		}
	
	});

//  $("#add_pic_dialog").dialog( { autoOpen: false } );

	var button = $('#add_thumb #button1'), interval;
	if( button.length == 0) 
	{ 
	}
	else
	{
	new AjaxUpload(button,{
		action: 'php.php', 
		name: 'qqfile',
		onSubmit : function(file, ext){
			// change button text, when user selects file			
			button.text('Uploading');
			this.disable();
			// Uploding -> Uploading. -> Uploading...
			interval = window.setInterval(function(){
				var text = button.text();
				if (text.length < 16){
					button.text(text + '.');					
				} else {
					button.text('Uploading');				
				}
			}, 200);
		},
		onComplete: function(file, response){
			var info = $("#add_thumb  span");
			button.text('Add');
			window.clearInterval(interval);			
			// enable upload button
			this.enable();
			
			info.text("Done! "+response);					
			if( response.indexOf("success") != -1)
			{
				var real_file ="data/media/"+file;

				$("#add_thumb img:last-child").remove();
				$("#add_thumb").children().each( function() {
					$(this).show();
				});
				
				
				info.text("Done!");
				info.fadeIn("slow");
				info.fadeOut(3500);

				$("#add_thumb").children().each(function() {
					$(this).hide();
				});
//				alert( $("#add_pic_dialog  #check").val() );	 -1

				$.ajax({
					url: "mysql.php?id="+ $("#add_pic_dialog  #check").val() +"&thumb="+real_file+"&tab=pics&parent=<?php echo $_GET["album"]; ?>",
					success: function(data){
				//		alert(data);
						if( parseInt(data) > 0 && parseInt( $("#add_pic_dialog #check").val()) == -1 )
						{
							$("#add_pic_dialog #check").val( data );
							//alert( $("#add_pic_dialog #check").val() );
						}
					}
				});
				
				$("#add_thumb").append("<img src='"+real_file+"' />")
					
 //              	$("#add_thumb img:last-child").draggable(); 
				
				
			}else
			{
				info.text("Error!");
				info.fadeIn("slow");
				info.fadeOut(3500);
			}
		
		}
	});
	}
	
    var button2 = $('#big_image #button2'), interval2;
	if(button2 .length != 0 )
	{
    new AjaxUpload(button2,{
        //action: 'upload-test.php',
        action: 'php.php', 
        name: 'qqfile',
        onSubmit : function(file, ext){
            button2.text('Uploading');
            this.disable();
            interval2 = window.setInterval(function(){
                var text = button2.text();
                if (text.length < 16){
                   	button2.text(text + '.');                    
                } else {
                    button2.text('Uploading');               
                }
            }, 200);
        },
        onComplete: function(file, response){
            var info = $("#big_image > span");
            button2.text('Add');
            window.clearInterval(interval2);         

            this.enable();
            
            info.text("Done! "+response);                   
            if( response.indexOf("success") != -1)
            {
				//var real_file = "<?php echo DOKU_INC."data/media/"; ?>"+file;
				var real_file ="data/media/"+file;
				
				$("#big_image img:last-child").remove();
				$("#big_image").children().each( function() {
					$(this).show();
				});
				
                info.text("Done!");
				info.fadeIn("slow");
				info.fadeOut(3500);
				
				$("#big_image").children().each(function() {
					$(this).hide();
				});
//				alert( $("#add_pic_dialog > #check").val() );	 -1

				$.ajax({
					url: "mysql.php?id="+ $("#add_pic_dialog  #check").val() +"&data="+real_file+"&tab=pics&parent=<?php echo $_GET["album"] ?>",
					success: function(data){
				//		alert(data);
						if( !isNaN(parseInt(data))  && parseInt($("#add_pic_dialog #check").val() ) == -1 )
						{
							$("#add_pic_dialog #check").val( data );
						//	alert( $("#add_pic_dialog #check").val() );
						}
					}
				});
	
				$("#big_image").append("<img src='"+real_file+"' />")
					
               	$("#big_image img:last-child").draggable(); 
				
            }else
            {
                info.text("Error!");
				info.fadeIn("slow");
                info.fadeOut(3500);
            }
        
        }
    });
	}



	var button3 = $('#add_video_dialog  #add_video_small_thumb'), interval3;
	if(button3.length != 0)
	{
	new AjaxUpload(button3,{
		//action: 'upload-test.php', // I disabled uploads in this example for security reasons
		action: 'php.php', 
		name: 'qqfile',
		onSubmit : function(file, ext){
			// change button text, when user selects file			
			button3.text('Uploading');
			this.disable();
			// Uploding -> Uploading. -> Uploading...
			interval3 = window.setInterval(function(){
				var text = button3.text();
				if (text.length < 16){
					button3.text(text + '.');					
				} else {
					button3.text('Uploading');				
				}
			}, 200);
		},
		onComplete: function(file, response){
			var info = $("#add_video_thumb  span");
			button3.text('Add');
			window.clearInterval(interval3);			
			// enable upload button
			this.enable();
			
			info.text("Done! "+response);					
			if( response.indexOf("success") != -1)
			{

				var real_file ="data/media/"+file;
				
				$("#add_video_thumb img:last-child").remove();
				$("#add_video_thumb").children().each( function() {
					$(this).show();
				});
				
                info.text("Done!");
				info.fadeIn("slow");
				info.fadeOut(3500);
				
				$("#add_video_thumb").children().each(function() {
					$(this).hide();
				});
//				alert( $("#add_pic_dialog > #check").val() );	 -1
				$.ajax({
					url: "mysql.php?id="+ $("#add_video_dialog #check").val() +"&st="+real_file+"&tab=video",
					success: function(data){
				//		alert(data);
						if( !isNaN(parseInt(data))  && parseInt($("#add_video_dialog #check").val() ) == -1 )
						{
							$("#add_video_dialog #check").val( data );
						//	alert( $("#add_pic_dialog #check").val() );
						}
					}
				});
	
				$("#add_video_thumb").append("<img src='"+real_file+"' />")
					
//               	$("#add_video_thumb img:last-child").draggable(); 
				
				
			}else
			{
				info.text("Error!");
				info.fadeIn("slow");
				info.fadeOut(3500);
			}
		
		}
	});
	}else 
	{
		//alert("selector erorr");
	}


	var button4 = $('#add_video_dialog #add_video_thumb_pic'), interval4;
	if(button4.length != 0)
	{
	new AjaxUpload(button4,{
		//action: 'upload-test.php', // I disabled uploads in this example for security reasons
		action: 'php.php', 
		name: 'qqfile',
		onSubmit : function(file, ext){
			// change button text, when user selects file			
			button4.text('Uploading');
			this.disable();
			// Uploding -> Uploading. -> Uploading...
			interval4 = window.setInterval(function(){
				var text = button4.text();
				if (text.length < 16){
					button4.text(text + '.');					
				} else {
					button4.text('Uploading');				
				}
			}, 200);
		},
		onComplete: function(file, response){
			var info = $("#add_video_dialog  #info");
			button4.text('Add');
			window.clearInterval(interval4);			
			// enable upload button
			this.enable();
			
			info.text("Done! "+response);					
			if( response.indexOf("success") != -1)
			{

				var real_file ="data/media/"+file;
				
				$("#add_big_video img:last-child").remove();
				$("#add_big_video").children().each( function() {
					$(this).show();
				});
				
                info.text("Done!");
				info.fadeIn("slow");
				info.fadeOut(3500);
				
				$("#add_big_video").children().each(function() {
					$(this).hide();
				});
//				alert( $("#add_pic_dialog > #check").val() );	 -1
				
				$("#add_big_video").append("<img src='"+real_file+"' />")
					
               	$("#add_big_video img:last-child").draggable(); 

				$.ajax({
					url: "mysql.php?id="+ $("#add_video_dialog #check").val() +"&thumb="+real_file+"&tab=video",
					success: function(data){
				//		alert(data);
						if( !isNaN(parseInt(data))  && parseInt($("#add_video_dialog #check").val() ) == -1 )
						{
							$("#add_video_dialog #check").val( data );
						//	alert( $("#add_pic_dialog #check").val() );
						}
					}
				});
	
//				$("#add_video_dialog img:last-child").remove();
//				$("#add_video_dialog #video_area").append("<img src='"+real_file+"' />");

			}else
			{
				info.text("Error!");
				info.fadeIn("slow");
				info.fadeOut(3500);
			}
		
		}
	});
	}else 
	{
		//alert("selector erorr");
	}

	
	var button5 = $('#add_video_dialog #add_video'), interval5;
	if(button5.length != 0)
	{
	new AjaxUpload(button5,{
		//action: 'upload-test.php', // I disabled uploads in this example for security reasons
		action: 'php.php', 
		name: 'qqfile',
		onSubmit : function(file, ext){
			// change button text, when user selects file			
			button5.text('Uploading');
			this.disable();
			// Uploding -> Uploading. -> Uploading...
			interval5 = window.setInterval(function(){
				var text = button5.text();
				if (text.length < 16){
					button5.text(text + '.');					
				} else {
					button5.text('Uploading');				
				}
			}, 200);
		},
		onComplete: function(file, response){
			var info = $("#add_video_dialog  #info");
			button5.text('Add');
			window.clearInterval(interval5);			
			// enable upload button
			this.enable();
			
			info.text("Done! "+response );					
			if( response.indexOf("success") != -1)
			{

				var real_file ="data/media/"+file;
/*					
				$("#add_big_video embed:last-child").remove();
				$("#add_big_video").children().each( function() {
					$(this).show();
				});
				
                info.text("Done!");
				info.fadeIn("slow");
				info.fadeOut(3500);
				
				$("#add_big_video").children().each(function() {
					$(this).hide();
				});
//				alert( $("#add_pic_dialog > #check").val() );	 -1
				
				$("#add_big_video").append('<embed type="application/x-shockwave-flash" src="player.swf?v1.3" id="f4Player" flashvars="video='+real_file+'"  allowscriptaccess="always" allowfullscreen="true" bgcolor="#000000" height="270" width="480"><noembed>You need Adobe Flash Player to watch this video. &lt;br&gt; &lt;</noembed>');
				

					
//               	$("#add_big_video embed:last-child").draggable(); 
*/
				$.ajax({
					url: "mysql.php?id="+ $("#add_video_dialog #check").val() +"&data="+real_file+"&tab=video",
					success: function(data){
				//		alert(data);
						if( !isNaN(parseInt(data))  && parseInt($("#add_video_dialog #check").val() ) == -1 )
						{
							$("#add_video_dialog #check").val( data );
						//	alert( $("#add_pic_dialog #check").val() );
						}
					}
				});
/*
					$("#add_video_dialog #video_area").html('<embed type="application/x-shockwave-flash" src="http://127.0.0.1/doku/lib/tpl/guu/js/player.swf?v1.3" id="f4Player" flashvars="video='+real_file+'"  allowscriptaccess="always" allowfullscreen="true" bgcolor="#000000" height="270" width="480">'+
"<noembed>"+
"You need Adobe Flash Player to watch this video. &lt;br&gt; "+
'&lt;a href="http://get.adobe.com/flashplayer/"&gt;Download it from Adobe.&lt;/a&gt;'+
'&lt;a href="http://gokercebeci.com/dev/f4player" title="flv player"&gt;flv player&lt;/a&gt;'+
'</noembed>');
*/
				
			}else
			{
				info.text("Error!" + response);
			//	info.fadeIn("slow");
			//	info.fadeOut(3500);
			}
		
		}
	});
	}else 
	{
		//alert("selector erorr");
	}

	$("#add_video_dialog #url_bar").change(function()
	{
		var txt = $.trim( $(this).val() );

		if( validateURL(txt))
		{
			$.ajax({
				url: 'get_embed.php?url='+txt,
				beforeSend: function() {
					$("#add_video_dialog #ert").fadeIn("fast");
  					$("#add_video_dialog #ert").html("Updating...");
  				},
				success: function( data ) {
				//	alert(data);
					var embedcode =  $.evalJSON( data ).data.object;
					var thumb_img =  $.evalJSON( data ).data.img;
					
					if( embedcode != undefined )
					{
						$.ajax({
							url: "mysql.php?id="+ $("#add_video_dialog #check").val() +"&data="+embedcode+"&thumb="+thumb_img+"&tab=video",
							success: function(data){
								//alert(data);
								if( !isNaN(parseInt(data))  && parseInt($("#add_video_dialog #check").val() ) == -1 )
								{
									$("#add_video_dialog #check").val( data );
								//	alert( $("#add_pic_dialog #check").val() );
								}
							}
						});	
						$("#add_video_dialog #url_bar").val( embedcode);
					}

					$("#add_video_dialog #ert").html("Done...");
					$("#add_video_dialog #ert").fadeOut(2500);
				}
			});
			
		}
		else
		{
			
		}
		
	});


    var button6 = $('#add_splash #add'), interval6;
    if( button6.length == 0) { }
    else
    {
    new AjaxUpload(button6,{
        action: 'php.php', 
        name: 'qqfile',
        onSubmit : function(file, ext){
            // change button text, when user selects file           
            button6.text('Uploading');
            this.disable();
            // Uploding -> Uploading. -> Uploading...
            interval6 = window.setInterval(function(){
                var text = button6.text();
                if (text.length < 16){
                    button6.text(text + '.');                    
                } else {
                    button6.text('Uploading');               
                }
            }, 200);
        },
        onComplete: function(file, response){
            var info = $("#add_splash span");
            button6.text('Add');
            window.clearInterval(interval6);         
            // enable upload button
            this.enable();
            
            info.text("Done! "+response);                   
            if( response.indexOf("success") != -1)
            {
                var real_file ="data/media/"+file;

                $("#preview img:last-child").remove();
                $("#preview").children().each( function() {
                    $(this).show();
                });
                info.text("Done!");
                info.fadeIn("slow");
                info.fadeOut(3500);
                $("#preview").children().each(function() {
                    $(this).hide();
                });
//              alert( $("#add_pic_dialog  #check").val() );     -1
                $.ajax({
                    url: "mysql.php?id="+ $("#add_splash_dialog  #check").val()+"&data="+real_file+"&tab=splash&parent=9999",
                    success: function(data){
//                      alert(data);
                        if( parseInt(data) > 0 && parseInt( $("#add_splash_dialog #check").val()) == -1 )
                        {
                            $("#add_splash_dialog #check").val( data );
                            //alert( $("#add_pic_dialog #check").val() );
                        }
                    }
                });
                $("#preview").append("<img src='"+real_file+"' />")
				$("#preview img:last-child").draggable();  
            }else
            {
                info.text("Error!");
                info.fadeIn("slow");
                info.fadeOut(3500);
            } 
        }
    });
    }
	
	$("a[rel=group1]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'showNavArrows':'true'
				});
//\\\\\\\\\\\\\\\\\\\\\\\/////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\/////////////\\\\
});

</script>

