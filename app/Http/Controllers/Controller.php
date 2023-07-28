<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
* @OA\Info(
*    title="TECHNICAL DOCUMENTATION FOR RESTFULL APIS APPLICATION",
*    description="TECHNICAL DOCUMENTATION FOR RESTFULL APIS APPLICATION",
*    version="1.0.0",
*    @OA\Contact(
*        email="nguyenkien11202000@gmail.com"
*    ),
* ),
* @OA\Server(
*    url="http://127.0.0.1:8000/api/docs",
*    description="Server local",
*    url="https://productions/api/docs",
*    description="Server Production",
* ),
* @OA\Get(
*    path="/api/docs",
*    @OA\Response(response="200", description="An example endpoint")
* )
*/

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sentSuccessResponse($data='', $message='success', $status=200){
        return \response()->json([
            'data' => $data,
            'success' => true,
            'status' => $status,
            'text' => $message,
            'message' => $message,
            'time' => date("d/m/Y h:i:s")
        ], $status);
    }
}
