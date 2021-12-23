<?php

namespace App\Http\Controllers\Api;

use App\Models\Warehouse;
use Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use JWTAuth;
use Request;
use Response;

/**
 * Class Controller
 *
 * @package App\Http\Controllers\Api
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var int
     */
    protected $limit = 30;

    /**
     * @var null
     */
    protected $errorText = null;

    /**
     * @var
     */
    protected $user;

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($data)
    {
        if ($data or ((method_exists($data, "count") AND $data->count()))) {
            $statusCode = 200;
            $response = $data;
        } else {
            $response = [
                "error" => $this->errorText,
            ];
            $statusCode = 400;
        }

        return Response::json($response, $statusCode);
    }
}
