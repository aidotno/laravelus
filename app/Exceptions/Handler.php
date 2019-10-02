<?php

namespace App\Exceptions;

use Exception;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        //dd($request, $exception, $exception->getStatusCode());
        //dd(get_class($exception));
        if ($exception instanceof UnauthorizedException) {
            //if ($exception instanceof AuthorizationException) {
            /**
             * Because we use Spatie Permissions!
             */
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }
            // TODO: Redirect to error page instead
            // Redirect user from here whatever the route you want.
            return redirect()->route('login');
        }
            
        // this will still show the error if there is any in your code.
    
        return parent::render($request, $exception);
    }
}
