<?php
/**
 * DokuWiki StyleSheet creator wrapper
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Pascal Bihler <bihler@iai.uni-bonn.de>
 */

 //Load all the basic includes (like css.php tries to do later)
 
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('NOSESSION')) define('NOSESSION',true); // we do not use a session or authentication here (better caching)

$template = NULL;
if (isset($_REQUEST['tpl'])) {
    $tpl = $_REQUEST['tpl'];
		if (preg_match('/^[a-z0-9_-]+$/iD', $tpl)) { //seems to be a valid template name, and not a code injection...
		    $template = $tpl;
		}
}

// We set the template constants before init.php can do it...
if (isset($template)) {

    //Inherit DOKU_BASE from server variables in order to avoid config reading here...
		$script_name = $_SERVER['SCRIPT_NAME'];
    $DOKU_BASE = substr($script_name,0,strlen($script_name)-strlen('lib/plugins/multitemplate_styleman/css.php'));
    define('DOKU_TPL', $DOKU_BASE.'lib/tpl/'  . $template .'/');
    define('DOKU_TPLINC',realpath(dirname(__FILE__).'/../../') . '/tpl/' . $template .'/');
}

//Load environment parameters
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/pageutils.php');
require_once(DOKU_INC.'inc/io.php');
require_once(DOKU_INC.'inc/confutils.php');

// Redirect template: 
if (isset($template))
   $conf['template'] = $template;
	 
//Now we let the original css.php do the rest
require_once(realpath(dirname(__FILE__).'/../../').'/exe/css.php');

?>