<?php

namespace App\Exceptions;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException implements Responsable
{
    protected $error;

    public function __construct(string $error = null, int $statusCode = 409, \Exception $previous = null, array $headers = array(), ?int $code = 0)
    {
        $this->error = $error;
        parent::__construct($statusCode, $error, $previous, $headers, $code);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return Response::json([
            'message'   => $this->getMessage(),
            'status'    => $this->getStatusCode(),
            'exception'     => class_basename($this),
        ], $this->getStatusCode());
    }

}
