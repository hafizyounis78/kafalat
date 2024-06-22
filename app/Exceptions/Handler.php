<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {

//        if($exception instanceof \OAuthException)
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // This will replace our 404 response with
        // a JSON response.


        if ($request->is('api/*')) {
            if ($exception instanceof ModelNotFoundException &&  $request->wantsJson()) {
                return $this->responseJson(false , 'Resource not found.' , null);

            }else if($exception instanceof  MethodNotAllowedHttpException && $request->wantsJson()) {
                return $this->responseJson(false , 'Method not allowed.' , null);

            }
        }


        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {


        if ($request->expectsJson()) {
           // return $this->responseJson(false , 'Unauthenticated.' , null);
            return response()->json(['status' => false, 'status_code' => 401, 'message' => 'Unauthenticated', 'data' => []]);
        }

        return redirect()->guest(route('login'));
    }
    public function responseJson($status, $message, $data, $var = null)
    {
        $arr = [];
        $arr['status'] = $status;
        $arr['message'] = $message;
        $arr['data'] = $data;

        return response()->json($arr);
    }
}
