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
 * Class AssetGenerator 
 *
 * @copyright  Hendrik Obermayer - Comolo GmbH 
 * @author     Hendrik Obermayer - Comolo GmbH 
 * @package    SuperTheme
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
			// contao 3.2 compability
			if(method_exists($this->FilesModel,'findMultipleByUuids')){
				$arrFiles = $this->FilesModel->findMultipleByUuids($arrFileIds);
			}
			else {
				$arrFiles = $this->FilesModel->findMultipleByIds($arrFileIds);
			}
			
			if(is_object($arrFiles) && $arrFiles->count()>0)
			{
 				$arrFilePaths = $arrFiles->fetchEach('path');
 				$combiner = new \Combiner();
				
 				foreach(array_unique($arrFilePaths) as $fileId => $filePath)
 				{
					// compile & combine
					$fileData = $this->assetCompiler($filePath);
 					$combiner->add($fileData[0], $fileData[1]); # filePath, version
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
	
	
	// sorting
	protected function sortArrayValues($arrVales, $strOrder)
	{
		/*
		 * Notice: Sorting-Code extracted from Contao Core: page/PageRegular.php
		 *
		 */
		
		if ($strOrder != '')
		{
			// Turn the order string into an array and remove all values
			$arrOrder = explode(',', $strOrder);
			$arrOrder = array_flip(array_map('intval', $arrOrder));
			$arrOrder = array_map(function(){}, $arrOrder);

			// Move the matching elements to their position in $arrOrder
			foreach ($arrVales as $k=>$v)
			{
				$arrOrder[$v] = $v;
				unset($arrVales[$k]);
			}
			
			// Append the left-over style sheets at the end
			if (!empty($arrVales))
			{
				$arrOrder = array_merge($arrOrder, array_values($arrVales));
			}
			
			// Remove empty (unreplaced) entries
			$arrVales = array_filter($arrOrder);
		}
		
		return $arrVales;
	}
}
