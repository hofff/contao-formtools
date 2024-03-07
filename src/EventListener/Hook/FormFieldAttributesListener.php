<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Widget;

use function json_decode;
use function json_last_error;

use const JSON_ERROR_NONE;

#[AsHook('loadFormField')]
final class FormFieldAttributesListener
{
    /** @psalm-suppress DocblockTypeContradiction */
    public function __invoke(Widget $widget): Widget
    {
        if (! isset($widget->hofff_formtools_attributes)) {
            return $widget;
        }

        $attrs = json_decode($widget->hofff_formtools_attributes, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $widget;
        }

        $widget->addAttributes($attrs);

        return $widget;
    }
}
