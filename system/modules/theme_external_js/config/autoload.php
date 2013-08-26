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
	// Vendor
	'scss'                       => 'system/modules/theme_external_js/vendor/leafo/scssphp/scss.inc.php',
	'scss_compass'               => 'system/modules/theme_external_js/vendor/leafo/scssphp-compass/compass.inc.php',

	// Classes
	'ThemeExternalJS\AddJavascript' => 'system/modules/theme_external_js/classes/AddJavascript.php',
));
