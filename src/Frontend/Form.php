<?php

namespace Hofff\Contao\FormTools\Frontend;

use Contao\ContentModel;
use Contao\FormModel;
use Contao\ModuleModel;
use Form as ContaoForm;

/**
 * @author Oliver Hoff <oliver@hofff.com>
 */
class Form extends ContaoForm
{
    /**
     * @param ContentModel|ModuleModel|FormModel $element
     * @param string                                $column
     */
    public function __construct($element, $column = 'main')
    {
        parent::__construct($element, $column);

        foreach ($this->objParent->row() as $key => $value) {
            if (empty($value)) {
                continue;
            }
            if (0 !== strncmp('hofff_formtools_', $key, 16)) {
                continue;
            }

            $key                  = substr($key, 16);
            $this->$key           = $value;
            $this->objModel->$key = $value;
        }
    }
}
