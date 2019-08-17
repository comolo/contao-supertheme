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

namespace Comolo\SuperThemeBundle\Element;

use Comolo\SuperThemeBundle\Base\FrontendModuleTrait;
use Contao\ContentElement;

/**
 * Class GridStartElement
 * @package Comolo\SuperThemeBundle\Element
 */
class GridStartElement extends ContentElement
{
    use FrontendModuleTrait;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_grid_start';

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
        $this->Template->title = $this->gridClass;
    }
}
