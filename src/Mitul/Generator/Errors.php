<?php

namespace Mitul\Generator;

use Symfony\Component\HttpKernel\Exception;

class Errors
{
    const UNKNOWN_ERROR = 1000;
    const VALIDATION_ERROR = 1010;
    const NOT_FOUND = 1020;
    const CREATION_FORM_NOT_EXISTS = 1030;
    const EDITION_FORM_NOT_EXISTS = 1040;
    protected static $exception_namespace = '\Symfony\Component\HttpKernel\Exception\\';

    // Only HttpException child can used here
    protected static $errors = [

        self::UNKNOWN_ERROR => [
            'message'        => 'Somewhere something happened and someone already working to fix that!',
            'system_message' => 'Unknown error',
            'error_code'     => self::UNKNOWN_ERROR,
            'exception'      => 'ServiceUnavailableHttpException',
        ],

        self::VALIDATION_ERROR => [
            'message'        => 'Oops, some fields looks like incorrect!',
            'system_message' => 'Validation error',
            'error_code'     => self::VALIDATION_ERROR,
            'exception'      => 'BadRequestHttpException',
        ],

        self::NOT_FOUND => [
            'message'        => 'Sorry, we could not find requested resource',
            'system_message' => 'Record not found',
            'error_code'     => self::NOT_FOUND,
            'exception'      => 'NotFoundHttpException',
        ],

        self::CREATION_FORM_NOT_EXISTS => [
            'message'        => 'Sorry, we have nothing on this address',
            'system_message' => 'Form of creating is not supported in API',
            'error_code'     => self::CREATION_FORM_NOT_EXISTS,
            'exception'      => 'NotFoundHttpException',
        ],

        self::EDITION_FORM_NOT_EXISTS => [
            'message'        => 'Sorry, we have nothing on this address',
            'system_message' => 'Form of editing is not supported in API',
            'error_code'     => self::EDITION_FORM_NOT_EXISTS,
            'exception'      => 'NotFoundHttpException',
        ],
    ];

    /**
     * Get (with help links) errors with some codes / get unknown error or all errors.
     *
     * @param array $codes   filter errors by single code or array of codes
     * @param array $payload error description [error code => useful info]
     * @param bool  $get_all return all errors, if code not specified
     *
     * @return array
     */
    public static function getErrors($codes = [], array $payload = [], $get_all = false)
    {
        $codes = (array) $codes;
        if (empty($codes) && $get_all) {
            $codes = array_keys(static::$errors);
        }
        $return = [];
        foreach ($codes as $code) {
            if (isset(static::$errors[$code])) {
                $return[$code] = static::$errors[$code];
                unset($return[$code]['exception']);
                $return[$code]['help'] = '/errors/'.$code;
                $return[$code]['payload'] = isset($payload[$code])
                    ? $payload[$code]
                    : [];
            }
        }
        if (empty($return)) {
            if (!empty($codes)) {
                $payload = [self::UNKNOWN_ERROR => 'Unknown error codes: '.implode(',', $codes)];
            }
            $return = static::getErrors([self::UNKNOWN_ERROR], $payload);
        }

        return $return;
    }

    /**
     * throw HttpException error, that is not registered in Errors::$errors array and mix data inside.
     *
     * @param Exception\HttpException $exception
     * @param $help_link
     * @param string $system_message
     * @param array  $payload
     * @param array  $hateoas        Send here static::getHATEOAS(['%id' => $id, '%placeholder' => 'value']) from generated controller
     * @param array  $replacements   additional info inside response
     */
    public static function throwHttpException(Exception\HttpException $exception, $help_link, $system_message = '', $payload = [], $hateoas = [], $replacements = [])
    {
        $replacements = self::getReplacements($system_message, $payload, $help_link, $replacements);
        app('api.exception')->setReplacements($replacements);
        throw $exception;
    }

    /**
     * Throw HttpException with specified or unknown error.
     *
     * @param mixed $error_code   send exception for error with code
     * @param []    $payload      error description [error code => useful info]
     * @param array $hateoas      Send here static::getHATEOAS(['%id' => $id, '%placeholder' => 'value']) from generated controller
     * @param array $replacements additional info inside response
     */
    public static function throwHttpExceptionWithCode($error_code = null, $payload = [], $hateoas = [], $replacements = [])
    {
        $errors = static::getErrors([$error_code], [$error_code => $payload]);
        $error = current($errors);
        $replacements = self::getReplacements($error['system_message'], $error['payload'], $error['help'], $hateoas, $replacements);
        app('api.exception')->setReplacements($replacements);
        $exception = self::getExceptionObject(static::$errors[$error['error_code']]['exception'], $error);
        throw $exception;
    }

    /**
     * @param string $exception_class
     * @param array  $error           item from self::$errors
     *
     * @return mixed
     *
     * @internal param $exception
     */
    protected static function getExceptionObject($exception_class, $error)
    {
        $exception = static::$exception_namespace.$exception_class;
        switch ($exception_class) {
            case 'MethodNotAllowedHttpException':
                return new $exception([], $error['message'], null, [], $error['error_code']);
            case 'HttpException':
                return new $exception(400, $error['message'], null, [], $error['error_code']);
            case 'ServiceUnavailableHttpException':
            case 'TooManyRequestsHttpException':
                return new $exception(3600, $error['message'], null, $error['error_code']);
            case 'UnauthorizedHttpException':
                return new $exception('', $error['message'], null, $error['error_code']);
            default:
                return new $exception($error['message'], null, $error['error_code']);
        }
    }

    /**
     * Get array of replacements for mixing to Exception.
     *
     * <code>
     * <?php
     * app('api.exception')->setReplacements(Errors::getReplacements('Not found', ['id' => 1111], 'help/article_not_found'));
     * throw new HttpException(404, 'Sorry, article is not found');
     * ?>
     * </code>
     *
     * @param $system_message
     * @param $payload
     * @param $help_link
     * @param array $hateoas      Send here static::getHATEOAS(['%id' => $id, '%placeholder' => 'value']) from generated controller
     * @param array $replacements
     *
     * @return array
     */
    public static function getReplacements($system_message = '', $payload = [], $help_link = '', $hateoas = [], $replacements = [])
    {
        if ($system_message) {
            $replacements[':system_message'] = $system_message;
        }
        if (!empty($payload)) {
            $replacements[':payload'] = $payload;
        }
        if ($help_link) {
            $replacements[':help'] = $help_link;
        }
        if (!empty($hateoas)) {
            $replacements[':links'] = $hateoas;
        }

        return $replacements;
    }
}
