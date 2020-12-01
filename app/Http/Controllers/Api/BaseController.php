<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Auth;


class BaseController extends Controller
{
    /**
     * @var array Хедеры для отправки ответа
     */
    public $headers = [
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
        'Access-Control-Allow-Headers' => 'Authorization, Content-Type',
        'Access-Control-Allow-Credentials' => 'True',
    ];

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response,200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)->withHeaders($this->headers);
    }

    /**
     * Метод для отправки ответа обэктом
     * @param $result
     * @param $message
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function sendResponseObj($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response,200, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT)->withHeaders($this->headers);
    }

    /**
     * return error response.
     *
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $repo = null, $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $errorMessages,
        ];

        if( !empty($errorMessages) ) {
            $response['data'] = [];
        }
        if ( $repo != null) {
            abort( response()->json($response, $code)->withHeaders($this->headers) );
        }
        return response()->json($response, $code)->withHeaders($this->headers);
    }
}
