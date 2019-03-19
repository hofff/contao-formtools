<?php

$GLOBALS['TL_DCA']['tl_content']['palettes']['form'] .= ';{hofff_formtools_overwrite_legend}';

call_user_func(function() {
	\Contao\System::loadLanguageFile('tl_form');
	\Contao\Controller::loadDataContainer('tl_form');

	foreach($GLOBALS['TL_DCA']['tl_form']['fields'] as $name => $config) {
		if(empty($config['hofff_formtools_overwriteable'])) {
			continue;
		}

		$name = 'hofff_formtools_' . $name;
		$GLOBALS['TL_DCA']['tl_content']['fields'][$name] = $config;
		$GLOBALS['TL_DCA']['tl_content']['fields'][$name]['eval']['mandatory'] = false;
		$GLOBALS['TL_DCA']['tl_content']['palettes']['form'] .= ',' . $name;
	}
});
