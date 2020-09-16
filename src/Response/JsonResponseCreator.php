<?php

declare(strict_types=1);

namespace App\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseCreator
{
    /**
     * @param string $message
     * @param int $httpCode
     *
     * @return JsonResponse
     */
    public static function createErrorJsonResponse(
        string $message,
        int $httpCode = Response::HTTP_OK
    ): JsonResponse {
        return self::createJsonResponse(false, [
            'message' => $message,
        ], $httpCode);
    }

    /**
     * @param array $data
     * @param int $httpCode
     *
     * @return JsonResponse
     */
    public static function createSuccessfulJsonResponse(
        array $data,
        int $httpCode = Response::HTTP_OK
    ): JsonResponse {
        return self::createJsonResponse(true, $data, $httpCode);
    }

    /**
     * @param bool $isSuccessful
     * @param array $data
     * @param int $httpCode
     *
     * @return JsonResponse
     */
    private static function createJsonResponse(
        bool $isSuccessful,
        array $data,
        int $httpCode
    ): JsonResponse {
        return new JsonResponse([
            'success' => $isSuccessful,
            'data' => $data,
        ], $httpCode);
    }
}
