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
 				$this->import('Combiner');
 				foreach(array_unique($arrPaths) as $fileId => $filePath)
 				{
 					$this->Combiner->add($filePath);
				}
 				$GLOBALS['TL_JQUERY'][] = '<script src="'.$this->Combiner->getCombinedFile().'"></script>';
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
 				$this->import('Combiner');
 				foreach(array_unique($arrPaths) as $fileId => $filePath)
 				{
					$this->Combiner->add(
						$this->compileSCSS($filePath)
					);
				}
 				$GLOBALS['TL_CSS'][] = $this->Combiner->getCombinedFile();
 			}
		}
	}
	
	protected function compileSCSS($strPathSCSS)
	{
		$strCSSFile = TL_ROOT.'assets/css/scss-'.md5_file($strPathSCSS).'.css';
		
		if(!file_exists($strCSSFile)){
			$this->import('Files');
			$scss = new scssc();
			new scss_compass($scss);
			$this->Files->fputs($strCSSFile, $scss->compile(file_get_contents(TL_ROOT.$strPathSCSS)));
		}
		
		return $strCSSFile;
	}
}
