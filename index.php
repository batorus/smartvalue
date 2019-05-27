<?php
// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');

require_once "app/autoload.php";

use Bramus\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
Use eftec\bladeone\BladeOne;

$router = new Router();
$request = Request::createFromGlobals();
$baseurl = $request->getBaseUrl();

$views = __DIR__ . '/app/views';
$cache = __DIR__ . '/app/cache';
$blade = new BladeOne($views,$cache,BladeOne::MODE_AUTO);

//echo $blade->run("hello",array("variable1"=>"value1"));

//$router->get("test/(\d+)", function(int $id) use ($request, $baseurl){
//    return (new RedirectResponse($baseurl."/read/$id"))->send();
//});

$router->get("about", function() use ($blade, $baseurl){
   echo $blade->run("smartvalue.about",array("content"=>"About this project",
                                             "base_url"=>$baseurl));
});


use Smartvalue\RPC\Client;
use Smartvalue\RPC\Server;
use Smartvalue\ApiControllers\CountriesController;


//mimic the client 
$client = new Client();

$countries = new CountriesController();

$server = new Server($countries);


//view all countries
$router->get("/", function() use ($client, $server){
    
    try{
        $client->query(1, 'getAllRecords', []);
        $message = $client->encode(); 

        echo $message;

        $reply = $server->reply($message); 

        echo $reply;
    
    }catch(\Exception $e){
        echo $e->getMessage();
    }
   
 });
 
 //Get country by id
 $router->get("read/(\d+)", function(int $id) use ($client, $server) {
     
    try{
        $client->query(1, 'findRecordById', array($id));
        $message = $client->encode(); 
        echo $message;

        $reply = $server->reply($message); 

        echo $reply;  
    
    }catch(\Exception $e){
        echo $e->getMessage();
    }
 });
 
 
  //Get country by country code
 $router->get("read/(\w+)", function(string $code) use ($client, $server) {
     
    try{
        
// compose the message with client 
        $client->query(1, 'findRecordByCountryCode', array($code));
        $message = $client->encode(); 
        echo $message;
// end client


        $reply = $server->reply($message); 

        echo $reply;  
    
    }catch(\Exception $e){
        echo $e->getMessage();
    }
 });
 
   //Get country by country code through postman request
 $router->get("countrybycode", function() use ($server) {
     
    try{

        //Example of json for  postman request
        //{
        //    "jsonrpc": "2.0",
        //    "id": 1,
        //    "method": "findRecordByCountryCode",
        //    "params": [
        //        "GB"
        //    ]
        //}
        $message = file_get_contents("php://input");
       //end request with postman

        $reply = $server->reply($message); 

        echo $reply;  
    
    }catch(\Exception $e){
        echo $e->getMessage();
    }
 });
 
 
 

$router->run();

