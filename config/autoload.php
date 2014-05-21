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
    'SuperTheme\AssetGenerator'             => 'system/modules/supertheme/classes/AssetGenerator.php',
    'SuperTheme\GenerateScss'               => 'system/modules/supertheme/classes/GenerateScss.php',
    'SuperTheme\GenerateCoffeescript'       => 'system/modules/supertheme/classes/GenerateCoffeescript.php',
));
