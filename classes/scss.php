<?php

/**
 * Class scssc
 *
 * @package   SuperTheme
 * @author    Hendrik Obermayer - Comolo GmbH <mail@comolo.de>
 * @copyright 2014 - Hendrik Obermayer - Comolo GmbH <mail@comolo.de>
 */
class scssc extends \scssc
{
    protected $importedStylesheets = array();

    // overwrite method to get the impoted files
    protected function importFile($path, $out)
    {
        $this->importedStylesheets[] = $path;

        // call "original" method
        return parent::importFile($path, $out);
    }

    public function getImportedStylesheets()
    {
        return $this->importedStylesheets;
    }
}
