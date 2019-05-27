<?php

namespace Smartvalue\Tests;
use PHPUnit_Framework_TestCase;
use Smartvalue\RPC\Server;
use Smartvalue\ApiControllers\CountriesController;

class ServerTest extends PHPUnit_Framework_TestCase{
    
    /** @test */
    public function find_record_by_id(){
        
        $input = '{"jsonrpc":"2.0","id":1,"method":"findRecordById","params":[5]}';
        $output = '{"jsonrpc":"2.0","id":1,"result":{"id":"5","name":"Canada","code":"CA","prefix":"+1"}}';
        
        $this->compare($input, $output);
    } 
    
    /** @test */
    public function response_with_empty_array_find_country_by_id_when_result_not_found()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "findRecordById", "params": [0]}';
        $output = '{"jsonrpc":"2.0","id":1,"result":[]}';
        $this->compare($input, $output);
    }
    
    /** @test */
    public function response_find_country_by_id_when_arguments_not_provided()
    {
        $input = '{"jsonrpc": "2.0", "id": 1, "method": "findRecordById", "params": []}';
        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32602, "message": "Invalid params"}}';
        $this->compare($input, $output);
    }
    
    /** @test */
    public function find_country_by_country_code(){
        
        $countrycode = "GR";
        $countryname = "Greece";
        $input = '{"jsonrpc":"2.0","id":1,"method":"findRecordByCountryCode","params":["'.$countrycode.'"]}';
        $output = '{"jsonrpc":"2.0","id":1,"result":{"prefix":"+30","name":"'.$countryname.'"}}';
        
        $this->compare($input, $output);
    } 
    
    /** @test */
    public function response_find_country_by_country_code_when_no_args_provided(){

        $input = '{"jsonrpc": "2.0", "id": 1, "method": "findRecordByCountryCode", "params": []}';
        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32602, "message": "Invalid params"}}';
        $this->compare($input, $output);
    } 
    
     /** @test */
    public function response_with_empty_array_when_wrong_input(){

        $input = '{"jsonrpc":"2.0","id":1,"method":"findRecordByCountryCode","params":["inexistentcode"]}';
        $output = '{"jsonrpc":"2.0","id":1,"result":[]}';
        $this->compare($input, $output);
    }    
    
    /** @test */
    public function method_is_undefined()
    {
        $input ='{"jsonrpc": "2.0", "id": 1, "method": "undefinedmethod"}';
        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32601, "message": "Method not found"}}';
        $this->compare($input, $output);
    }
    
     /** @test */
     public function invalid_json()
    {
        $input = '{"jsonrpc": "2.0", "method": "foobar", "params": "bar", "baz]';
        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32700, "message": "Parse error"}}';
        $this->compare($input, $output);
    }
    
     /** @test */
    public function missing_jsonrpc_version()
    {
        $input = '{"method": "subtract", "params": [3, 2], "id": 1}';
        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32600, "message": "Invalid Request"}}';
        $this->compare($input, $output);
    }

     /** @test */
   public function invalid_jsonrpc_version()
    {
        $input = '{"jsonrpc": "2.1", "id": 1, "method": "subtract", "params": [3, 2]}';
        $output = '{"jsonrpc": "2.0", "id": 1, "error": {"code": -32600, "message": "Invalid Request"}}';
        $this->compare($input, $output);
    }
    
     /** @test */   
    public function invalid_method()
    {
        $input = '{"jsonrpc": "2.0", "method": 1, "params": [1, 2]}';
        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}}';
        $this->compare($input, $output);
    }
    
    /** @test */  
    public function invalid_parameters()
    {
        $input = '{"jsonrpc": "2.0", "method": "foobar", "params": "bar"}';
        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}}';
        $this->compare($input, $output);
    }
    
     /** @test */     
    public function invalid_id()
    {
        $input = '{"jsonrpc": "2.0", "method": "foobar", "params": [1, 2], "id": [1]}';
        $output = '{"jsonrpc": "2.0", "id": null, "error": {"code": -32600, "message": "Invalid Request"}}';
        $this->compare($input, $output);
    }

   
    
    private function compare($input, $expectedJsonOutput)
    {
        $server = new Server(new CountriesController());
        $actualJsonOutput = $server->reply($input);
        $expectedOutput = json_decode($expectedJsonOutput, true);
        $actualOutput = json_decode($actualJsonOutput, true);
        $this->assertSame($expectedOutput, $actualOutput);
    }
}
