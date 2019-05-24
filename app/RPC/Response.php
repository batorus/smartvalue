<?php
namespace Smartvalue\RPC;

/**
 * Class Response
 * @package Datto\JsonRpc
 *
 * A response from the server
 *
 * @link http://www.jsonrpc.org/specification#response_object
 */
class Response
{
    /** @var null|int|float|string */
    private $id;

    /** @var bool */
    private $isError;

    /** @var null|int|float|string|array */
    private $result;

    /** @var Error|null */
    private $error;

    public function __construct(int $id, $value, bool $isError)
    {
        if ($isError) {
            $result = null;
            $error = $value;
        } else {
            $result = $value;
            $error = null;
        }

        $this->id = $id;
        $this->result = $result;
        $this->error = $error;
        $this->isError = $isError;
    }

    /**
     * @return null|int|float|string
     * A unique identifier, used to match this server response with an earlier
     * user request
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * A response will contain either an error object, or a result, but not both.
     *
     * @return bool
     * True iff the response contains an error object
     * False iff the response contains a result
     */
    public function isError()
    {
        return $this->isError;
    }

    /**
     * @return null|int|float|string|array
     * The result returned by the server (if applicable)
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return Error|null
     * An error object describing the server issue (if applicable)
     */
    public function getError()
    {
        return $this->error;
    }
}
