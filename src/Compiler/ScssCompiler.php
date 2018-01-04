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
namespace Comolo\SuperThemeBundle\Compiler;

use Comolo\ScssCompass\CompassPlugin;
use Leafo\ScssPhp\Compiler;

/**
 * Class ScssCompiler
 * @package Comolo\SuperThemeBundle\Helper
 */
class ScssCompiler extends Compiler
{
    protected $importedStylesheets = array();

    // overwrite method to get the imported files
    protected function importFile($path, $out)
    {
        $this->importedStylesheets[] = $this->removeTlPath($path);

        parent::importFile($path, $out);
    }

    public function getImportedStylesheets()
    {
        return $this->importedStylesheets;
    }
    
    public function addPlugins()
    {
        new CompassPlugin($this);
        $this->addImportPath(__DIR__ . '/../Resources/scss/');
    }

    protected function removeTlPath($path)
    {
        if (substr($path, 0, strlen(TL_ROOT)) == TL_ROOT) {
            $path = substr($path, strlen(TL_ROOT));
        }

        return $path;
    }
}
