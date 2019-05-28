<?php

namespace Smartvalue\Tests;
use PHPUnit_Framework_TestCase;
use Smartvalue\RPC\Client;
use Smartvalue\RPC\Response;
use Smartvalue\RPC\Error;
use Smartvalue\ApiControllers\CountriesController;

class ClientTest extends PHPUnit_Framework_TestCase{
    
    /** @test */
    public function notify_is_ok()
    {
        $client = new Client();
        $client->notify('yourmethod', array(3, 2));
        $this->compare($client, '{"jsonrpc":"2.0","method":"yourmethod","params":[3,2]}');
    }
    
     private function compare(Client $client, $expectedJsonOutput)
    {
        $actualJsonOutput = $client->encode();
        $expectedOutput = @json_decode($expectedJsonOutput, true);
        $actualOutput = @json_decode($actualJsonOutput, true);
        $this->assertEquals($expectedOutput, $actualOutput);
    }
}
