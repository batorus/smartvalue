<?php

namespace Smartvalue\RPC;

/**
 * Class Error
 *
 * A description of an error that occurred on the server
 *
 * @link http://www.jsonrpc.org/specification#error_object
 */
class Error
{
    private $message;

    private $code;

    private $data;

    /**
     * @param $message
      * Short description of the error that occurred. This message SHOULD
      * be limited to a single, concise sentence.
     *
     * @param int $code
     * Integer identifying the type of error that occurred.
     *
     * @param null|boolean|integer|float|string|array $data
      * An optional primitive value that contains additional information about
     * the error.
     */
    public function __construct($message, $code, $data)
    {
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getData()
    {
        return $this->data;
    }
}
