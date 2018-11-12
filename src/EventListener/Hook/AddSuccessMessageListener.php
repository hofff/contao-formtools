<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\Form;
use Contao\FrontendTemplate;
use Symfony\Component\HttpFoundation\Session\Session;

final class AddSuccessMessageListener
{
    /**
     * @var Session
     */
    private $session;

    /**
     * AddSuccessMessageListener constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function __invoke(array $submitted, array $data, array $files, array $labels, Form $form): void
    {
        if (!$form->hofff_formtools_addSuccess) {
            return;
        }

        $template = new FrontendTemplate('hofff_formtools_message');
        $template->setData(
            [
                'type' => 'success',
                'message' => $form->hofff_formtools_success
            ]
        );

        $this->session->getFlashBag()->add(
            'hofff_formtools_' . $form->id,
            $template->parse()
        );
    }
}
