<?php

namespace Smartvalue\RPC\Exceptions;

use Exception as BaseException;

/**
 * @link http://www.jsonrpc.org/specification#error_object
 */
abstract class Exception extends BaseException
{
    /** @var null|boolean|integer|float|string|array */
    private $data;

    /**
     * @param string $message
     * Short description of the error that occurred. This message SHOULD
     * be limited to a single, concise sentence.
     *
     * @param int $code
     * Integer identifying the type of error that occurred. This code MUST
     * follow the JSON-RPC 2.0 requirements for error codes:
     * @link http://www.jsonrpc.org/specification#error_object
     *
     * @param null|boolean|integer|float|string|array $data
     * An optional primitive value that contains additional information about
     * the error.You're free to define the format of this data (e.g. you could
     * supply an array with detailed error information). Alternatively, you may
     * omit this field by supplying a null value.
     */
    public function __construct(string $message,int $code, $data = null)
    {
        parent::__construct($message, $code);

        $this->data = $data;
    }

    /**
     * @return null|boolean|integer|float|string|array
     * Returns the (optional) data property of the error object.
     */
    public function getData()
    {
        return $this->data;
    }
}
