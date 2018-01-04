<?php
/*
 * This file is part of the SuperTheme extension by Comolo.
 *
 * Copyright (C) 2018 Comolo GmbH
 *
 * @author    Hendrik Obermayer <https://github.com/henobi>
 * @copyright 2018 Comolo GmbH <https://www.comolo.de/>
 * @license   LGPL
 */
namespace Comolo\SuperThemeBundle\AssetGenerator;

use \Contao\System;

/**
 * Class AssetGenerator
 * @package Comolo\SuperThemeBundle\AssetGenerator
 */
abstract class AssetGenerator extends \Controller
{
    protected $pageModel;
    protected $layoutModel;
    protected $pageRegular;

    protected abstract function filesCollector();

    protected abstract function addAssetToPage(string $filePath);

    protected abstract function assetCompiler($strSourcePath);

    public function generate(\PageModel $page, \LayoutModel $layout, \PageRegular $pageRegular)
    {
        $this->pageModel = $page;
        $this->layoutModel = $layout;
        $this->pageRegular = $pageRegular;
        $arrFileIds = $this->filesCollector();

        if (count($arrFileIds) > 0) {
            $arrFiles = \FilesModel::findMultipleByUuids($arrFileIds);

            if (is_object($arrFiles) && $arrFiles->count() > 0) {
                $arrFilePaths = $arrFiles->fetchEach('path');
                $combiner = new \Combiner();

                foreach (array_unique($arrFilePaths) as $fileId => $filePath) {
                    // compile & combine
                    // todo: catch exceptions
                    $fileData = $this->assetCompiler($filePath);
                    $combiner->add($fileData[0], $fileData[1]); // filePath, version
                }

                $this->addAssetToPage($combiner->getCombinedFile());
            }
        }
    }

    protected function writeAndCompressAsset($filePath, $strContent)
    {
		// Map file extensions to compressors
        $fileCompressor = [
            'css' => \MatthiasMullie\Minify\CSS::class,
            'js' => \MatthiasMullie\Minify\JS::class,
        ];

		// Get file extension
		$fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        // Caching disabled or unknown file extension
        if (!isset($fileCompressor[$fileExtension]) || !$this->isMinifyEnabled()) {
			return file_put_contents($filePath, $strContent);
        }

        /** @var \MatthiasMullie\Minify\CSS|\MatthiasMullie\Minify\JS $compressor */
		$compressor = new $fileCompressor[$fileExtension];
		$compressor->add($strContent);

		return $compressor->minify($filePath);
    }

    protected function sortArrayValues($arrValues, $arrTmpOrder)
    {
        if (!empty($arrTmpOrder) && is_array($arrTmpOrder)) {

            $arrOrder = array_map(function(){}, array_flip($arrTmpOrder));

            // Move the matching elements to their position in $arrOrder
            foreach ($arrValues as $k => $v) {
                $arrOrder[$v] = $v;
                unset($arrValues[$k]);
            }

            // Append the left-over style sheets at the end
            if (!empty($arrVales)) {
                $arrOrder = array_merge($arrOrder, array_values($arrVales));
            }

            // Remove empty entries
            $arrValues = array_filter($arrOrder);
        }

        return array_values($arrValues);
    }

    /**
     * check if contao is running in prod mode.
     */
    protected function isProductiveModeEnabled()
    {
        $symfonyMode = !in_array(System::getContainer()->get('kernel')->getEnvironment(), array('test', 'dev'));
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
