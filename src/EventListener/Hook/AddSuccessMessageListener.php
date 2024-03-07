<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Form;
use Contao\FrontendTemplate;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsHook('processFormData')]
final class AddSuccessMessageListener
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    /**
     * @param array<string, mixed>                $submitted
     * @param array<string, mixed>                $data
     * @param array<string, array<string, mixed>> $files
     * @param array<string, string>               $labels
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __invoke(array $submitted, array $data, array|null $files, array $labels, Form $form): void
    {
        if (! $form->hofff_formtools_addSuccess || $form->jumpTo) {
            return;
        }

        $template = new FrontendTemplate('hofff_formtools_message');
        $template->setData(
            [
                'type' => 'success',
                'message' => $form->hofff_formtools_success,
            ],
        );

        /** @psalm-suppress UndefinedInterfaceMethod */
        $this->requestStack->getCurrentRequest()?->getSession()->getFlashBag()->add(
            'hofff_formtools_' . $form->id,
            $template->parse(),
        );
    }
}
