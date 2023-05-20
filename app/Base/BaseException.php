<?php

namespace App\Base;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Exceptions\InvalidArgumentException;

/**
 * Class BaseException
 * @package App\Exceptions
 */
abstract class BaseException extends Exception
{
    /**
     * @return string
     */
    abstract public function errorCode();

    /**
     * @return int
     */
    abstract public function statusCode();

    abstract public function message();

    /**
     * @param $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    public function render($request)
    {
        return response()->json([
            'code' => $this->statusCode(),
            'error_code' => $this->errorCode(),
            'message' => $this->message(),
        ], $this->statusCode());
    }

    /**
     * @param $errorCode
     * @return mixed
     * @throws InvalidArgumentException
     */
}
