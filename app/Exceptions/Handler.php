<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Addons\Core\Controllers\Controller;
class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		HttpException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if (/*!config('app.debug', false) &&*/ app()->environment() == 'production')
		{
			// 当findOrFail等情况下出现的报错
			if($e instanceOf ModelNotFoundException)
				return (new Controller)->failure('document.failure_model_noexist', FALSE, ['model' => $e->getModel(), 'file' => $e->getFile() ,'line' => $e->getLine()]);
			else if ($e instanceOf TokenMismatchException)
				return (new Controller)->failure('validation.failure_csrf');

			// other 500 errors
		}

		return parent::render($request, $e);
	}
}
