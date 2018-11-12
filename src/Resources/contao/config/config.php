<?php

declare(strict_types=1);

/*
 * Modules
 */
$GLOBALS['FE_MOD']['application']['form'] = \Hofff\Contao\FormTools\Frontend\Form::class;

/*
 * Content elements
 */
$GLOBALS['TL_CTE']['includes']['form'] = \Hofff\Contao\FormTools\Frontend\Form::class;

/*
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseTemplate'][] = [
    \Hofff\Contao\FormTools\EventListener\Hook\AddScrollToScriptListener::class,
    'onParseTemplate'
];
