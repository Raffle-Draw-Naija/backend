<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="APIs For Raffle Draw",
 *    version="1.0.0",
 * ),
 *   @OA\SecurityScheme(
 *       securityScheme="sanctum",
 *      type = "apiKey",
 *       description = "Enter token in format (Bearer <token>)",
 *       name = "Authorization",
 *       in = "header",
 *    ),
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
