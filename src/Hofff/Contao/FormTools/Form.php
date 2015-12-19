<?php

namespace Hofff\Contao\FormTools;

class Form extends \Form {

	public function generate() {
		TL_MODE == 'FE' && strlen($this->objParent->customTpl) && $this->strTemplate = $this->objParent->customTpl;
		return parent::generate();
	}

}
