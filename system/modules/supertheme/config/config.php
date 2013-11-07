<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package   SuperTheme 
 * @author    Hendrik Obermayer - Comolo GmbH
 * @license   LGPL 
 * @copyright Hendrik Obermayer - Comolo GmbH
 */

$GLOBALS['TL_HOOKS']['generatePage'][] = array('GenerateScss', 'generate');
$GLOBALS['TL_HOOKS']['generatePage'][] = array('GenerateCoffeescript', 'generate');