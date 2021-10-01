<?php

declare(strict_types=1);

namespace Hofff\Contao\FormTools\EventListener\Hook;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Symfony\Component\HttpFoundation\Session\Session;

use function implode;

/**
 * @Hook("getFrontendModule")
 * @Hook("getContentElement")
 */
final class PrependFormMessagesListener
{
    /** @var Session */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function __invoke($element, string $buffer): string
    {
        if ($element->type !== 'form') {
            return $buffer;
        }

        $flashBag = $this->session->getFlashBag();
        $key      = 'hofff_formtools_' . $element->form;

        if (!$flashBag->has($key)) {
            return $buffer;
        }

        return implode("\n", $flashBag->get($key)) . $buffer;
    }
}
