<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
		ModelNotFoundException::class,
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
		//if (/*!config('app.debug', false) &&*/ app()->environment() == 'production')
		//{
			// 当findOrFail等情况下出现的报错
			if($e instanceof ModelNotFoundException)
			{
				$traces = $e->getTrace();$file = $line = '';
				foreach ($traces as $key => $value)
					if (isset($value['class']) && $value['class'] == 'Addons\\Core\\Models\\Model')
					{
						$file = str_replace(APPPATH, '', $traces[$key]['file']); $line = $traces[$key]['line'];
						break;
					}
				unset($traces);
				//$e = new NotFoundHttpException($e->getMessage(), $e);
				return (new Controller(false))->failure('document.failure_model_noexist', FALSE, ['model' => $e->getModel(), 'file' => $file ,'line' => $line]);
			}
			else if ($e instanceof TokenMismatchException)
				return (new Controller(false))->failure('validation.failure_csrf');

			// other 500 errors
		//}

		return parent::render($request, $e);
	}
}
