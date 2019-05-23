<?php
namespace Smartvalue\Providers;
use Smartvalue\Database\IConnection;

class ServiceProvider
{
    
    private $_services = [];
    
    public function __construct() {}
    
    public function register(string $classname):void{

        if(! array_key_exists($classname, $this->_services)){
            $this->_services[$classname] = $classname;
        }

    }

    public function getService(string $name):IConnection {

        if(! array_key_exists($name, $this->_services)){
        throw new \Exception('No service!');
        }
        

       // if(is_callable($this->_services[$name]))
        return new$this->_services[$name];

       // return null;    
    }
}