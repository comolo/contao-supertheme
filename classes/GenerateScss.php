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

use \SuperTheme\scssc;

/**
 * Class GenerateScss 
 *
 * @copyright  Hendrik Obermayer - Comolo GmbH 
 * @author     Hendrik Obermayer - Comolo GmbH 
 * @package    SuperTheme
 */
class GenerateScss extends AssetGenerator
{
	protected function filesCollector()
	{
		return $this->sortArrayValues(
			(array)unserialize($this->layoutModel->external_scss), # files
			$this->layoutModel->external_scss_order # order
		);
	}
	
	protected function assetCompiler($strSourcePath)
	{
		$strCssFilePath = 'assets/css/'.md5($strSourcePath.md5_file($strSourcePath)).'.css';
		$strCacheVersion = $this->checkCached($strSourcePath, $strCssFilePath);
		
		if(
			$strCacheVersion == false
			|| file_exists(TL_ROOT.'/'.$strCssFilePath) == false
		) {
			
			# Add Sass
			$scss = new scssc();
			$scss->setImportPaths(dirname($strSourcePath).'/');
			$scss->setFormatter('scss_formatter_compressed');
			
			# Add custom function
			$scss = $this->customScssFunctions($scss);
			
			# Add Compass
			new \scss_compass($scss);
			
			$strCssContent = $scss->compile(file_get_contents(TL_ROOT.'/'.$strSourcePath));
			
			# write css file
			file_put_contents(TL_ROOT.'/'.$strCssFilePath, $strCssContent);
			$this->compressAsset(TL_ROOT.'/'.$strCssFilePath);
			
			# cache
			$strCacheVersion = $this->generateCache($strSourcePath, $strCssFilePath, $scss->getImportedStylesheets());
		}
		
		return array($strCssFilePath, $strCacheVersion?$strCacheVersion:null);
	}
	
	protected function addAssetToPage($filePath)
	{
		$GLOBALS['TL_HEAD'][] = '<link rel="stylesheet" href="'.$filePath.'">';
	}
	
	protected function customScssFunctions($scss) {
		# $scss->registerFunction("contao", function($args) use($scss) {
			# do something 
		# });
		
		return $scss;
	}
	/**
	 * cache methods:
	 */ 
	public function checkCached($strSourcePath, $strNewPath)
	{
		$cacheFile = $strNewPath.'.cache';
		
		if(file_exists(TL_ROOT.'/'.$cacheFile)) 
		{
			$strHash = '';
			list($arrImportedFiles, $strCachedHash) = explode('*', file_get_contents(TL_ROOT.'/'.$cacheFile));
			
			if(trim($arrImportedFiles) != '')
			{
				$arrImportedFiles = explode('|', $arrImportedFiles);
				foreach($arrImportedFiles as $k => $strImportedFilePath)
				{
					$strHash .= md5_file(TL_ROOT.'/'.$strImportedFilePath);
				}
			}

			$strHash = md5($strHash);
			
			if($strHash == $strCachedHash){
				//files are the same
				return $strHash;
			}
			// files changed
			return false;
		}
		// no cache file found
		return false;
	}
	
	public function generateCache($strSourcePath, $strNewPath, $arrImportedStylesheets)
	{
		$cacheFile = $strNewPath.'.cache';
		$strHash = '';
		
		foreach($arrImportedStylesheets as $k => $strStylesheetPath)
		{
			// remove e.g. compass stylesheets
			if(strpos($strStylesheetPath, 'system/modules/') !== false){
				unset($arrImportedStylesheets[$k]);
				continue;
			}
			
			$strHash .= md5_file(TL_ROOT.'/'.$strStylesheetPath);
		}
		
		$strHash = md5($strHash);
		$strContents = implode('|', $arrImportedStylesheets).'*'.$strHash;
		file_put_contents(TL_ROOT.'/'.$cacheFile, $strContents);
		
		return $strHash;
	}
}

/**
 * Class scssc 
 *
 * @copyright  Hendrik Obermayer - Comolo GmbH
 * @author     Hendrik Obermayer - Comolo GmbH 
 * @package    SuperTheme
 */
class scssc extends \scssc
{
	protected $importedStylesheets = array();
	
	// overwrite method to get the impoted files
	protected function importFile($path, $out) 
	{
		$this->importedStylesheets[] = $path;
		
		// call "original" method
		return parent::importFile($path, $out);
	}
	
	public function getImportedStylesheets()
	{
		return $this->importedStylesheets;
	}
}