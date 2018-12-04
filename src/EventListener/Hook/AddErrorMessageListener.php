<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\FrontendTemplate;
use Contao\Template;
use Symfony\Component\HttpFoundation\Session\Session;
use function array_key_exists;

final class AddErrorMessageListener
{
    /**
     * @var Session
     */
    private $session;

    private $cache = [];

    /**
     * AddSuccessMessageListener constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function __invoke(Template $formTemplate): void
    {
        if (!$this->match($formTemplate)) {
            return;
        }

        $template = new FrontendTemplate('hofff_formtools_message');
        $template->setData(
            [
                'type' => 'error',
                'message' => $formTemplate->hofff_formtools_error
            ]
        );

        $this->session->getFlashBag()->add(
            'hofff_formtools_' . $formTemplate->id,
            $template->parse()
        );
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

        if (!$template->hofff_formtools_addError) {
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
