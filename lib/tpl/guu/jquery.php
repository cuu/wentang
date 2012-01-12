<?php if (!defined('DOKU_INC')) die(); ?>
<?php 
	include_once (DOKU_INC."function.php");
?>

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

function make_photo( file,thumb,id)
{

	return '<div class="pic_container"> <div class="pic"> <a rel="group1" href="'+file+'" ><img alt="pics" src="'+thumb+'"></a></div> <a href="#" rel="'+id+'" class="close_img" id="close_img" style="display: none; "></a> </div>';


}
jQuery.noConflict();	
jQuery(document).ready(function($) {


$.fn.disable = function() {
	$(this).attr("disabled","disabled");
};
$.fn.enable = function()
{
	$(this).removeAttr("disabled");
}

$("#container").fadeIn(2000);	
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
				var thumb_img;
				
			    $.post('preview.php',
                { src:$("#add_thumb #preview").attr("src"),id:$("#add_pic_dialog  #check").val(),x:$("#big_image  #x").val(),y:$("#big_image #y").val(),w:$("#big_image #w").val(),h:$("#big_image #h").val() }, function(data){
                var abc = $.evalJSON( data  ).success;  
                if(abc)
                {
                    /*
                    var file = $("#add_thumb #preview").attr("src");
                    var thumb = abc;
                    var id = $("#add_pic_dialog  #check").val();
                    $("#pic_grid").append ( make_photo(file,thumb,id));                     
                    */
					thumb_img = abc;
            		if( thumb_img != undefined )
            		{
                		$.ajax({
                    		url:"mysql.php?default="+thumb_img+"&parent=<?php echo $_GET["album"]; ?>",
                    		success:function(data){ }
                		});
            		}else
            		{
                		alert("亲，请先选择一张存在的缩略图吧");
            		}			
                }
                else
                {
                    alert(data);
                }
			});
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
		if (parseInt($('#big_image #w').val())) 
		{
				/*
				$.ajax({
					type: 'POST',
					url: 'preview.php?src='+$("#big_image #preview").attr("src")+"&id="+$("#add_pic_dialog     #check").val()+"&x="+$("#big_image #x").val()+"&y="+$("#big_image #y").val()+"&w="+$("#big_image #w").val()+"&h="+$("#big_image #h").val(),
					success: function(data)
					{
						alert(data);
					}
				});
				*/
				
				$.post('preview.php',
				{ src:$("#add_thumb #preview").attr("src"),id:$("#add_pic_dialog  #check").val(),x:$("#big_image #x").val(),y:$("#big_image #y").val(),w:$("#big_image #w").val(),h:$("#big_image #h").val() }, function(data) 
			{
				var abc = $.evalJSON( data  ).success;	
				if(abc)
				{
					/*
					var file = $("#add_thumb #preview").attr("src");
					var thumb = abc;
					var id = $("#add_pic_dialog  #check").val();
					$("#pic_grid").append ( make_photo(file,thumb,id));						
					*/
					location.reload(true);
				}
				else
				{
					alert(data);
				}
			});
				

	
///			location.reload(true);	
		}
		else
		{
			alert('Please select a crop region then press submit.');
		}

		$("#add_pic_dialog").dialog('close');
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
		$(this).find("#edit_img").fadeIn("fast");
	},function()
	{
		$(this).find("#close_img").fadeOut("fast");
		$(this).find("#edit_img").fadeOut("fast");
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


var edit_b = $('.pic_container .edit_img');
	if( edit_b.length > 0)
	{
		$(".pic_container .edit_img").click(function() 
		{
			var thumb_img = $(this).attr("rel");
			$("#msgbox").fadeOut();
			$("#msgbox").html("Set album front page now !....");
			$("#msgbox").fadeIn("fast");

           		$.ajax({
              		url:"mysql.php?default="+thumb_img+"&parent=<?php echo $_GET["album"]; ?>",
               		success:function(data){
						$("#msgbox").html("Done! Now the front page of this album is changed!");
						$("#msgbox").fadeOut(10000);
					}
           		});	
		});

	}	

///////////////////////////////////////////////////////////////////////////////////
	$(".video_thumb_container").hover(function()
	{
		
		$(this).find("#close_img").fadeIn("fast");

//		$(this).find("#edit_img").fadeIn("fast");
	},function()
	{
		$(this).find("#close_img").fadeOut("fast");
//		$(this).find("#edit_img").fadeOut("fast");
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

/*
	var edit_a = $('.video_thumb_container .edit_img');
	if( edit_a.length > 0)
	{
		$(".video_thumb_container .edit_img").each(function() 
		{
			var this_edit = $(this);
			new AjaxUpload( $(this),{
		        action: 'php.php', 
        		name: 'qqfile',
		        onSubmit : function(file, ext){
					$("#video_thumb_upload_progress_bar").show("fast");
				},
				onComplete: function(file, response)
				{
					if( response.indexOf("success") != -1)
					{
						var real_file = $.evalJSON( response ).success;
						$.ajax({
							url: "mysql.php?id="+this_edit.attr("rel")+"&thumb="+real_file+"&tab=video&parent=9999",
							success:function(data)
							{
							//	alert( this_edit.attr("rel") +" " + data);	
								this_edit.parent().find("div").children().attr("src", real_file);
							}
						});	
					}else { alert (response); }
					
					$("#video_thumb_upload_progress_bar").hide("slow");
				}

				});

		});	
		
		
	}
*/
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
	  var jcrop_api, boundx, boundy;
		function updateCoords(c)
		{
				$('#big_image #x').val(c.x);
				$('#big_image #y').val(c.y);
				$('#big_image #w').val(c.w);
				$('#big_image #h').val(c.h);
		};

      function updatePreview(c)
      {
        if (parseInt(c.w) > 0)
        {
          var rx = <?php echo pic_thumb_w(); ?>/ c.w;
          var ry = <?php echo pic_thumb_h(); ?>/ c.h;

          $('#preview').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
		updateCoords(c);
      }
    new AjaxUpload(button2,{
        //action: 'upload-test.php',
        action: 'php.php', 
        name: 'qqfile',
		allowedExtensions: ["jpg","jpeg","png","gif"],
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
	
				$("#big_image").append("<img id='target' src='"+real_file+"' />")
				$("#add_thumb #preview").attr("src", real_file);

               	//$("#big_image img:last-child").draggable();
				$('#target').Jcrop({
					onChange: updatePreview,
					onSelect: updatePreview,
					aspectRatio: 1,
					},function(){
					// Use the API to get the real image size
					var bounds = this.getBounds();
						boundx = bounds[0];
						boundy = bounds[1];
						// Store the API in the jcrop_api variable
						jcrop_api = this;
						jcrop_api.ui.holder.addClass('jcrop-dark');
        				jcrop_api.setOptions({ bgColor: 'black', bgOpacity: 0.4 });
					});
			
				
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
		allowedExtensions: ["jpg","jpeg","png","gif"],
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
		allowedExtensions: ["flv","m4v","mov","wmv","avi","mpeg","mp4","mpg"], 
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
                    url: "mysql.php?id="+ $("#add_video_dialog #check").val() +"&data="+real_file+"&tab=video&parent=9999",
                    success: function(data){
                //      alert(data);
                        if( !isNaN(parseInt(data))  && parseInt($("#add_video_dialog #check").val() ) == -1 )
                        {
                            $("#add_video_dialog #check").val( data );
                        //  alert( $("#add_pic_dialog #check").val() );
                        }
						
						// next I will ajax to create the thumb of this video !
						$.ajax({
							url:"preview.php?id="+$("#add_video_dialog #check").val()+"&src="+real_file,
							success: function(data)
							{	
								info.text( info.text() +" & thumb = "+ data );
							}
						});
						
					//	$("#add_video .qq-upload-list").fadeOut(3500);
                    }
                });
			// next I will ajax to update the thumb of this video !
				 
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

	var screen_ul = $("#screen");
	if( screen_ul.length > 0)
	{
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
	}
//\\\\\\\\\\\\\\\\\\\\\\\/////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\/////////////\\\\
});

</script>

