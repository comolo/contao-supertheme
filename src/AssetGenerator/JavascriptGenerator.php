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

use CoffeeScript\Compiler as CoffeeScriptCompiler;

/**
 * Class JavascriptGenerator
 * @package Comolo\SuperThemeBundle\AssetGenerator
 */
class JavascriptGenerator extends AssetGenerator
{
    protected function filesCollector()
    {
        $arrLayoutFiles = $this->sortArrayValues(
            unserialize($this->layoutModel->external_js),
            unserialize($this->layoutModel->external_js_order)
        );

        $arrPageFiles = $this->sortArrayValues(
            unserialize($this->pageModel->external_js),
            unserialize($this->pageModel->external_js_order)
        );

        return array_merge($arrLayoutFiles, $arrPageFiles);
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
                // Compile
                $strCoffee = file_get_contents($strSourcePath);
                $strJs = CoffeeScriptCompiler::compile($strCoffee, array('filename' => $strSourcePath));
            }

            $this->writeAndCompressAsset(TL_ROOT.'/'.$strJSFile, $strJs);
        }

        return array($strJSFile, null);
    }

    protected function addAssetToPage(string $filePath)
    {
        $GLOBALS['TL_BODY'][] = '<script src="'.$filePath.'"></script>';
    }
}
