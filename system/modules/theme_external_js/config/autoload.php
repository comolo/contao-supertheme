<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package Theme_external_js
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'ThemeExternalJS',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'ThemeExternalJS\AssetGenerator' => 'system/modules/theme_external_js/classes/AssetGenerator.php',
	'ThemeExternalJS\GenerateScss' => 'system/modules/theme_external_js/classes/GenerateScss.php',
	'ThemeExternalJS\GenerateCoffeescript' => 'system/modules/theme_external_js/classes/GenerateCoffeescript.php',
));
