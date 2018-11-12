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
$GLOBALS['TL_HOOKS']['getFrontendModule'][] = [
    \Hofff\Contao\FormTools\EventListener\Hook\PrependFormMessagesListener::class,
    '__invoke'
];

$GLOBALS['TL_HOOKS']['getContentElement'][] = [
    \Hofff\Contao\FormTools\EventListener\Hook\PrependFormMessagesListener::class,
    '__invoke'
];

$GLOBALS['TL_HOOKS']['parseTemplate'][] = [
    \Hofff\Contao\FormTools\EventListener\Hook\AddScrollToScriptListener::class,
    '__invoke'
];

$GLOBALS['TL_HOOKS']['parseTemplate'][] = [
    \Hofff\Contao\FormTools\EventListener\Hook\AddErrorMessageListener::class,
    '__invoke'
];

$GLOBALS['TL_HOOKS']['processFormData'][] = [
    \Hofff\Contao\FormTools\EventListener\Hook\AddSuccessMessageListener::class,
    '__invoke'
];


