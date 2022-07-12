<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SwaggerConfigController extends Controller
{
     /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Laravel OpenApi  Documentation",
     *      description="L5 Swagger OpenApi description",
     *      @OA\Contact(
     *          email="deendipo@gmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description=" API Documentation Server"
     * )

     *
     * @OA\Tag(
     *     name="Retail App",
     *     description="API Endpoints of Retail app"
     * )
     */
}
