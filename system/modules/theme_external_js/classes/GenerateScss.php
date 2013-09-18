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
class GenerateScss extends AssetGenerator
{
	protected function filesCollector()
	{
		return (array)unserialize($this->layoutModel->external_scss);
	}
	
	protected function assetCompiler($strSourcePath)
	{
		$strCssFilePath = 'assets/css/scss-'.md5_file($strSourcePath).'.css';
		
		if(!file_exists(TL_ROOT.'/'.$strCssFilePath)) {
			
			// require classes
			require_once __DIR__.'/../vendor/leafo/scssphp/scss.inc.php';
			require_once __DIR__.'/../vendor/leafo/scssphp-compass/compass.inc.php';
			
			# Add Sass
			$scss = new \scssc();
			$scss->setImportPaths(dirname($strSourcePath).'/');
			$scss->setFormatter('scss_formatter_compressed');
			
			# Add custom function
			$scss = $this->customScssFunctions($scss);
			
			# Add Compass
			new \scss_compass($scss);
			
			$strCssContent = $scss->compile(file_get_contents(TL_ROOT.'/'.$strPathSCSS));
			$strCssContent = $this->modifyCss($strCssContent);
			
			# write css file
			file_put_contents(TL_ROOT.'/'.$strCssFilePath, $strCssContent);
		}
		
		return $strCssFilePath;
	}
	
	protected function addAssetToPage($filePath)
	{
		$GLOBALS['TL_HEAD'][] = '<link rel="stylesheet" href="'.$filePath.'">';
	}
	
	protected customScssFunctions($scss) {
		# $scss->registerFunction("contao", function($args) use($scss) {
			# do something 
		# });
		
		return $scss;
	}
	
	protected function modifyCss($strCssContent)
	{
		// Remove css comments
		return preg_replace( '/\s*(?!<\")\/\*[^\*]+\*\/(?!\")\s*/' , '' , $strCssContents);
	}
}