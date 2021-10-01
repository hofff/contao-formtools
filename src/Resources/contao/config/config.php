<?php

declare(strict_types=1);

use Hofff\Contao\FormTools\Frontend\Form;

/*
 * Modules
 */
$GLOBALS['FE_MOD']['application']['form'] = Form::class;

/*
 * Content elements
 */
$GLOBALS['TL_CTE']['includes']['form'] = Form::class;
