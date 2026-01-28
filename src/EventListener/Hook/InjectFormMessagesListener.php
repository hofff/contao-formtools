<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\FrontendTemplate;
use Contao\ModuleModel;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

use function implode;
use function preg_replace;

final class InjectFormMessagesListener
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    #[AsHook('getFrontendModule')]
    #[AsHook('getContentElement')]
    public function onGetModuleOrElement(ContentModel|ModuleModel $element, string $buffer): string
    {
        if ($element->type !== 'form') {
            return $buffer;
        }

        $errors = $this->getErrorMessages((string) $element->form);
        if ($errors === null) {
            return $buffer;
        }

        return (string) preg_replace(
            '/<div\s+class="[^"]*formbody[^"]*">/i',
            implode("\n", $errors) . "\n" . '$0',
            $buffer,
        );
    }

    #[AsHook('parseFrontendTemplate')]
    public function onParseAjaxForTemplate(string $buffer, string $templateName, FrontendTemplate $template): string
    {
        if ($templateName !== 'form_inline') {
            return $buffer;
        }

        $request = $this->requestStack->getCurrentRequest();
        if (! $request || ! $request->isXmlHttpRequest()) {
            return $buffer;
        }

        $errors = $this->getErrorMessages((string) $template->id);
        if ($errors === null) {
            return $buffer;
        }

        return (string) preg_replace(
            '/<div\s+class="[^"]*formbody[^"]*">/i',
            implode("\n", $errors) . "\n" . '$0',
            $buffer,
        );
    }

    /**
     * @return list<string>|null
     *
     * @psalm-suppress MoreSpecificReturnType
     * @psalm-suppress LessSpecificReturnStatement
     */
    private function getErrorMessages(string $formId): array|null
    {
        $request = $this->requestStack->getCurrentRequest();
        if (! $request) {
            return null;
        }

        $session = $request->getSession();
        if (! $session instanceof Session) {
            return null;
        }

        $flashBag = $session->getFlashBag();
        $key      = 'hofff_formtools_' . $formId;

        if (! $flashBag->has($key)) {
            return null;
        }

        return $flashBag->get($key);
    }
}
