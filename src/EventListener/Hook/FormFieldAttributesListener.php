<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Form;
use Contao\Widget;

/** @Hook("loadFormField") */
final class FormFieldAttributesListener
{
    public function __invoke(Widget $widget, string $formID, array $data, Form $form): Widget
    {
        if(! isset($widget->hofff_formtools_attributes)) {
            return $widget;
        }

        $attrs = json_decode($widget->hofff_formtools_attributes, true);

        if(json_last_error() !== JSON_ERROR_NONE) {
            return $widget;
        }

        $widget->addAttributes($attrs);

        return $widget;
    }
}
