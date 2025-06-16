<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\ModuleModel;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

use function implode;

#[AsHook('getFrontendModule')]
#[AsHook('getContentElement')]
final class PrependFormMessagesListener
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function __invoke(ContentModel|ModuleModel $element, string $buffer): string
    {
        if ($element->type !== 'form') {
            return $buffer;
        }

        /** @psalm-suppress UndefinedInterfaceMethod */
        $request = $this->requestStack->getCurrentRequest();
        if (! $request) {
            return $buffer;
        }

        $session = $request->getSession();
        if (! $session instanceof Session) {
            return $buffer;
        }

        $flashBag = $session->getFlashBag();
        $key      = 'hofff_formtools_' . $element->form;

        if (! $flashBag->has($key)) {
            return $buffer;
        }

        return implode("\n", $flashBag->get($key)) . $buffer;
    }
}
