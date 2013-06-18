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
$GLOBALS['TL_DCA']['tl_page']['palettes']['regular'] = str_replace('{expert_legend:hide},', '{expert_legend:hide},external_js,', $GLOBALS['TL_DCA']['tl_page']['palettes']['regular']);

$GLOBALS['TL_DCA']['tl_page']['fields']['external_js'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_page']['external_js'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('multiple'=>true, 'fieldType'=>'checkbox', 'filesOnly'=>true, 'extensions'=>'js', 'tl_class' => ''),
	'sql'                     => "blob NULL"
);