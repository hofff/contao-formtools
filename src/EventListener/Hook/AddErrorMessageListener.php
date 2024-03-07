<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Security\Authentication\Token\TokenChecker;
use Contao\FrontendTemplate;
use Contao\Template;
use Symfony\Component\HttpFoundation\RequestStack;

use function array_key_exists;
use function str_starts_with;

#[AsHook('parseTemplate')]
final class AddErrorMessageListener
{
    /** @var array<string|int, null> */
    private array $cache = [];

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly TokenChecker $tokenChecker,
    ) {
    }

    public function __invoke(Template $formTemplate): void
    {
        if (! $this->match($formTemplate)) {
            return;
        }

        $template = new FrontendTemplate('hofff_formtools_message');
        $template->setData(
            [
                'type' => 'error',
                'message' => $formTemplate->hofff_formtools_error,
            ],
        );

        /** @psalm-suppress UndefinedInterfaceMethod */
        $this->requestStack->getCurrentRequest()?->getSession()->getFlashBag()->add(
            'hofff_formtools_' . $formTemplate->id,
            $template->parse(),
        );
    }

    private function match(Template $template): bool
    {
        if (! $this->tokenChecker->isFrontendFirewall()) {
            return false;
        }

        if (! str_starts_with($template->getName(), 'form_wrapper')) {
            return false;
        }

        if (! $template->hasError) {
            return false;
        }

        if (! $template->hofff_formtools_addError) {
            return false;
        }

        // FIXME: Temporary workaround for https://github.com/contao/contao/issues/214
        if (array_key_exists($template->id, $this->cache)) {
            return false;
        }

        $this->cache[$template->id] = null;

        return true;
    }
}
