<?php
declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class OnJWTDecodedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function handle(JWTDecodedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $safeboxId = $request->attributes->get('safeboxId');

        $payload = $event->getPayload();

        if ($safeboxId === null || !isset($payload['username']) || $payload['username'] !== $safeboxId) {
            $event->markAsInvalid();
        }
    }
}
