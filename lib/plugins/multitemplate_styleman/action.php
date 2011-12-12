<?php
/**
 * Multitemplate Styleman Action Plugin:   Hooks into stylsheet generation to allow
 * templates managed by the mutlitemplate template (http://tatewake.com/wiki/projects:multitemplate_for_dokuwiki)
 * the usage of style.ini
 * 
 * @author     Pascal Bihler <bihler@iai.uni-bonn.de>
 */
 
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_multitemplate_styleman extends DokuWiki_Action_Plugin {
 
  /**
   * return some info
   */
  function getInfo(){
    return array(
		 'author' => 'Pascal Bihler',
		 'email'  => 'bihler@iai.uni-bonn.de',
		 'date'   => '2009-02-02',
		 'name'   => 'Multitemplate Stylemananager',
		 'desc'   => 'Allows templates managed by Multitemplate to use style.ini',
		 'url'    => 'http://wiki.splitbrain.org/plugin:multitemplate_styleman',
		 );
  }
 
  /*
   * Register its handlers with the dokuwiki's event controller
   */
  function register(&$controller) {
       if ($this->isMultitemplateTemplateActive())
    	 $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE',  $this, '_replacecss');
  }
 
  /**
   * Relocates the css-loading to own method
   */
  function _replacecss(&$event, $param) {
	  global $ID,$conf;
        global $DOKU_TPL;
		
        $template = NULL;
		
        // get current template from mutitemplate template:
        // a modification to the current (2007-01-02) version of multitemplate/meat.php is required:
        // Add the following line to the beginning of the file: "global $DOKU_TPL,$DOKU_TPLINC;"
        if (preg_match('/\/([^\/]+)\/$/',$DOKU_TPL,$matches))
          $template = $matches[1];
		
        if (isset($template)) {
            
           // Replace stylsheet requests
           for ($i = 0; $i < count($event->data['link']); $i++) {
               if (isset($event->data['link'][$i]['media'])) {
                   $media = $event->data['link'][$i]['media'];
                   
                   // redirect to our css.php-wrapper
                   $href = $event->data['link'][$i]['href'];
                   $pos = strpos($href,'css.php');
                   if ($pos !== false) {
                       $params = substr($href,$pos+7);
                       $params = str_replace( 't=multitemplate', '', $params );
                       if (! $params) 
                       	  $href = DOKU_BASE.'lib/plugins/multitemplate_styleman/css.php?tpl=' . $template;
                       else 
                       	  $href = DOKU_BASE.'lib/plugins/multitemplate_styleman/css.php' . $params . '&tpl=' . $template;
                       $event->data['link'][$i]['href'] = $href;
                   }
               }
           }  
        }
  }
	
	
   function isMultitemplateTemplateActive() {
	     global $conf;
       return ($conf['template'] == 'multitemplate');
   }
}