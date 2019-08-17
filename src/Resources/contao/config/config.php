<?php
/*
 * This file is part of the SuperTheme extension by Comolo.
 *
 * Copyright (C) 2018-2019 Comolo GmbH
 *
 * @author    Hendrik Obermayer <https://github.com/henobi>
 * @copyright 2018 Comolo GmbH <https://www.comolo.de/>
 * @license   LGPL
 */

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['generatePage'][] = [\Comolo\SuperThemeBundle\AssetGenerator\CssGenerator::class, 'generate'];
$GLOBALS['TL_HOOKS']['generatePage'][] = [\Comolo\SuperThemeBundle\AssetGenerator\JavascriptGenerator::class, 'generate'];

/**
 * Content Elements
 */
$GLOBALS['TL_CTE']['supertheme'] = [
    'grid_start'   => \Comolo\SuperThemeBundle\Element\GridStartElement::class,
    'grid_stop'    => \Comolo\SuperThemeBundle\Element\GridStopElement::class,
];

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_supertheme_grid'] = \Comolo\SuperThemeBundle\Model\GridModel::class;

/**
 * Backend Modules
 */
$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_supertheme_grid';

/**
 * Wrapper
 */
$GLOBALS['TL_WRAPPERS']['start'][] = 'grid_start';
$GLOBALS['TL_WRAPPERS']['stop'][]  = 'grid_stop';
