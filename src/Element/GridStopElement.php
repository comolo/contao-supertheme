<?php

namespace Comolo\SuperThemeBundle\Element;

use Comolo\SuperThemeBundle\Base\FrontendModuleTrait;
use Contao\ContentElement;

/**
 * Class GridStopElement
 * @package Comolo\SuperThemeBundle\Element
 */
class GridStopElement extends ContentElement
{
    use FrontendModuleTrait;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_grid_stop';

    /**
     * Generate the stop element
     */
    public function generateFrontendOutput()
    {
    }

    /**
     * Modify backend template
     */
    protected function modifyBackendOutput()
    {
        $this->Template->wildcard = false;
        $this->Template->title = false;
    }
}
