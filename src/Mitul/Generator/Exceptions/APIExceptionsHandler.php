<?php

namespace Mitul\Generator\Exceptions;


use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Mitul\Generator\Utils\ResponseManager;
use Response;

class APIExceptionsHandler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception $e
	 *
	 * @return void
	 */
	public function report(Exception $e)
	{

	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Exception               $e
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $e)
	{
		if($e instanceof AppValidationException)
			return $this->handleValidationException($e);
		if($e instanceof RecordNotFoundException)
			return $this->handleRecordNotFoundException($e);
		else
			return parent::render($request, $e);
	}

	private function handleValidationException(AppValidationException $e)
	{
		$msg = "";

		foreach($e->dataMsg as $field => $errorMsg)
		{
			$msg .= $errorMsg[0] . "\n";
		}

		$msg = substr($msg, 0, strlen($msg) - 1);

		$response = Response::json(ResponseManager::makeError($e->getCode(), $msg));

		return $response;
	}

	public function handleRecordNotFoundException(RecordNotFoundException $e)
	{
		return Response::json(ResponseManager::makeError($e->getCode(), $e->getMessage()));
	}
}