<?php
/**
 * User: Mitul
 * Date: 16/02/15
 * Time: 1:54 PM
 */

namespace Mitul\Generator\Exceptions;


use Exception;

class RecordNotFoundException extends Exception
{

	function __construct($message = "", $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}