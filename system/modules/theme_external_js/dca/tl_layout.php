<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package   ThemeExternalJS 
 * @author    Hendrik Obermayer - Comolo 
 * @license   LGPL 
 * @copyright Hendrik Obermayer - Comolo 
 */


/**
 * Table tl_layout 
 */

# Add external_js + external_scss
$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] = str_replace(
	array(',script;', 'stylesheet,external;'), 
	array(',script,external_js;', 'stylesheet,external,external_scss;'), 
	$GLOBALS['TL_DCA']['tl_layout']['palettes']['default']
);


# fields
$GLOBALS['TL_DCA']['tl_layout']['fields']['external_js'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['external_js'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'filesOnly'=>true, 'extensions'=>'js'),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['external_scss'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['external_scss'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'filesOnly'=>true, 'extensions'=>'scss'),
	'sql'                     => "blob NULL"
);