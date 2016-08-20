<?php

/**
 * Contao Open Source CMS.
 *
 * Copyright (C) 2005-2013 Leo Feyer
 *
 * @author    Hendrik Obermayer - Comolo GmbH <mail@comolo.de>
 * @copyright 2015 - Hendrik Obermayer - Comolo GmbH <mail@comolo.de>
 * @license   LGPL
 */

/**
 * Namespace.
 */

namespace Comolo\SuperThemeBundle\Module;

use MatthiasMullie\Minify;

/**
 * Class AssetGenerator.
 *
 * @author    Hendrik Obermayer - Comolo GmbH <mail@comolo.de>
 * @copyright 2014 - Hendrik Obermayer - Comolo GmbH <mail@comolo.de>
 */
abstract class AssetGenerator extends \Controller
{
    protected $pageModel;
    protected $layoutModel;
    protected $pageRegular;

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

        if (count($arrFileIds) > 0) {
            // fetch file path
            // contao 3.2 compability
            if (method_exists($this->FilesModel, 'findMultipleByUuids')) {
                $arrFiles = $this->FilesModel->findMultipleByUuids($arrFileIds);
            } else {
                $arrFiles = $this->FilesModel->findMultipleByIds($arrFileIds);
            }

            if (is_object($arrFiles) && $arrFiles->count() > 0) {
                $arrFilePaths = $arrFiles->fetchEach('path');
                $combiner = new \Combiner();

                foreach (array_unique($arrFilePaths) as $fileId => $filePath) {
                    // compile & combine
                    // todo: catch exceptions
                    $fileData = $this->assetCompiler($filePath);
                    $combiner->add($fileData[0], $fileData[1]); // filePath, version
                }

                // add to page
                $this->addAssetToPage($combiner->getCombinedFile());
            }
        }
    }

    protected function writeAndCompressAsset($filePath, $strContent)
    {
		// Map file extensions to compressors
		$fileCompressor = [
			'css' => 'Minify\CSS',
			'js' => 'Minify\JS',
		];

		// Get file extension
		$fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

		// todo: check if caching is enabled
		$caching = true;

        // Caching disabled or unknown file extension
        if (!isset($fileCompressor[$fileExtension]) || !$caching) {
			return file_put_contents($filePath, $strContent);
        }

		$compressor = new $fileCompressor[$fileExtension];
		$compressor->add($strContent);
		$compressor->minify($filePath);

        return true;
    }

    // helper function
    protected function combineArrayValues($arr1, $arr2)
    {
        $array = array();

        foreach ($arr1 as $key => $value) {
            $array[] = $value;
        }

        foreach ($arr2 as $key => $value) {
            $array[] = $value;
        }

        return $array;
    }

    // sorting
    protected function sortArrayValues($arrVales, $strOrder)
    {
        /*
         * Notice: Sorting-Code extracted from Contao Core: page/PageRegular.php
         *
         */

        if ($strOrder != '') {
            // Turn the order string into an array and remove all values
            $arrOrder = explode(',', $strOrder);
            $arrOrder = array_flip(array_map('intval', $arrOrder));
            $arrOrder = array_map(function () {}, $arrOrder);

            // Move the matching elements to their position in $arrOrder
            foreach ($arrVales as $k => $v) {
                $arrOrder[$v] = $v;
                unset($arrVales[$k]);
            }

            // Append the left-over style sheets at the end
            if (!empty($arrVales)) {
                $arrOrder = array_merge($arrOrder, array_values($arrVales));
            }

            // Remove empty (unreplaced) entries
            $arrVales = array_filter($arrOrder);
        }

        return $arrVales;
    }

    /**
     * check if contao is running in prod mode.
     */
    public function isProductiveMode()
    {
		// check symfony mode
        $symfonyMode = !in_array(\System::getContainer()->get('kernel')->getEnvironment(), array('test', 'dev'));

		// check supertheme settings
		$superThemeMode = isset($GLOBALS['TL_CONFIG']['superthemeProductiveMode']) ? $GLOBALS['TL_CONFIG']['superthemeProductiveMode'] : false;

		return ($symfonyMode && $superThemeMode);
    }
}
