<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package   ThemeExternalJS 
 * @author    Hendrik Obermayer - Comolo 
 * @license   LGPL 
 * @copyright Hendrik Obermayer - Comolo 
 */

$GLOBALS['TL_HOOKS']['generatePage'][] = array('AddAssets', 'addJavascriptToPage');
$GLOBALS['TL_HOOKS']['generatePage'][] = array('AddAssets', 'addSCSSToPage');