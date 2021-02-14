<?php

namespace App\Infrastructure\Middleware;

use App\Infrastructure\ApiKey;
use App\Infrastructure\Http\Request;
use Exception;

/**
 * Class Cors
 *
 * @package App\Infrastructure\Middleware
 */
abstract class CorsMiddleware
{
    /**
     * @param Request $request
     *
     * @throws Exception
     */
    public static function validate(Request $request): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
            header('Access-Control-Allow-Headers: *');
            header('Access-Control-Max-Age: 1728000');
            header('Accept: application/json, text/plain, */*');
            header('Content-Length: 0');
            header('Content-Type: text/plain');
            die();
        }

        $instance = $request::singleton();

        $apiKey = $instance->getHeaders($_ENV['API_KEY']);

        if (!$apiKey) {
            $apiKey = $instance->getQueryString('api_key');
        }

        if (!$apiKey) {
            throw new Exception("api_key_permission_denied", 400);
        }

        $apiKeyInstance = ApiKey::singleton($apiKey);

        if (!$apiKeyInstance->isEnabled()) {
            throw new Exception("api_key_permission_denied", 400);
        }

        header("Access-Control-Allow-Origin: {$_ENV['CORS_ORIGIN']}");
        header('Content-Type: application/json');
    }
}
