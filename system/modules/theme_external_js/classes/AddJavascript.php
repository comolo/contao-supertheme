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
class AddJavascript extends \Controller
{
	public function addJsToPage(\PageModel $page, \LayoutModel $layout, \PageRegular $pageRegular)
	{
		$arrJavascriptFiles = unserialize($layout->external_js);
		
		if(count($arrJavascriptFiles)>0){
			$this->import('FilesModel'); 
			$files = $this->FilesModel->findMultipleByIds($arrJavascriptFiles);
			
			if($files->count()){
				$arrPaths = $files->fetchEach('path');
				$this->import('Combiner');
				foreach($arrPaths as $fileId => $filePath)
				{
					$this->Combiner->add($filePath);
				}
				$GLOBALS['TL_JQUERY'][] = '<script src="'.$this->Combiner->getCombinedFile().'"></script>';
			}
		}
	}
}
