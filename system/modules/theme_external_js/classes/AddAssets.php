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
class AddAssets extends \Controller
{
	public function addJavascriptToPage(\PageModel $page, \LayoutModel $layout, \PageRegular $pageRegular)
	{
		$arrJavascriptFiles = $this->combineArrayValues(
			(array)unserialize($layout->external_js), 
			(array)unserialize($page->external_js)
		);
		
		if(count($arrJavascriptFiles)>0){
			$this->import('FilesModel'); 
			$files = $this->FilesModel->findMultipleByIds($arrJavascriptFiles);
			
			if(is_object($files) && $files->count()){
 				$arrPaths = $files->fetchEach('path');
 				$combiner = new \Combiner();
 				foreach(array_unique($arrPaths) as $fileId => $filePath)
 				{
 					$combiner->add($filePath);
				}
 				$GLOBALS['TL_JQUERY'][] = '<script src="'.$combiner->getCombinedFile().'"></script>';
 			}
		}
	}
	
	protected function combineArrayValues($arr1, $arr2)
	{
		$array = array();
		foreach($arr1 as $key => $value) $array[] = $value;
		foreach($arr2 as $key => $value) $array[] = $value;
		
		return $array;
	}
	
	
	public function addSCSSToPage(\PageModel $page, \LayoutModel $layout, \PageRegular $pageRegular)
	{
		$arrSCSSFiles = (array)unserialize($layout->external_scss);
		
		if(count($arrSCSSFiles)>0){
			$this->import('FilesModel'); 
			$files = $this->FilesModel->findMultipleByIds($arrSCSSFiles);
			
			if(is_object($files) && $files->count()){
 				$arrPaths = $files->fetchEach('path');
 				$combiner = new \Combiner();
 				foreach(array_unique($arrPaths) as $fileId => $filePath)
 				{
					$combiner->add(
						$this->compileSCSS($filePath)
							)
								;
				}
 				$GLOBALS['TL_CSS'][] = $combiner->getCombinedFile();
 			}
		}
	}
	
	protected function compileSCSS($strPathSCSS)
	{
		$strCSSFile = 'assets/css/scss-'.md5_file($strPathSCSS).'.css';
		#$objCssFile = new \File($strCSSFile);
		
		#if($objCssFile->exists()){
		if(!file_exists(TL_ROOT.'/'.$strCSSFile)) {
			
			// require classes
			require_once __DIR__.'/../vendor/leafo/scssphp/scss.inc.php';
			require_once __DIR__.'/../vendor/leafo/scssphp-compass/compass.inc.php';
			
			$scss = new \scssc();
			new \scss_compass($scss);
			#$objCssFile->write($strCSSFile, $scss->compile(file_get_contents(TL_ROOT.'/'.$strPathSCSS)));
			file_put_contents(TL_ROOT.'/'.$strCSSFile, $scss->compile(file_get_contents(TL_ROOT.'/'.$strPathSCSS)));
		}
		
		return $strCSSFile;
	}
}
