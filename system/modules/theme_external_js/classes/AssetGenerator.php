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
 * Class AssetGenerator 
 *
 * @copyright  Hendrik Obermayer - Comolo 
 * @author     Hendrik Obermayer - Comolo 
 * @package    Devtools
 */
abstract class AssetGenerator extends \Controller
{
	protected $pageModel;
	protected $layoutModel;
	protected $pageRegular;
	protected $yui_path = false;
	protected $yuiCompressor = false;
	
	public function __construct()
	{
		$this->import('FilesModel');
	}
	
	public function generate(\PageModel $page, \LayoutModel $layout, \PageRegular $pageRegular)
	{
		$this->pageModel = $page;
		$this->layoutModel = $layout;
		$this->pageRegular = $pageRegular;

		// 
		$arrFileIds = $this->filesCollector();
			
		if(count($arrFileIds)>0)
		{
			// fetch file path
			$arrFiles = $this->FilesModel->findMultipleByIds($arrFileIds);
			
			if(is_object($arrFiles) && $arrFiles->count()>0)
			{
 				$arrFilePaths = $arrFiles->fetchEach('path');
 				$combiner = new \Combiner();
				
 				foreach(array_unique($arrFilePaths) as $fileId => $filePath)
 				{
					// compile & combine
					$filePath = $this->assetCompiler($filePath);
 					$combiner->add($filePath);
				}
				
				// add to page
 				$this->addAssetToPage($combiner->getCombinedFile());
 			}
		}
	}
	
	protected function compressAsset($filePath)
	{
		// check if enabled
		if($this->yuiCompressor == false) return;
		
		// Get Yiu Path
		$yuiPath = $this->yui_path ? $this->yui_path : trim(`which yui-compressor`);
		if(empty($yuiPath) || !$yuiPath) return false;
		
		$options = array(
			escapeshellarg($filePath),
			'-o '.escapeshellarg($filePath),
			'--charset "utf-8"',
			'-v'
		);
		
		$cmd = $yuiPath.' '.implode(' ', $options);
		echo `$cmd`;
		
		return true;
	}
	
	// helper function
	protected function combineArrayValues($arr1, $arr2)
	{
		$array = array();
		foreach($arr1 as $key => $value) $array[] = $value;
		foreach($arr2 as $key => $value) $array[] = $value;
		
		return $array;
	}
}
