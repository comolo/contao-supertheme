<?php

$GLOBALS['TL_DCA']['tl_content']['fields']['gridClass'] = [
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['gridClass'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'select',
    'options_callback'        => [\Comolo\SuperThemeBundle\DataContainer\Grid::class, 'getGridClasses'],
    'eval'                    => ['helpwizard'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
    'sql'                     => "varchar(255) NOT NULL default ''"

];

$GLOBALS['TL_DCA']['tl_content']['palettes']['grid_start'] = '{type_legend},type,gridClass;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['grid_stop']  = '{type_legend},type;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
