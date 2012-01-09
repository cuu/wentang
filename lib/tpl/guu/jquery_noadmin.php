
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

		
	$("a[rel=group1]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'showNavArrows':'true'
				});

    $(".album_container").hover (function()
    {
        $(this).css("border-color","orange");
    },function()
    {
        $(this).css("border-color","#888");
    });



	$('#sb-slider').slicebox({
		orientation			: 'h',
		slicesCount			: 3,
		disperseFactor		: 25,
		sequentialRotation	: true,
		sequentialFactor	: 140,
		slideshow			: true
	});



    $(".video_thumb_container").hover(function()
    {
        
        $(this).find("#play_img").fadeIn("fast");

    },function()
    {
        $(this).find("#play_img").fadeOut("fast");
    })

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

