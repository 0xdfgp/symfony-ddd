<?php
declare(strict_types=1);

namespace App\Ui\Http;

use App\Application\Service\GetASafebox;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GetASafeboxController extends Controller
{
    /**
     * @Route("/safebox/{safeboxId}", methods={"GET"})
     * @param string $safeboxId
     * @return JsonResponse
     */
    public function get(string $safeboxId): JsonResponse
    {
        $safebox = $this->bus->handle(new GetASafebox($safeboxId));

        return new JsonResponse([
            'items' => $safebox['items']
        ]);
    }
}
