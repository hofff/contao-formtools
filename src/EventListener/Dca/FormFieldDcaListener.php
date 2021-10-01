<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Dca;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\ServiceAnnotation\Callback;

use function is_string;

final class FormFieldDcaListener
{
    /** @Callback(table="tl_form_field", target="config.onload") */
    public function onLoad(): void
    {
        $palettes    = $GLOBALS['TL_DCA']['tl_form_field']['palettes'] ?? [];
        $manipulator = PaletteManipulator::create()
            ->addLegend('hofff_formtools_help_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE, true)
            ->addField('hofff_formtools_addHelp', 'hofff_formtools_help_legend', PaletteManipulator::POSITION_APPEND)
            ->addField('hofff_formtools_attributes', 'expert_legend', PaletteManipulator::POSITION_APPEND);

        foreach ($palettes as $key => $palette) {
            if ($key === '__selector__' || !is_string($palette)) {
                continue;
            }

            $manipulator->applyToPalette($key, 'tl_form_field');
        }
    }
}
