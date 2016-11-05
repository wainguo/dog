<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // 分页默认每页10项
    protected $perPage = 10;

    protected function jtmdsSuccess($data)
    {
        return response()->json([
            'errorCode' => 0,
            'content' => $data
        ]);
    }

    protected function jtmdsError($errorMessage, $errors=null, $errorCode=-1)
    {
        return response()->json([
            'errorCode' => $errorCode,
            'errorMessage' => $errorMessage,
            'errors' => $errors
        ]);
    }
}
