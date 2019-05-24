<?php

namespace Smartvalue\RPC;

use ErrorException;

/**
 * Class Client
 *
 * @link http://www.jsonrpc.org/specification JSON-RPC 2.0 Specifications
 */
class Client
{
    /** @var string */
    const VERSION = '2.0';

    /** @var array */
    private $messages = [];

    public function __construct()
    {
        $this->messages = array();
    }

    /**
     * @param mixed $id
     * @param string $method
     * @param array $arguments
     *
     * @return self
     * Returns the object handle, so you can chain method calls if you like
     */
    public function query($id, string $method, array $arguments): self
    {
        $message = array(
            'jsonrpc' => self::VERSION,
            'id' => $id,
            'method' => $method
        );

        if ($arguments !== null) {
            $message['params'] = $arguments;
        }

        $this->messages[] = $message;
        return $this;
    }

    /**
     * @param string $method
     * @param array $arguments
     *
     * @return self
     * Returns the object handle, so you can chain method calls if you like
     */
    public function notify(string $method, array $arguments): self
    {
        $message = array(
            'jsonrpc' => self::VERSION,
            'method' => $method
        );

        if ($arguments !== null) {
            $message['params'] = $arguments;
        }

        $this->messages[] = $message;
        return $this;
    }

    /**
     * Encodes the requests as a valid JSON-RPC 2.0 string
     *
     * This also resets the Client, so you can perform more queries using
     * the same Client object.
     *
     * @return null|string
     * Returns a valid JSON-RPC 2.0 message string
     * Returns null if there is nothing to encode
     */
    public function encode(): ?string
    {
        $count = count($this->messages);

        if ($count === 0) {
            return null;
        }

        if ($count === 1) {
            $output = array_shift($this->messages);
        } else {
            $output = $this->messages;
        }

        $this->messages = array();

        return json_encode($output);
    }

    /**
     * Translates a JSON-RPC 2.0 server reply into an array of "Response"
     * objects
     *
     * @param string $input
     * String reply from a JSON-RPC 2.0 server
     *
     * @return Response[]
     * Returns a zero-indexed array of "Response" objects
     *
     * @throws ErrorException
     * Throws an "ErrorException" if the reply was not well-formed
     */
    public function decode(string $input): array
    {
        set_error_handler(__CLASS__ . '::onError');
        $value = json_decode($input, true);
        restore_error_handler();

        if (($value === null) && (strtolower(trim($input)) !== 'null')) {
            $valuePhp = self::getValuePhp($input);
            throw new ErrorException("Invalid JSON: {$valuePhp}");
        }

        //var $output e referinta si tine de variabila definita intern in functie cu acelasi nume 
        if (!$this->getReply($value, $output)) {
            $valuePhp = self::getValuePhp($input);
            throw new ErrorException("Invalid JSON-RPC 2.0 response: {$valuePhp}");
        }

        return $output;
    }

    private static function getValuePhp($value)
    {
        if (is_null($value)) {
            return 'null';
        }

        if (is_resource($value)) {
            $id = (int)$value;
            return "resource({$id})";
        }

        return var_export($value, true);
    }

    private function getReply($input, &$output)
    {
        if ($this->getResponse($input, $response)) {
            $output = array($response);
            return true;
        }

        return $this->getBatchResponses($input, $output);
    }

    private function getResponse($input, &$output): bool
    {
        if (
            is_array($input) &&
            $this->getVersion($input) &&
            $this->getId($input, $id) &&
            $this->getValue($input, $value, $isError)
        ) {
            $output = new Response($id, $value, $isError);
            return true;
        }

        return false;
    }

    private function getVersion(array $input): bool
    {
        return isset($input['jsonrpc']) && ($input['jsonrpc'] === '2.0');
    }

    private function getId(array $input, &$id): bool
    {
        if (!array_key_exists('id', $input)) {
            return false;
        }

        $id = $input['id'];

        return is_null($id) || is_int($id) || is_float($id) || is_string($id);
    }

    private function getValue($input, &$value, &$isError): bool
    {
        return $this->getResult($input, $value, $isError) ||
               $this->getError($input, $value, $isError);
    }

    private function getResult(array $input, &$value, &$isError): bool
    {
        if (!array_key_exists('result', $input)) {
            return false;
        }

        $value = $input['result'];
        $isError = false;

        return true;
    }

    private function getError(array $input, &$value, &$isError): bool
    {
        if (!isset($input['error'])) {
            return false;
        }

        $error = $input['error'];

        if (
            is_array($error) &&
            $this->getMessage($error, $message) &&
            $this->getCode($error, $code) &&
            $this->getData($error, $data)
        ) {
            $value = new Error($message, $code, $data);
            $isError = true;
            return true;
        }

        return false;
    }

    private function getCode(array $input, &$code): bool
    {
        if (!isset($input['code'])) {
            return false;
        }

        $code = $input['code'];

        return is_int($code);
    }

    private function getMessage(array $input, &$message): bool
    {
        if (!isset($input['message'])) {
            return false;
        }

        $message = $input['message'];

        return is_string($message);
    }

    private function getData(array $input, &$data): bool
    {
        if (array_key_exists('data', $input)) {
            $data = $input['data'];
        } else {
            $data = null;
        }

        return true;
    }

    private function getBatchResponses($input, &$output): bool
    {
        if (!is_array($input)) {
            return false;
        }

        $results = array();
        $i = 0;

        foreach ($input as $key => $value) {
            if ($key !== $i++) {
                return false;
            }

            if (!$this->getResponse($value, $results[])) {
                return false;
            }
        }

        $output = $results;
        return true;
    }

    public static function onError($level, $message, $file, $line)
    {
        $message = trim($message);
        $code = 0;

        throw new ErrorException($message, $code, $level, $file, $line);
    }
}
