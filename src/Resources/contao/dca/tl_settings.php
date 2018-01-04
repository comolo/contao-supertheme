<?php
/*
 * This file is part of the SuperTheme extension by Comolo.
 *
 * Copyright (C) 2018 Comolo GmbH
 *
 * @author    Hendrik Obermayer <https://github.com/henobi>
 * @copyright 2018 Comolo GmbH <https://www.comolo.de/>
 * @license   LGPL
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
	$GLOBALS['TL_DCA']['tl_settings']['palettes']['default']
);
