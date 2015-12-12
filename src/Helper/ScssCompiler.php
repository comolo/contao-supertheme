<?php

/**
 * Class scssc.
 *
 * @author    Hendrik Obermayer - Comolo GmbH <mail@comolo.de>
 * @copyright 2014 - Hendrik Obermayer - Comolo GmbH <mail@comolo.de>
 */

/**
 * Namespace.
 */

namespace Comolo\SuperThemeBundle\Helper;

use Comolo\ScssCompass\CompassPlugin;
use Leafo\ScssPhp\Compiler;

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
