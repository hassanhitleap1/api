<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Traits\ApiResponser;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
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
        if($exception instanceof ValidationException){
            return $this->convertValidationExceptionToResponse($exception,$request);
        }
        if ($exception instanceof ModelNotFoundException){
            $modelName= strtolower(class_basename($exception->getModel()));
            return $this->errorResponce('model not found in model '. $modelName.' with specify identfarty ',404);
        }
        if ($exception instanceof AuthenticationException){
            return $this->unauthenticated($request,$exception);
        }
        if ($exception instanceof AuthorizationException){
            return $this->errorResponce($exception->getMessage(),403);
        }
        if ($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponce('the Url specify for the request is not validade ',404);
        }
        if ($exception instanceof NotFoundHttpException){
            return $this->errorResponce('the Url specify can not be found ',404);
        }
        if ($exception instanceof HttpException){
            return $this->errorResponce($exception->getMessage(),$exception->getStatusCode());
        }
        if ($exception instanceof QueryException){
            $errorCode= $exception->errorInfo[1];
            dd($exception);
            if ($errorCode == 1451){
                return $this->errorResponce('acnot remove the resoruce prmantly it is 
                related with any other resoreces '
                ,409);
            }
        }

        if(config('app.debug')){
            return parent::render($request, $exception);
        }
        return $this->errorResponce('the have and error please try later ',500);
    }



       /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        $errors = $e->validator->getMessageBag()->getMessages();
        return  $this->errorResponce($errors,422);
    }



        /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $this->errorResponce('unauthenticated',401);
    }
}
