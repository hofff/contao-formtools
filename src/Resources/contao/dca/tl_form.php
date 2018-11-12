<?php

/*
 * Palettes
 */
\Contao\CoreBundle\DataContainer\PaletteManipulator::create()
    ->addLegend(
        'messages_legend',
        'template_legend',
        \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_BEFORE
    )
    ->addField(
        ['hofff_formtools_addSuccess', 'hofff_formtools_addError'],
        'messages_legend',
        \Contao\CoreBundle\DataContainer\PaletteManipulator::POSITION_APPEND
    )
    ->applyToPalette('default', 'tl_form');

$GLOBALS['TL_DCA']['tl_form']['palettes']['__selector__'][] = 'hofff_formtools_addSuccess';
$GLOBALS['TL_DCA']['tl_form']['palettes']['__selector__'][] = 'hofff_formtools_addError';

$GLOBALS['TL_DCA']['tl_form']['subpalettes']['hofff_formtools_addSuccess'] = 'hofff_formtools_success';
$GLOBALS['TL_DCA']['tl_form']['subpalettes']['hofff_formtools_addError']   = 'hofff_formtools_error';

/*
 * Fields
 */
$GLOBALS['TL_DCA']['tl_form']['fields']['jumpTo']['hofff_formtools_overwriteable'] = true;
$GLOBALS['TL_DCA']['tl_form']['fields']['recipient']['hofff_formtools_overwriteable'] = true;

$GLOBALS['TL_DCA']['tl_form']['fields']['hofff_formtools_addSuccess'] = [
    'label'			=> &$GLOBALS['TL_LANG']['tl_form']['hofff_formtools_addSuccess'],
    'inputType'		=> 'checkbox',
    'eval'			=> array(
        'submitOnChange'	=> true,
        'tl_class' => 'clr w50',
    ),
    'sql'			=> 'char(1) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_form']['fields']['hofff_formtools_addError'] = [
    'label'			=> &$GLOBALS['TL_LANG']['tl_form']['hofff_formtools_addError'],
    'inputType'		=> 'checkbox',
    'eval'			=> array(
        'submitOnChange'	=> true,
        'tl_class' => 'clr w50',
    ),
    'sql'			=> 'char(1) NOT NULL default \'\'',
];

$GLOBALS['TL_DCA']['tl_form']['fields']['hofff_formtools_error'] = array(
    'label'			=> &$GLOBALS['TL_LANG']['tl_form']['hofff_formtools_error'],
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

$GLOBALS['TL_DCA']['tl_form']['fields']['hofff_formtools_success'] = array(
    'label'			=> &$GLOBALS['TL_LANG']['tl_form']['hofff_formtools_success'],
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
