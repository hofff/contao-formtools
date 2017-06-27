<?php

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][]
	= 'hofff_formtools_addHelp';

$palettes = &$GLOBALS['TL_DCA']['tl_form_field']['palettes'];
foreach($palettes as $key => &$palette) if($key != '__selector__') {
	$palette = str_replace(';{expert_legend:hide}', ';{hofff_formtools_help_legend:hide},hofff_formtools_addHelp;{expert_legend:hide},hofff_formtools_attributes', $palette);
}
unset($palette, $palettes);

$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['hofff_formtools_addHelp']
	= 'hofff_formtools_help';

$GLOBALS['TL_DCA']['tl_form_field']['fields']['hofff_formtools_addHelp'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_form_field']['hofff_formtools_addHelp'],
	'inputType'		=> 'checkbox',
	'eval'			=> array(
		'submitOnChange'	=> true,
	),
	'sql'			=> 'char(1) NOT NULL default \'\'',
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['hofff_formtools_help'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_form_field']['hofff_formtools_help'],
	'exclude'		=> true,
	'search'		=> true,
	'inputType'		=> 'textarea',
	'eval'			=> array(
		'rte'			=> 'tinyMCE',
		'helpwizard'	=> true,
	),
	'explanation'	=> 'insertTags',
	'sql'			=> 'text NULL',
);

$GLOBALS['TL_DCA']['tl_form_field']['fields']['hofff_formtools_attributes'] = array(
	'label'			=> &$GLOBALS['TL_LANG']['tl_form_field']['hofff_formtools_attributes'],
	'exclude'		=> true,
	'search'		=> true,
	'inputType'		=> 'textarea',
	'eval'			=> array(
		'decodeEntities'=> true,
		'rows'			=> 4,
		'cols'			=> 40,
		'tl_class'		=> 'clr',
	),
	'save_callback'	=> array(
		function($value, $dc) {
			if(!strlen($value)) {
				return null;
			}

			$decoded = json_decode($value, true);

			if(json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
				throw new \Exception($GLOBALS['TL_LANG']['tl_form_field']['hofff_formtools_json_error']);
			}

			return $value;
		},
	),
	'sql'			=> 'text NULL',
);
