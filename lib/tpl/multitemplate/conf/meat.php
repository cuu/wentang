<?php
/** Multitemplate for DokuWiki
 * By Terence J. Grant
 * tjgrant [at] tatewake [dot] com
 * License: GPL v2
 */

@include(dirname(__FILE__).'/../local_pref.php');

if (isset($ID) == TRUE)
{
	foreach($multitemplate as $mt_namespace => $mt_othertemplate)
	{           
		if (mt_beginsWith($ID, $mt_namespace))
		{
			@include(dirname(__FILE__).'/'.'../../'.$mt_othertemplate.'/'.$mt_file);
			break;
		}
	}
}
else
{
	@include(dirname(__FILE__).'/'.'../../'.$multitemplate[''].'/'.$mt_file);
}

?>
