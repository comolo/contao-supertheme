<?php

namespace Comolo\SuperThemeBundle\Base;

use Contao\BackendTemplate;
use Contao\Template;

/**
 * Trait FrontendModuleTrait
 * @package Comolo\SuperThemeBundle\Base
 *
 * @property Template $Template
 * @property $strTemplate
 * @property $headline
 */
trait FrontendModuleTrait
{
    public function compile()
    {
        if (TL_MODE == 'BE') {
            $this->strTemplate        = 'be_wildcard';
            $this->Template           = new BackendTemplate($this->strTemplate);
            $this->Template->title    = $this->headline;
            $this->Template->wildcard = sprintf('### %s ###', end(explode('\\', get_called_class())));

            $this->modifyBackendOutput();

            return null;
        }

        return $this->generateFrontendOutput();
    }

    protected abstract function modifyBackendOutput();

    protected abstract function generateFrontendOutput();
}
