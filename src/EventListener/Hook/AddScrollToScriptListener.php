<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\FrontendTemplate;
use Contao\Template;
use function strpos;

final class AddScrollToScriptListener
{
    private const DEFAULT_SCROLLTO_OPTIONS = [
        'element'  => 'p.error',
        'duration' => 1000,
        'offset'   => 100,
    ];

    public function onParseTemplate(Template $template): void
    {
        if (!$this->match($template)) {
            return;
        }

        $GLOBALS['TL_BODY'][] = $this->generateScrollToError($template);
    }

    private function match(Template $template): bool
    {
        if (TL_MODE !== 'FE') {
            return false;
        }

        if (strpos($template->getName(), 'form_wrapper') !== 0) {
            return false;
        }

        if (!$template->hasError) {
            return false;
        }

        return true;
    }

    private function generateScrollToError(Template $formTemplate): string
    {
        $template = new FrontendTemplate('formtools_error_scroll');
        $scrollTo = array_merge(self::DEFAULT_SCROLLTO_OPTIONS, (array) $formTemplate->formToolsScrollTo);

        $template->setData($scrollTo);

        return $template->parse();
    }
}
