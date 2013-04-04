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
	'ThemeExternalJS\AddJavascript' => 'system/modules/theme_external_js/classes/AddJavascript.php',
));
