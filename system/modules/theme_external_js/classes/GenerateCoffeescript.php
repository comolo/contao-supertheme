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


/**
 * Namespace
 */
namespace ThemeExternalJS;

/**
 * Class AddJavascript 
 *
 * @copyright  Hendrik Obermayer - Comolo 
 * @author     Hendrik Obermayer - Comolo 
 * @package    Devtools
 */
class GenerateCoffeescript extends AssetGenerator
{
	protected function filesCollector()
	{
		return $this->combineArrayValues(
			(array)unserialize($this->layoutModel->external_js), 
			(array)unserialize($this->pageModel->external_js)
		);
	}
	
	protected function assetCompiler($strSourcePath)
	{
		// Javascript File - No compilation required
		if(substr($strSourcePath, -7) != '.coffee'){
			return $strSourcePath;
		}
		
		// Target File
		$strJSFile = 'assets/js/coffee-'.md5_file($strCoffeescriptPath).'.js';
		
		if(!file_exists(TL_ROOT.'/'.$strJSFile)) {
			
			// require classes
			require_once __DIR__.'/../vendor/coffeescript/coffeescript/src/CoffeeScript/Init.php';
			\CoffeeScript\Init::load();
		
			// Compile
			$strCoffee = file_get_contents($strSourcePath);
			$strJs = \CoffeeScript\Compiler::compile($strCoffee, array('filename' => $strSourcePath));
			
			# write css file / replace with contao framework method later
			file_put_contents(TL_ROOT.'/'.$strJSFile, $strJs);
			$this->compressAsset(TL_ROOT.'/'.$strJSFile);
		}
		
		return $strJSFile;
	}
	
	protected function addAssetToPage($filePath)
	{
		$GLOBALS['TL_JQUERY'][] = '<script src="'.$filePath.'"></script>';
	}
}