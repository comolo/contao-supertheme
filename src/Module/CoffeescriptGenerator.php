<?php
/*
 * This file is part of the SuperTheme extension by Comolo.
 *
 * Copyright (C) 2017 Comolo GmbH
 *
 * @author    Hendrik Obermayer <https://github.com/henobi>
 * @copyright 2017 Comolo GmbH <https://www.comolo.de/>
 * @license   LGPL
 */
namespace Comolo\SuperThemeBundle\Module;

use CoffeeScript\Compiler as CoffeeScriptCompiler;
use CoffeeScript\Init as CoffeeScriptInit;

/**
 * Class GenerateCoffeescript.
 *
 * @author    Hendrik Obermayer <https://github.com/henobi>
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
        // Target File
        $strJSFile = 'assets/js/js-'.md5_file(TL_ROOT.'/'.$strSourcePath).'.js';

        if (!file_exists(TL_ROOT.'/'.$strJSFile)) {

            $strJs = '';

            if (substr($strSourcePath, -7) != '.coffee') {
                $strJs = file_get_contents(TL_ROOT.'/'.$strSourcePath);
            }
            else {
                // require classes
                CoffeeScriptInit::load();

                // Compile
                $strCoffee = file_get_contents($strSourcePath);
                $strJs = CoffeeScriptCompiler::compile($strCoffee, array('filename' => $strSourcePath));
            }

            $this->writeAndCompressAsset(TL_ROOT.'/'.$strJSFile, $strJs);
        }

        return array($strJSFile, null);
    }

    protected function addAssetToPage($filePath)
    {
        $GLOBALS['TL_BODY'][] = '<script src="'.$filePath.'"></script>';
    }
}
