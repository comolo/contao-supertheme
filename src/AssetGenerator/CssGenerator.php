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

use Comolo\SuperThemeBundle\Compiler\ScssCompiler;

/**
 * Class CssGenerator
 * @package Comolo\SuperThemeBundle\AssetGenerator
 */
class CssGenerator extends AssetGenerator
{
    protected static $scssNamespaces = array();

    protected function filesCollector()
    {
        return $this->sortArrayValues(
            unserialize($this->layoutModel->external_scss),
            unserialize($this->layoutModel->external_scss_order)
        );
    }

    protected function assetCompiler($strSourcePath)
    {
        $strCssFilePath = '/assets/css/'.md5($strSourcePath.md5_file(TL_ROOT.'/'.$strSourcePath)).'.css';
        $fileExists = file_exists(TL_ROOT.'/'.$strCssFilePath);

        if (!$fileExists || !$this->isProductiveModeEnabled()) {
            $strCacheVersion = $this->checkCached($strSourcePath, $strCssFilePath);

            if (!$strCacheVersion) {

                $scss = new ScssCompiler();
                $scss->setFormatter('Leafo\ScssPhp\Formatter\Crunched');

                // Import Paths
                self::addScssNamespace(array(
                    ''	=> dirname($strSourcePath) . '/'
                ));
                $scssImportNamespaces = self::$scssNamespaces;

                $scss->addImportPath(function ($filePath) use ($scssImportNamespaces) {
                    foreach ($scssImportNamespaces as $namespace => $scssFolder) {
                        if (
                            substr($filePath, 0, strlen($namespace)) != $namespace
                            && !empty($namespace)
                        ) {
                            continue;
                        }

                        $possiblePath = TL_ROOT.'/'.$scssFolder.$filePath;
                        $ext = pathinfo($possiblePath, PATHINFO_EXTENSION);

                        if ($ext != 'scss' || $ext == '') {
                            $possiblePath .= '.scss';
                        }

                        if (file_exists($possiblePath)) {
                            return $possiblePath;
                        }

                        continue;
                    }
                });

                // Add custom function
                $scss = $this->customScssFunctions($scss);

                // Add Compass
                $scss->addPlugins();

                $strCssContent = $scss->compile(file_get_contents(TL_ROOT.'/'.$strSourcePath));

                // write css file
                $this->writeAndCompressAsset(TL_ROOT.'/'.$strCssFilePath, $strCssContent);

                // cache
                $strCacheVersion = $this->generateCache($strSourcePath, $strCssFilePath, $scss->getImportedStylesheets());
            }
        }

        return array($strCssFilePath, $strCacheVersion ? $strCacheVersion : null);
    }

    protected function addAssetToPage(string $filePath)
    {
        $GLOBALS['TL_HEAD'][] = '<link rel="stylesheet" href="'.$filePath.'">';
    }

    protected function customScssFunctions($scss)
    {
        // $scss->registerFunction("contao", function ($args) use ($scss) {
            //   do something
            // });
        return $scss;
    }

    // Cache methods
    //
    public function checkCached($strSourcePath, $strNewPath)
    {
        $cacheFile = $strNewPath.'.cache';

        if (file_exists(TL_ROOT.'/'.$cacheFile)) {
            $strHash = '';
            list($arrImportedFiles, $strCachedHash) = explode('*', file_get_contents(TL_ROOT.'/'.$cacheFile));

            if (trim($arrImportedFiles) != '') {
                $arrImportedFiles = explode('|', $arrImportedFiles);
                foreach ($arrImportedFiles as $k => $strImportedFilePath) {
                    $strHash .= md5_file(TL_ROOT.'/'.$strImportedFilePath);
                }
            }

            $strHash = md5($strHash);

            if ($strHash == $strCachedHash) {
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

        foreach ($arrImportedStylesheets as $k => $strStylesheetPath) {
            // remove e.g. compass stylesheets
                if (
                    strpos($strStylesheetPath, 'system/modules/') !== false
                    || strpos($strStylesheetPath, 'leafo/scssphp-compass/') !== false
                    || strpos($strStylesheetPath, 'composer/vendor/') !== false
                    || strpos($strStylesheetPath, 'vendor/') !== false
                ) {
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

    public static function addScssNamespace($arrMapping)
    {
        foreach ($arrMapping as $namespace => $scssFolder) {
            self::$scssNamespaces[$namespace] = $scssFolder;
        }
    }
}
