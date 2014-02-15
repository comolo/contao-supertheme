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


/**
 * Namespace
 */
namespace SuperTheme;

/**
 * Class GenerateCoffeescript 
 *
 * @copyright  Hendrik Obermayer - Comolo Comolo GmbH
 * @author     Hendrik Obermayer - Comolo Comolo GmbH
 * @package    SuperTheme
 */
class GenerateCoffeescript extends AssetGenerator
{
	protected function filesCollector()
	{
		$arrLayoutFiles = $this->sortArrayValues(
			(array)unserialize($this->layoutModel->external_js), # files
			$this->layoutModel->external_js_order # order
		);
		
		$arrPageFiles = $this->sortArrayValues(
			(array)unserialize($this->pageModel->external_js), # files
			$this->pageModel->external_js_order # order
		);

		return $this->combineArrayValues($arrLayoutFiles, $arrPageFiles);
	}
	
	protected function assetCompiler($strSourcePath)
	{
		// Javascript File - No compilation required
		if(substr($strSourcePath, -7) != '.coffee'){
			return array($strSourcePath, md5_file($strSourcePath));
		}
		
		// Target File
		$strJSFile = 'assets/js/coffee-'.md5_file($strSourcePath).'.js';
		
		if(!file_exists(TL_ROOT.'/'.$strJSFile)) {
			
			// require classes
			\CoffeeScript\Init::load();
		
			// Compile
			$strCoffee = file_get_contents($strSourcePath);
			$strJs = \CoffeeScript\Compiler::compile($strCoffee, array('filename' => $strSourcePath));
			
			# write css file / replace with contao framework method later
			file_put_contents(TL_ROOT.'/'.$strJSFile, $strJs);
			$this->compressAsset(TL_ROOT.'/'.$strJSFile);
		}
		
		return array($strJSFile, null);
	}
	
	protected function addAssetToPage($filePath)
	{
		$GLOBALS['TL_BODY'][] = '<script src="'.$filePath.'"></script>';
	}
}