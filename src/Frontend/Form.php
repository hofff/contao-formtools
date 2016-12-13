<?php

namespace Hofff\Contao\FormTools\Frontend;

use Contao\Form as ContaoForm;

class Form extends ContaoForm {

	public function generate() {
		TL_MODE == 'FE' && strlen($this->objParent->customTpl) && $this->strTemplate = $this->objParent->customTpl;
		return parent::generate();
	}

}
