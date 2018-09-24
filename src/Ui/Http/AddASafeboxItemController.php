<?php
declare(strict_types=1);

namespace App\Ui\Http;

use App\Application\Service\AddASafeboxItem;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddASafeboxItemController extends Controller
{
    /**
     * @Route("/safebox/{safeboxId}", methods={"POST"})
     * @param Request $request
     * @param string  $safeboxId
     * @return JsonResponse
     */
    public function add(Request $request, string $safeboxId): JsonResponse
    {
        $input =  \json_decode($request->getContent(), true);

        $this->bus->handle(new AddASafeboxItem($safeboxId, $input['item']));

        return new JsonResponse();
    }
}
