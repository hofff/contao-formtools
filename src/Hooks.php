<?php

namespace Hofff\Contao\FormTools;

use Contao\Widget;
use Contao\Form;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 */
class Hooks {

	/**
	 * @param Widget $widget
	 * @param string $formId
	 * @param array $data Form data
	 * @param Form $form
	 */
	public function loadFormFieldAttributes($widget, $formId, $data, $form) {
		if(!isset($widget->hofff_formtools_attributes)) {
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
