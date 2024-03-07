<?php

declare(strict_types=1);

use Contao\Controller;
use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\System;

call_user_func(static function (): void {
    System::loadLanguageFile('tl_form');
    Controller::loadDataContainer('tl_form');

    $manipulator = PaletteManipulator::create()
        ->addLegend('hofff_formtools_overwrite_legend', 'config_legend');

    foreach ($GLOBALS['TL_DCA']['tl_form']['fields'] as $name => $config) {
        if (empty($config['hofff_formtools_overwriteable'])) {
            continue;
        }

        $name = 'hofff_formtools_' . $name;

        $GLOBALS['TL_DCA']['tl_content']['fields'][$name]                      = $config;
        $GLOBALS['TL_DCA']['tl_content']['fields'][$name]['eval']['mandatory'] = false;

        $manipulator->addField($name, 'hofff_formtools_overwrite_legend', PaletteManipulator::POSITION_APPEND);
    }

    $manipulator->applyToPalette('form', 'tl_content');
});
