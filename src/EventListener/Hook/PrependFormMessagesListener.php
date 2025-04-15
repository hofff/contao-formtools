<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\ModuleModel;
use Symfony\Component\HttpFoundation\RequestStack;

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
        $request  = $this->requestStack->getCurrentRequest();
        $flashBag = $request?->getSession()->getFlashBag();
        if (! $request?->getSession()->isStarted()) {
            return $buffer;
        }

        $key = 'hofff_formtools_' . $element->form;

        if (! $flashBag || ! $flashBag->has($key)) {
            return $buffer;
        }

        return implode("\n", $flashBag->get($key)) . $buffer;
    }
}
