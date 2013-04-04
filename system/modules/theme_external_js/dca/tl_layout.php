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
$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] = str_replace(',script;', ',script,external_js;', $GLOBALS['TL_DCA']['tl_layout']['palettes']['default']);

$GLOBALS['TL_DCA']['tl_layout']['fields']['external_js'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['external_js'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'filesOnly'=>true, 'extensions'=>'js'),
	'sql'                     => "blob NULL"
);