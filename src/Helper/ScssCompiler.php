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
namespace Comolo\SuperThemeBundle\Helper;

use Comolo\ScssCompass\CompassPlugin;
use Leafo\ScssPhp\Compiler;

/**
 * Class ScssCompiler
 * @author    Hendrik Obermayer <https://github.com/henobi>
 */
class ScssCompiler extends Compiler
{
    protected $importedStylesheets = array();

    // overwrite method to get the impoted files
    protected function importFile($path, $out)
    {
        $this->importedStylesheets[] = $this->removeTlPath($path);

        // call "original" method
        return parent::importFile($path, $out);
    }

    public function getImportedStylesheets()
    {
        return $this->importedStylesheets;
    }
    
    public function addPlugins() {
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
