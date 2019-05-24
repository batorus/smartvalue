<?php

namespace Smartvalue\ApiControllers;
use Smartvalue\Models\Countries;
use Smartvalue\Database\PDOConnection;
use Smartvalue\RPC\Exceptions\ArgumentException;
use Smartvalue\RPC\Exceptions\MethodException;


class CountriesController implements ApiEvaluator{
    
    private $countries;
    
    public function __construct(){
        $this->countries = new Countries(new PDOConnection);
    }
    
    public function evaluate($method, $arguments = []) {
        
        if ($method === 'getAllRecords') {
            
            return $this->countries->getAllRecords();
        }
        
        if ($method === 'findRecordById') {
             
            [$id] = $arguments;
            
            if (!is_int($id)) {
                throw new ArgumentException();
            }
           
            return $this->countries->findRecordById($id);
        }
        
        if ($method === 'findRecordByCountryCode') {
             
            [$code] = $arguments;
            
            if (!is_string($code)) {
                throw new ArgumentException();
            }
           
            return $this->countries->findRecordByCountryCode($code);
        }        
        
        throw new MethodException();        
    }

}
