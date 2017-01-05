<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Database\QueryException;
use Doctrine\DBAL\Driver\PDOException;
use Addons\Entrust\Exception\PermissionException;
use Addons\Core\Http\OutputResponse;
use Illuminate\Support\Str;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Session\TokenMismatchException::class,
		\Illuminate\Validation\ValidationException::class,
		\Addons\Entrust\Exception\PermissionException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
		if (!config('app.debug', false))
		{
			// 当findOrFail等情况下出现的报错
			if($exception instanceof ModelNotFoundException)
			{
				$traces = $exception->getTrace();
				foreach($traces as $key => $value)
				{
					if ($value['function'] == '__callStatic' && Str::endsWith($value['args'][0], 'OrFail'))
					{
						$file = str_replace([base_path(), PLUGINSPATH], '', $value['file']);
						$line = $value['line'];
						return (new OutputResponse)->setResult('failure')->setMessage('document.failure_model_noexist', ['model' => $exception->getModel(), 'file' => $file , 'line' => $line, 'id' => implode(',', $exception->getIds())]);
					}
				}
				
			}
			else if($exception instanceof PermissionException)
				return (new OutputResponse)->setResult('failure')->setMessage('auth.failure_permission');
			else if ($exception instanceof TokenMismatchException)
				return (new OutputResponse)->setResult('failure')->setMessage('validation.failure_csrf');
			else if (($exception instanceof QueryException) || ($exception instanceof PDOException))
				return (new OutputResponse)->setResult('error')->setMessage('server.error_database');
			else
				return (new OutputResponse)->setResult('error')->setMessage('server.error_server');
			// other 500 errors
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
			return (new Controller())->failure('auth.failure_unlogin');//response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest('auth');
	}
}
