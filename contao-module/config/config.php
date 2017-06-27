<?php

$GLOBALS['FE_MOD']['application']['form']
	= \Hofff\Contao\FormTools\Frontend\Form::class;

$GLOBALS['TL_CTE']['includes']['form']
	= \Hofff\Contao\FormTools\Frontend\Form::class;

$GLOBALS['TL_HOOKS']['loadFormField']['hofff_formtools_attributes']
	= [ \Hofff\Contao\FormTools\Hooks::class, 'loadFormFieldAttributes' ];
