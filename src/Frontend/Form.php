<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\Frontend;

use Contao\ContentModel;
use Contao\Form as ContaoForm;
use Contao\FormModel;
use Contao\ModuleModel;

use function strncmp;
use function substr;

/** @psalm-suppress PropertyNotSetInConstructor */
class Form extends ContaoForm
{
    public function __construct(ContentModel|ModuleModel|FormModel $element, string $column = 'main')
    {
        parent::__construct($element, $column);

        /**
         * @psalm-suppress UninitializedProperty
         * @psalm-suppress PossiblyNullReference
         */
        foreach ($this->objParent->row() as $key => $value) {
            if (empty($value)) {
                continue;
            }

            if (strncmp('hofff_formtools_', $key, 16) !== 0) {
                continue;
            }

            $key                  = substr($key, 16);
            $this->$key           = $value;
            $this->objModel->$key = $value;
        }
    }
}
