<?php

/**
 * Table tl_supertheme_grid
 */
$GLOBALS['TL_DCA']['tl_supertheme_grid'] = array
(
    // Config
    'config' => array
    (
        'dataContainer'               => 'Table',
        'enableVersioning'            => true,
        'sql' => array
        (
            'keys' => array
            (
                'id' => 'primary',
            )
        ),
    ),
    // List
    'list' => array
    (
        'sorting' => array
        (
            'mode'                    => 1,
            'fields'                  => array('title'),
            'flag'                    => 1
        ),
        'label' => array
        (
            'fields'                  => array('title'),
            'format'                  => '%s'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_supertheme_grid']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.svg',
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_supertheme_grid']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_supertheme_grid']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_supertheme_grid']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),
    // Select
    'select' => array
    (
        'buttons_callback' => array()
    ),
    // Edit
    'edit' => array
    (
        'buttons_callback' => array()
    ),
    // Palettes
    'palettes' => array
    (
        '__selector__'                => array(''),
        'default'                     => 'title,gridClass;'
    ),
    // Subpalettes
    'subpalettes' => array
    (
        ''                            => ''
    ),
    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'pid' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_supertheme_grid']['title'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50', 'unique'=>true,),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'gridClass' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_supertheme_grid']['gridClass'],
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50', 'unique'=>true,),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
    )
);
