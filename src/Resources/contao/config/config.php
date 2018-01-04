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
$GLOBALS['TL_HOOKS']['generatePage'][] = [\Comolo\SuperThemeBundle\AssetGenerator\CssGenerator::class, 'generate'];
$GLOBALS['TL_HOOKS']['generatePage'][] = [\Comolo\SuperThemeBundle\AssetGenerator\JavascriptGenerator::class, 'generate'];
