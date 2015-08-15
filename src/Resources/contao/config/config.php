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
$GLOBALS['TL_HOOKS']['generatePage'][] = array('\Comolo\SuperThemeBundle\Module\ScssGenerator', 'generate');
$GLOBALS['TL_HOOKS']['generatePage'][] = array('\Comolo\SuperThemeBundle\Module\CoffeescriptGenerator', 'generate');

//
// @import 'supertheme/test' => system/modules/.../supertheme/test.scss
// 
//\GenerateScss::addScssNamespace(array
//(
//	'supertheme'	=> 'system/modules/supertheme/assets/',
//));

