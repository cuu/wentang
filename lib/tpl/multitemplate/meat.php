<?php global $DOKU_TPL,$DOKU_TPLINC; ?>
<?php
/** Multitemplate for DokuWiki
 * By Terence J. Grant
 * tjgrant [at] tatewake [dot] com
 * License: GPL v2
 */
function mt_beginsWith( $str, $sub ) {
	return ( substr( $str, 0, strlen( $sub ) ) === $sub );
}

@include(dirname(__FILE__).'/local_pref.php');

if (isset($ID) == TRUE)
{
	foreach($multitemplate as $mt_namespace => $mt_othertemplate)
	{           
		if (mt_beginsWith($ID, $mt_namespace))
		{
			$DOKU_TPL		= DOKU_TPL.'../'.$mt_othertemplate.'/';
			$DOKU_TPLINC	= DOKU_TPLINC.'../'.$mt_othertemplate.'/';
			@include(dirname(__FILE__).'/'.'../'.$mt_othertemplate.'/'.$mt_file);
			break;
		}
	}
}
else
{
	$DOKU_TPL		= DOKU_TPL.'../'.$multitemplate[''].'/';
	$DOKU_TPLINC	= DOKU_TPLINC.'../'.$multitemplate[''].'/';
	@include(dirname(__FILE__).'/'.'../'.$multitemplate[''].'/'.$mt_file);
}

?>
