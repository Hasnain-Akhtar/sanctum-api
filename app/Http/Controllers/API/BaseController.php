<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param array $result
     * @param int $responseCode
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param  array  $errors
     * @param  array  $errorMessages
     * @param  int  $responseCode
     * @return \Illuminate\Http\Response
     */
    public function sendError($errors, $errorMessages = [], $responseCode=404)
    {
        $response = [
            'success' => false,
            'message' => $errors
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $responseCode);
    }
}
