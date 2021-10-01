<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\FrontendTemplate;
use Contao\Template;
use Symfony\Component\HttpFoundation\Session\Session;

use function strpos;

/** @Hook("parseTemplate") */
final class AddScrollToScriptListener
{
    private const DEFAULT_SCROLLTO_OPTIONS = [
        'element'  => 'div.form-message,p.error',
        'duration' => 1000,
        'offset'   => 100,
    ];

    /** @var Session */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function __invoke(Template $template): void
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

        if ($this->session->getFlashBag()->has('hofff_formtools_' . $template->id)) {
            return true;
        }

        if (!$template->hasError) {
            return false;
        }

        return true;
    }

    private function generateScrollToError(Template $formTemplate): string
    {
        $template = new FrontendTemplate('hofff_formtools_scroll');
        $scrollTo = array_merge(self::DEFAULT_SCROLLTO_OPTIONS, (array) $formTemplate->formToolsScrollTo);

        $template->setData($scrollTo);

        return $template->parse();
    }
}
