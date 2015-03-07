<?php

namespace Mitul\APIGenerator\Exceptions;


use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Mitul\APIGenerator\Utils\ResponseManager;
use Response;

class APIExceptionsHandler extends ExceptionHandler
{
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
			$msg .= $errorMsg[0]. "\n";
		}

		$msg = substr($msg, 0, strlen($msg)-1);

		$response = Response::json(ResponseManager::makeError($e->getCode(), $msg));

		return $response;
	}

	public function handleRecordNotFoundException(RecordNotFoundException $e)
	{
		return Response::json(ResponseManager::makeError($e->getCode(), $e->getMessage()));
	}

}