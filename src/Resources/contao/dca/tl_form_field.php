<?php

/*
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'hofff_formtools_addHelp';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['hofff_formtools_addHelp'] = 'hofff_formtools_help';

/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form_field']['fields']['hofff_formtools_addHelp'] = [
    'inputType' => 'checkbox',
    'eval'      => [
        'submitOnChange' => true,
    ],
    'sql'       => 'char(1) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['hofff_formtools_help'] = [
    'exclude'     => true,
    'search'      => true,
    'inputType'   => 'textarea',
    'eval'        => [
        'rte'        => 'tinyMCE',
        'helpwizard' => true,
    ],
    'explanation' => 'insertTags',
    'sql'         => 'text NULL',
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['hofff_formtools_attributes'] = [
    'exclude'       => true,
    'search'        => true,
    'inputType'     => 'textarea',
    'eval'          => [
        'decodeEntities' => true,
        'rows'           => 4,
        'cols'           => 40,
        'tl_class'       => 'clr',
    ],
    'save_callback' => [
        function ($value) {
            if (!strlen($value)) {
                return null;
            }

            $decoded = json_decode($value, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                throw new \Exception($GLOBALS['TL_LANG']['tl_form_field']['hofff_formtools_json_error']);
            }

            return $value;
        },
    ],
    'sql'           => 'text NULL',
];
