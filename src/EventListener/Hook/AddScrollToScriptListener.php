<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Security\Authentication\Token\TokenChecker;
use Contao\FrontendTemplate;
use Contao\Template;
use Symfony\Component\HttpFoundation\RequestStack;

use function array_merge;
use function str_starts_with;

#[AsHook('parseTemplate')]
final class AddScrollToScriptListener
{
    private const DEFAULT_SCROLLTO_OPTIONS = [
        'element'  => 'div.form-message,p.error',
        'offset'   => 100,
    ];

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly TokenChecker $tokenChecker,
    ) {
    }

    /** @SuppressWarnings(PHPMD.Superglobals) */
    public function __invoke(Template $template): void
    {
        if (! $this->match($template)) {
            return;
        }

        $GLOBALS['TL_BODY'][] = $this->generateScrollToError($template);
    }

    private function match(Template $template): bool
    {
        if (! $this->tokenChecker->isFrontendFirewall()) {
            return false;
        }

        if (! str_starts_with($template->getName(), 'form_wrapper')) {
            return false;
        }

        $request = $this->requestStack->getCurrentRequest();
        if (! $request) {
            return false;
        }

        /** @psalm-suppress UndefinedInterfaceMethod */
        if ($request->getSession()->isStarted() && $request->getSession()->getFlashBag()->has('hofff_formtools_' . $template->id)) {
            return true;
        }

        return (bool) $template->hasError;
    }

    private function generateScrollToError(Template $formTemplate): string
    {
        $template = new FrontendTemplate('hofff_formtools_scroll');
        $scrollTo = array_merge(self::DEFAULT_SCROLLTO_OPTIONS, (array) $formTemplate->formToolsScrollTo);

        $template->setData($scrollTo);

        return $template->parse();
    }
}
