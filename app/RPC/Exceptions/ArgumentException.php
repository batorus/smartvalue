<?php
namespace Smartvalue\RPC\Exceptions;

/**
 * @link http://www.jsonrpc.org/specification#error_object
 */
class ArgumentException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid params', -32602);
    }
}
