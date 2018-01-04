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

/**
 * Table tl_layout.
 */
$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] = str_replace(
    array(',script;', 'stylesheet,external;', 'stylesheet,external,'),
    array(',script,external_js;', 'stylesheet,external,external_scss;', 'stylesheet,external,external_scss,'),
    $GLOBALS['TL_DCA']['tl_layout']['palettes']['default']
);

/* Fields */
$GLOBALS['TL_DCA']['tl_layout']['fields']['external_js'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_layout']['external_js'],
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => array(
                                    'multiple' => true,
                                    'orderField' => 'external_js_order',
                                    'fieldType' => 'checkbox',
                                    'filesOnly' => true,
                                    'extensions' => 'js,coffee',
                                ),
    'sql' => 'blob NULL',
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['external_scss'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_layout']['external_scss'],
    'exclude' => true,
    'inputType' => 'fileTree',
    'eval' => array(
                                    'multiple' => true,
                                    'orderField' => 'external_scss_order',
                                    'fieldType' => 'checkbox',
                                    'filesOnly' => true,
                                    'extensions' => 'scss,css',
                                ),
    'sql' => 'blob NULL',
);

/* Order */
$GLOBALS['TL_DCA']['tl_layout']['fields']['external_js_order'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_layout']['orderExt'],
    'sql' => 'blob NULL',
);

$GLOBALS['TL_DCA']['tl_layout']['fields']['external_scss_order'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_layout']['orderExt'],
    'sql' => 'blob NULL',
);
