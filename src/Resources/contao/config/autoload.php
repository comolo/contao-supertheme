<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @package SuperTheme
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'SuperTheme',
));

/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Classes
    'SuperTheme\AssetGenerator'             => 'vendor/comolo/contao-supertheme/src/Resources/contao/classes/AssetGenerator.php',
    'SuperTheme\GenerateScss'               => 'vendor/comolo/contao-supertheme/src/Resources/contao/classes/GenerateScss.php',
    'SuperTheme\GenerateCoffeescript'       => 'vendor/comolo/contao-supertheme/src/Resources/contao/classes/GenerateCoffeescript.php',
    'SuperTheme\scssc'       				=> 'vendor/comolo/contao-supertheme/src/Resources/contao/classes/scssc.php',
));
