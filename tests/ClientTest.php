<?php

namespace Smartvalue\Tests;
use PHPUnit_Framework_TestCase;
use Smartvalue\RPC\Client;
use Smartvalue\RPC\Response;
use Smartvalue\RPC\Error;
use Smartvalue\ApiControllers\CountriesController;

class ClientTest extends PHPUnit_Framework_TestCase{
    
    /** @test */
    public function notify_response()
    {
        $client = new Client();
        $client->notify('methodname', array(3, 2));
        $this->compare($client, '{"jsonrpc":"2.0","method":"methodname","params":[3,2]}');
    }

    /** @test */    
     public function query_response()
    {
        $client = new Client();
        $client->query(1, 'methodname', array(3, 2));
        $this->compare($client, '{"jsonrpc":"2.0","id":1,"method":"methodname","params":[3,2]}');
    }
 
     /** @test */     
    public function empty_response()
    {
        $client = new Client();
        $this->compare($client, null);
    }
    
     /** @test */     
    public function reset()
    {
        $client = new Client();
        $client->notify('methodname', array(3, 2));
        $client->encode(); 
        $this->compare($client, null);
    } 

    /** @test */ 
    public function decode_response_same_values()
    {
        $reply = '{"jsonrpc":"2.0","result":2,"id":1}';
        $client = new Client();
        $actualOutput = $client->decode($reply);
        $response = new Response(1, 2, false);
        $expectedOutput = array($response);
        $this->assertSameValues($expectedOutput, $actualOutput);
    }
    
    /** @test */     
     public function decode_error_response()
    {
        $reply = '{"jsonrpc":"2.0","id":1,"error":{"code":-32601,"message":"Method not found"}}';
        $client = new Client();
        $actualOutput = $client->decode($reply);
        $error = new Error('Method not found', -32601, null);
        $response = new Response(1, $error, true);
        $expectedOutput = array($response);
        $this->assertSameValues($expectedOutput, $actualOutput);
    }
    
     private function assertSameValues($expected, $actual)
    {
        $expectedPhp = var_export($expected, true);
        $actualPhp = var_export($actual, true);
        $this->assertSame($expectedPhp, $actualPhp);
    }
    
    
     private function compare(Client $client, $expectedJsonOutput)
    {
        $actualJsonOutput = $client->encode();
        $expectedOutput = @json_decode($expectedJsonOutput, true);
        $actualOutput = @json_decode($actualJsonOutput, true);
        $this->assertEquals($expectedOutput, $actualOutput);
    }
}
