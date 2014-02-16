<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package   SuperTheme 
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   LGPL 
 * @copyright Hendrik Obermayer - Comolo GmbH
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
	'eval'                    => array('multiple'=>true, 'orderField'=>'external_js_order', 'fieldType'=>'checkbox', 'filesOnly'=>true, 'extensions'=>'js,coffee', 'tl_class' => ''),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['external_js_order'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['orderExt'],
	'sql'                     => "text NULL"
);