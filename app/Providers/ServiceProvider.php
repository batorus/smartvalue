<?php
namespace Smartvalue\Providers;
use Smartvalue\Database\IConnection;

class ServiceProvider
{
    
    private $_services = [];
    
    public function __construct() {}
    
    public function register(string $name, \Closure $callback){

        if(! array_key_exists($name, $this->_services)){
        $this->_services[$name] = $callback;
        }

    }

    public function getService(string $name):?IConnection {

        if(! array_key_exists($name, $this->_services)){
        throw new \Exception('No service with {$name} value');
        }
        
        if(is_callable($this->_services[$name]()))
        return $this->_services[$name]();

        return null;    
    }
}