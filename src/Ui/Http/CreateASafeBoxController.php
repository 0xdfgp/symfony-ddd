<?php
declare(strict_types=1);

namespace App\Ui\Http;

use App\Application\Service\CreateASafebox;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class CreateASafeBoxController extends Controller
{
    /**
     * @Route("/safebox", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $input = \json_decode($request->getContent(), true);

        $safebox = $this->bus->handle(new CreateASafebox($input['name'], $input['password']));

        return new JsonResponse(['id' => $safebox['id']]);
    }
}
