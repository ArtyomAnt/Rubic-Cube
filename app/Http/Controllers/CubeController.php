<?php

namespace App\Http\Controllers;

use App\Repositories\CubeRepository;
use App\Services\Builders\Generator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CubeController extends Controller
{
    public function getCube(CubeRepository $repository, int $id): JsonResponse
    {
        $cube = $repository->getById($id);

        if ($cube === null) {
            return new JsonResponse(['error' => 'Cube not found.'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            [
                'id' => $id,
                'cube' => $cube
            ]
        );
    }

    public function generate(CubeRepository $repository, Generator $generator, int $size = 3): JsonResponse
    {
        $cube = $generator->generate($size);

        $id = $repository->create($cube);

        return new JsonResponse(
            [
                'id' => $id,
                'cube' => $cube
            ]
        );
    }

}
