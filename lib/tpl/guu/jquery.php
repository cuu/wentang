<script type="text/javascript" >

jQuery.noConflict();	
jQuery(document).ready(function($) {

	$('#add_pic_dialog').bind('dialogclose', function(event) {
		$("#big_image img:last-child").remove();
		$("#big_image").children().each( function() {
			$(this).show();
		});
		// this is to clean the output from last time
 	});

	 
	$("#pic_grid_add_pic").click( function()
	{
		$("#add_pic_dialog").dialog({width:'auto',height:'auto',resizable: false });  	
		
	});
	
	$("#add_pic_dialog > #upload > input").click ( function()
	{
		$("#add_pic_dialog").dialog('close');		
	});
	

	$("#add_big_video > #add").click (function()
	{
		$("#add_video_dialog").dialog( {width:'auto',height:'auto',resizable: false } );
	});
	
	$("#add_video_dialog > #done").click (function ()
	{
		$("#add_video_dialog").dialog('close');
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
				info.text("Done!");
				info.fadeIn("slow");
				info.fadeOut(3500);
				
				
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



	var button3 = $('#add_video_thumb #button3'), interval3;
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
			
			info.text("Done! "+response);					
			if( response.indexOf("success") != -1)
			{

				var real_file ="data/media/"+file;
				
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
				
				$("#add_big_video").append('<embed type="application/x-shockwave-flash" src="player.swf?v1.3" id="f4Player" flashvars="video='+real_file+"  allowscriptaccess="always" allowfullscreen="true" bgcolor="#000000" height="270" width="480"><noembed>You need Adobe Flash Player to watch this video. &lt;br&gt; &lt;</noembed>');
				

					
//               	$("#add_big_video embed:last-child").draggable(); 
				
				
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



//\\\\\\\\\\\\\\\\\\\\\\\/////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\/////////////\\\\
});

</script>

