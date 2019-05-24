<?php

namespace Smartvalue\ApiControllers;
use Smartvalue\Models\Countries;
use Smartvalue\Database\PDOConnection;


class CountriesController implements ApiEvaluator{
    
    private $countries;
    
    public function __construct(){
        $this->countries = new Countries(new PDOConnection);
    }
    
    public function evaluate($method, $arguments = []) {
        
        if ($method === 'getAllRecords') {
             
//            @list($a, $b) = $arguments;
//            if (!is_int($a) || !is_int($b)) {
//                throw new ArgumentException();
//            }
//            return Math::add($a, $b);
//             
//            return self::add($arguments);
            
            return $this->countries->getAllRecords();
        }
        
        throw new MethodException();        
    }

}
