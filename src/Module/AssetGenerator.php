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
        $arrFileIds = $this->filesCollector();

        if (count($arrFileIds) > 0) {
            $arrFiles = $this->FilesModel->findMultipleByUuids($arrFileIds);


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
            'css' => '\MatthiasMullie\Minify\CSS',
            'js' => '\MatthiasMullie\Minify\JS',
        ];

		// Get file extension
		$fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Caching disabled or unknown file extension
        if (!isset($fileCompressor[$fileExtension]) || !$this->isMinifyEnabled()) {
			return file_put_contents($filePath, $strContent);
        }

		$compressor = new $fileCompressor[$fileExtension];
		$compressor->add($strContent);

		return $compressor->minify($filePath);
    }

    /**
	 * Helper function, combine two arrays
	 */
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
    protected function isProductiveMode()
    {
        $symfonyMode = !in_array(\System::getContainer()->get('kernel')->getEnvironment(), array('test', 'dev'));
		$superThemeMode = isset($GLOBALS['TL_CONFIG']['superthemeProductiveMode'])
			? $GLOBALS['TL_CONFIG']['superthemeProductiveMode']
			: false;

		return ($symfonyMode && $superThemeMode);
    }

	/**
	 * check if minify is enabled
	 */
	protected function isMinifyEnabled()
	{
		return isset($GLOBALS['TL_CONFIG']['superthemeMinify'])
			? $GLOBALS['TL_CONFIG']['superthemeMinify']
			: false;
	}
}
