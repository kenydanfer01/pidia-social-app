<?php

declare(strict_types=1);

namespace SocialApp\Shared\Infrastructure\Symfony;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController
{
    protected function response(iterable $data, bool $status = true, int $code = Response::HTTP_OK): Response
    {
        return new JsonResponse(array_merge(['status' => $status], (array) $data), $code);
    }

    protected function responseError(string $message, int $code = Response::HTTP_BAD_REQUEST): Response
    {
        return $this->response(['message' => $message], false, $code);
    }
}
