<?php
declare(strict_types=1);

namespace App\Ui\Http;

use App\Application\Service\OpenASafebox;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class OpenASafeBoxController extends Controller
{
    /**
     * @Route("/safebox/{safeboxId}/open", methods={"POST"})
     *
     * @param Request $request
     * @param string  $safeboxId
     * @return JsonResponse
     */
    public function open(Request $request, string $safeboxId): JsonResponse
    {
        $input =  \json_decode($request->getContent(), true);

        $token = $this->bus->handle(new OpenASafebox(
            $safeboxId,
            $request->headers->get('password'),
            $input['expirationTime']
        ));

        return new JsonResponse(['token' => $token]);
    }
}
