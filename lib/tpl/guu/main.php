<?php
/**
 * DokuWiki Default Template
 *
 * This is the template you need to change for the overall look
 * of DokuWiki.
 *
 * You should leave the doctype at the very top - It should
 * always be the very first line of a document.
 *
 * @link   http://dokuwiki.org/templates
 * @author Andreas Gohr <andi@splitbrain.org>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="Author" content="Guu" />
  <title>
    <?php /*tpl_pagetitle() */?>
    <?php echo strip_tags($conf['title'])?>
  </title>
	<?php
		if ( $INFO['perm'] != AUTH_ADMIN )
		{
			include_once "jqui-darkness.php";
			tpl_metaheaders();
		}
		else
		{

			include_once "jqui-lightness.php"; 
			tpl_metaheaders();
			echo " 

			<link rel='stylesheet' href='lib/tpl/default/design.css' type='text/css' media='all' />
			<link rel='stylesheet' href='lib/tpl/default/layout.css' type='text/css' media='all' />
			<link rel='stylesheet' href='lib/tpl/default/rtl.css' type='text/css' media='all' />

			<link rel='stylesheet' href='lib/tpl/default/media.css' type='text/css' media='all' />
			<link rel='stylesheet' href='lib/tpl/default/_linkwiz.css' type='text/css' media='all' />

			<link rel='stylesheet' href='lib/tpl/default/_mediaoptions.css' type='text/css' media='all' />

			";
		}
	?>

  <link rel="shortcut icon" href="<?php echo tpl_getFavicon() ?>" />

<?php 
	if($INFO['perm'] ==AUTH_ADMIN )
	{
		include_once "ajaxupload.php";
	}else
	{
		include_once "slicebox.php";
	}
	include_once "fancybox.php"; 

	include_once "flowplayer.php";
	
	include_once "jquery.scrollshow.php";
	
	if($INFO['perm'] ==AUTH_ADMIN )
	{
		include_once "jquery.jcrop.php";
		include_once "jquery.bubblepopup.php";
		include_once "jquery.php"; 
	}else
	{
		include_once "jquery_noadmin.php";
	}
?>
	
  <?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?>
</head>

<body>
<div class="dokuwiki">

  <div class="stylehead" >

    <div class="header" style="margin-top:0px; margin-bottom:20px;">
		<div class='logo_noball' style="height:100px;width:100px; text-align:center; line-height:60px; margin:0 auto; ">
			<img src="lib/tpl/guu/images/wentang_logo_noball.jpg" style="vertical-align:middle;margin-top:7px;" /> 
		</div>
      <div class="logo"  style="color:red; margin:0 auto;">
		<?php /*old includehook*/ @include(dirname(__FILE__).'/logo.html')?>

      </div>

 <?php /*old includehook*/ @include(dirname(__FILE__).'/footer.php')?>

      <div class="clearer"></div>
    </div>

    <?php /*old includehook*/ @include(dirname(__FILE__).'/header.html')?>

<?php 
	if ( $INFO['perm'] == AUTH_ADMIN )
	{
?>
    <div class="bar" id="bar__top">
      <div class="bar-left" id="bar__topleft">
        <?php tpl_button('edit')?>
        <?php tpl_button('history')?>
      </div>

      <div class="bar-right" id="bar__topright">
        <?php tpl_button('recent')?>
        <?php tpl_searchform()?>&nbsp;
      </div>

      <div class="clearer"></div>
    </div>
<?php
	}
?>
	



    <?php if($conf['youarehere']){?>
    <div class="breadcrumbs">
      <?php tpl_youarehere() ?>
    </div>
    <?php }?> 


  </div>
  <?php tpl_flush()?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>

  <div class="page">
    <?php tpl_content()?>
  </div>

  <div class="clearer"></div>

  <?php tpl_flush()?>

  <div class="stylefoot">

    <div class="meta">
      <div class="user">
        <?php tpl_userinfo()?>
      </div>
      <div class="doc">
        <?php tpl_pageinfo()?>
      </div>
    </div>


<?php
	if ( $INFO['perm'] == AUTH_ADMIN )
	{
?>
    <div class="bar" id="bar__bottom">
      <div class="bar-left" id="bar__bottomleft">
        <?php tpl_button('edit')?>
        <?php tpl_button('history')?>
        <?php tpl_button('revert')?>
      </div>
      <div class="bar-right" id="bar__bottomright">
        <?php tpl_button('subscribe')?>
        <?php tpl_button('admin')?>
        <?php tpl_button('profile')?>
        <?php tpl_button('login')?>
        <?php tpl_button('index')?>
        <?php tpl_button('top')?>&nbsp;
      </div>
      <div class="clearer"></div>
    </div>

<?php
	}
?>	

  </div>


</div>

<div class="no"><?php /* provide DokuWiki housekeeping, required in all templates */ tpl_indexerWebBug()?></div>
</body>
</html>
