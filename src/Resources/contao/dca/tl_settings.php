<?php

/**
 * Contao Open Source CMS.
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   LGPL
 * @copyright Hendrik Obermayer - Comolo GmbH
 */

// Add config fields
$GLOBALS['TL_DCA']['tl_settings']['fields']['superthemeMinify'] = [
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['superthemeMinify'],
	'inputType'               => 'checkbox',
	'eval'                    => ['tl_class'=>'w50']
];
$GLOBALS['TL_DCA']['tl_settings']['fields']['superthemeProductiveMode'] = [
	'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['superthemeProductiveMode'],
	'inputType'               => 'checkbox',
	'eval'                    => ['tl_class'=>'w50']
];

// Add supertheme palettes
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace(
	'{global_legend',
	'{supertheme_legend},superthemeMinify,superthemeProductiveMode;{global_legend',
	$GLOBALS['TL_DCA']['tl_settings']['palettes']
);
