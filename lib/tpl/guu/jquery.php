
<script type="text/javascript" charset="utf-8" src="lib/tpl/guu/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" charset="utf-8" src="lib/tpl/guu/js/jquery.json-2.3.min.js"></script>

<script type="text/javascript" >

function validateURL(textval) {
	if(textval.indexOf("http") == -1) return false;
	else return true;
}

function explode (delimiter, string, limit) 
{
    var emptyArray = {
        0: ''
    };
 
    // third argument is not required
    if (arguments.length < 2 || typeof arguments[0] == 'undefined' || typeof arguments[1] == 'undefined') {
        return null;
    }
 
    if (delimiter === '' || delimiter === false || delimiter === null) {
        return false;
    }
 
    if (typeof delimiter == 'function' || typeof delimiter == 'object' || typeof string == 'function' || typeof string == 'object') {
        return emptyArray;
    }
 
    if (delimiter === true) {
        delimiter = '1';
    }
 
    if (!limit) {
        return string.toString().split(delimiter.toString());
    }
    // support for limit argument
    var splitted = string.toString().split(delimiter.toString());
    var partA = splitted.splice(0, limit - 1);
    var partB = splitted.join(delimiter.toString());
    partA.push(partB);
    return partA;
}// func end

jQuery.noConflict();	
jQuery(document).ready(function($) {


$.fn.disable = function() {
	$(this).attr("disabled","disabled");
};
$.fn.enable = function()
{
	$(this).removeAttr("disabled");
}

$("#container").fadeIn(3400);	
$("#container").css("display","show");


	$.easing.backout = function(x, t, b, c, d){
		var s=1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	};

	$.easing.easeInQuad =  function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	};	


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
/*	
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
		}
	});

*/	
	var result0; var result;	
	$( "#sortable" ).sortable({axis:"y",
					start:function(event,ui) {
						result0 = $(this).sortable('toArray');
						
					},
	                update: function(event, ui) {
                        result = $(this).sortable('toArray');
//						alert( result.toString() );
						
						var t1 = explode(',', result0.toString() );
						var t2 = explode(',', result.toString() );
						$.ajax({
							url:"mysql.php?switch=yes&a="+t1+"&b="+t2+"&tab=splash",
							success: function(data){
//								alert(data);
  							},
							error:function(jqXHR, textStatus, errorThrown)
							{
								
							}
						});
                    }

	});

	$( "#sortable" ).disableSelection();


	$(".splash_div").hover(function()
	{
		$(this).find("#close_img").fadeIn("fast");
	},function()
	{
		$(this).find("#close_img").fadeOut("fast");
	});

    $(".splash_div .close_img").click(function()
    {
		var t = $(this);
        if (confirm("要删掉这个［首页图片］么？不要后悔哟"))
        {
            
            $.ajax({
                url:"mysql.php?delete=yes&tab=splash&pid="+$(this).attr('rel'),
				beforeSend:function(xhr)
				{
				},
                success:function(data)
                {
                    if(data == "success")
                    {
                        alert("删除成功");
                        //location.reload(true); 
						t.parent().fadeOut("fast");
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
		var t = $(this);
		
        if (confirm("要删掉这个［相册］么？不要后悔哟"))
        {
            
            $.ajax({
                url:"mysql.php?delete=yes&tab=pic&pid="+$(this).attr('rel'),
                success:function(data)
                {
                    if(data == "success")
                    {
                       alert("删除成功");
//                        location.reload(true);
						t.parent().fadeOut("fast");
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
		var t = $(this);

        if (confirm("要删掉这个图片么？不要后悔哟"))
        {
            
            $.ajax({
                url:"mysql.php?delete=yes&tab=pics&pid="+$(this).attr('rel'),
                success:function(data)
                {
                    if(data == "success")
                    {
                        alert("删除成功");
//                        location.reload(true);
						t.parent().fadeOut("fast");
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

		$(this).find("#edit_img").fadeIn("fast");
	},function()
	{
		$(this).find("#close_img").fadeOut("fast");
		$(this).find("#edit_img").fadeOut("fast");
	});
	
	$(".video_thumb_container .close_img").click(function()
	{
		var t = $(this);
		if (confirm("要删掉这个视频么？不要后悔哟"))
		{
			
			$.ajax({
				url:"mysql.php?delete=yes&tab=video&pid="+$(this).attr('rel'),
				success:function(data)
				{
					if(data == "success")
					{
						alert("删除成功");
//						location.reload(true);
						t.parent().fadeOut("fast");
					}else
					{
						alert("删除失败，错误:"+data);
					}
					
				}
			}); 
		}
	
	});

	$(".video_thumb_container .edit_img").click(function()
	{
		alert("try to upload another file replace this thumb,soon will be!");
	});
//  $("#add_pic_dialog").dialog( { autoOpen: false } );

	var button = $('#add_thumb #button1');
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
			button.disable();
			$("#add_pic_dialog #ajaximg").show();
		},
		onComplete: function(file, response){
			var info = $("#add_thumb  span");
			button.text('Add');
			$("#add_pic_dialog #ajaximg").hide();	
			button.enable();
			
			info.text("Done! "+response);					
			if( response.indexOf("success") != -1)
			{
				var real_file = $.evalJSON( response  ).success;

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
	
    var button2 = $('#big_image #button2');
	if(button2.length != 0 )
	{
    new AjaxUpload(button2,{
        //action: 'upload-test.php',
        action: 'php.php', 
        name: 'qqfile',
        onSubmit : function(file, ext){
            button2.text('Uploading');
            button2.disable();
			$("#add_pic_dialog #ajaximg").show();

        },
        onComplete: function(file, response){
            var info = $("#big_image > span");
            button2.text('Add');
			$("#add_pic_dialog #ajaximg").hide();
            button2.enable();
            
            info.text("Done! "+response);                   
            if( response.indexOf("success") != -1)
            {
				//var real_file = "<?php echo DOKU_INC."data/media/"; ?>"+file;
				var real_file = $.evalJSON( response  ).success;
				
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

	var btns4 = $('#add_video_dialog #add_video_small_thumb');
	if( btns4.length > 0)
	{
	//add video small thumb
	var uploader4 = new qq.FileUploader({
		element: $('#add_video_dialog #add_video_small_thumb')[0],
		action: 'php.php', name: 'qqfile',debug: true,
		text:"Upload a  video thumb image ",
		onSubmit: function(id, fileName){
			$("#add_video_small_thumb .qq-upload-list").fadeIn("fast");
		},
		onComplete: function(id, fileName, response)
		{	
            var info = $("#add_video_dialog  #info");
            info.text("Done! "+response.success );                  
            if( response.success )
            {
                var real_file =  response.success;
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
                    url: "mysql.php?id="+ $("#add_video_dialog #check").val() +"&thumb="+real_file+"&tab=video&parent=9999",
                    success: function(data){
                //      alert(data);
                        if( !isNaN(parseInt(data))  && parseInt($("#add_video_dialog #check").val() ) == -1 )
                        {
                            $("#add_video_dialog #check").val( data );
                        //  alert( $("#add_pic_dialog #check").val() );
                        }
						
						$("#add_video_small_thumb .qq-upload-list").fadeOut(3500)

                    }
                }); 
            }else
            {
                info.text("Error!" + response.success);
            //  info.fadeIn("slow");  info.fadeOut(3500);
            }	
		}
	}); 
 	}
	//---------------------

	var button4 = $('#add_video_dialog #add_video_thumb_pic');
	if(button4.length != 0)
	{
	new AjaxUpload(button4,{
		//action: 'upload-test.php', // I disabled uploads in this example for security reasons
		action: 'php.php', 
		name: 'qqfile',
		onSubmit : function(file, ext){
			// change button text, when user selects file			
			button4.text('Uploading');
			button4.disable();
			// Uploding -> Uploading. -> Uploading...
			$("add_video_dialog #ajaximg").show();
		},
		onComplete: function(file, response){
			var info = $("#add_video_dialog  #info");
			button4.text('Add');
			// enable upload button
			$("add_video_dialog #ajaximg").hide();
			button4.enable();
			
			info.text("Done! "+response);					
			if( response.indexOf("success") != -1)
			{

				var real_file = $.evalJSON( response  ).success;
				
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
					url: "mysql.php?id="+ $("#add_video_dialog #check").val() +"&thumb="+real_file+"&tab=video&parent=9999",
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

	var btns5 = $('#add_video_dialog #add_video');
	if( btns5.length > 0)
	{
	var uploader5 = new qq.FileUploader({
		element: $('#add_video_dialog #add_video')[0],
		action: 'php.php', name: 'qqfile',debug: true,
		text:"Upload a  video",
		onSubmit: function(id, fileName){
			$("#add_video .qq-upload-list").fadeIn("fast");
		},
		onComplete: function(id, fileName, response)
		{	
            var info = $("#add_video_dialog  #info");
            info.text("Done! "+response.success );                  
            if( response.success )
            {
                var real_file =  response.success;
                $.ajax({
                    url: "mysql.php?id="+ $("#add_video_dialog #check").val() +"&data="+real_file+                "&tab=video&parent=9999",
                    success: function(data){
                //      alert(data);
                        if( !isNaN(parseInt(data))  && parseInt($("#add_video_dialog #check").val() ) == -1 )
                        {
                            $("#add_video_dialog #check").val( data );
                        //  alert( $("#add_pic_dialog #check").val() );
                        }
						
						$("#add_video .qq-upload-list").fadeOut(3500)

                    }
                }); 
            }else
            {
                info.text("Error!" + response.success);
            //  info.fadeIn("slow");  info.fadeOut(3500);
            }	
		}
	}); 

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
							url: "mysql.php?id="+ $("#add_video_dialog #check").val() +"&data="+embedcode+"&thumb="+thumb_img+"&tab=video&parent=9999",
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


    var button6 = $('#add_splash #add');
    if( button6.length == 0) {  }
    else
    {
    new AjaxUpload(button6,{
        action: 'php.php', 
        name: 'qqfile',
        onSubmit : function(file, ext){
            // change button text, when user selects file           
            button6.text('Uploading');
            button6.disable();
			$("#add_splash_dialog #ajaximg").show();
        },
        onComplete: function(file, response){
            var info = $("#add_splash span");
            button6.text('Add');
			
			$("#add_splash_dialog #ajaximg").hide();	
            button6.enable();
            
            info.text("Done! "+response);                   
            if( response.indexOf("success") != -1)
            {
                var real_file = $.evalJSON( response  ).success;

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
                info.text("Error! " + response);
                info.fadeIn("slow");
                info.fadeOut(6500);
            } 
        }
    });
    }
	
	$(".splash_div img").draggable();	 // I am not sure if this is a good idea

	$("a[rel=group1]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'showNavArrows':'true'
				});


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

//\\\\\\\\\\\\\\\\\\\\\\\/////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\/////////////\\\\
});

</script>

