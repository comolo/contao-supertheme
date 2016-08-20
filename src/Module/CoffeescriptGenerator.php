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

use CoffeeScript\Compiler as CoffeeScriptCompiler;
use CoffeeScript\Init as CoffeeScriptInit;

/**
 * Class GenerateCoffeescript.
 *
 * @author    Hendrik Obermayer - Comolo Comolo GmbH <mail@comolo.de>
 * @copyright 2014 - Hendrik Obermayer - Comolo Comolo GmbH <mail@comolo.de>
 */
class CoffeescriptGenerator extends AssetGenerator
{
    protected function filesCollector()
    {
        $arrLayoutFiles = $this->sortArrayValues(
            (array) unserialize($this->layoutModel->external_js),
            $this->layoutModel->external_js_order
        );

        $arrPageFiles = $this->sortArrayValues(
            (array) unserialize($this->pageModel->external_js),
            $this->pageModel->external_js_order
        );

        return $this->combineArrayValues($arrLayoutFiles, $arrPageFiles);
    }

    protected function assetCompiler($strSourcePath)
    {
        // Javascript File - No compilation required
        if (substr($strSourcePath, -7) != '.coffee') {
            return array($strSourcePath, md5_file(TL_ROOT.'/'.$strSourcePath));
        }

        // Target File
        $strJSFile = 'assets/js/coffee-'.md5_file($strSourcePath).'.js';

        if (!file_exists(TL_ROOT.'/'.$strJSFile)) {

            // require classes
            CoffeeScriptInit::load();

            // Compile
            $strCoffee = file_get_contents($strSourcePath);
            $strJs = CoffeeScriptCompiler::compile($strCoffee, array('filename' => $strSourcePath));

            // write css file / replace with contao framework method later
            file_put_contents(TL_ROOT.'/'.$strJSFile, $strJs);
            $this->compressAsset(TL_ROOT.'/'.$strJSFile);
        }

        return array($strJSFile, null);
    }

    protected function addAssetToPage($filePath)
    {
        $GLOBALS['TL_BODY'][] = '<script src="'.$filePath.'"></script>';
    }
}
