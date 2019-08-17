<?php
namespace Comolo\SuperThemeBundle\DataContainer;

use Comolo\SuperThemeBundle\Model\GridModel;

/**
 * Class Grid
 * @package Comolo\SuperThemeBundle\DataContainer
 */
class Grid
{
    /**
     * Get all grid classes
     * @return array
     */
    public function getGridClasses()
    {
        $grids = GridModel::findAll();
        $arrGrids = [];

        foreach ($grids as $grid)
        {
            $arrGrids[$grid->gridClass] = $grid->title;
        }

        return $arrGrids;
    }
}
