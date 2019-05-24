<?php
 header('Access-Control-Allow-Origin: *');
 header('Content-Type: application/json');

require_once "app/autoload.php";

use Bramus\Router\Router;
$router = new Router();

use Smartvalue\RPC\Client;
use Smartvalue\RPC\Server;
use Smartvalue\ApiControllers\CountriesController;



//var_dump($c->findRecordById(0));

//find a record by id
// $router->get("countries/(\d+)", function(int $id) use ($countries) {
//  try{ 
//   var_dump($countries->findRecordById($id));
//  }catch(\PDOException $e){
//      echo $e->getMessage();
//  }
// });
 
//  $router->get("countries/(\w+)", function(string $code) use ($countries) {
//  try{ 
//   var_dump($countries->findRecordByCountryCode($code));
//  }catch(\PDOException $e){
//      echo $e->getMessage();
//  }
// });
// 
 
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
//        $client->query(1, 'findRecordByCountryCode', array($code));
//        $message = $client->encode(); 
//        echo $message;
        
        $message = file_get_contents("php://input");
        echo $message;
        var_dump($message);die();

        $reply = $server->reply($message); 

        echo $reply;  
    
    }catch(\Exception $e){
        echo $e->getMessage();
    }
 });
 
 // //get all customers
// $router->get("customers/read", function() use ($customersApiController) {
//   $customersApiController->readAction();
// });

//use Smartvalue\Providers\RegisterServiceProvider;
//
//$csp = new RegisterServiceProvider();
//
//var_dump($csp->getService("PDOConnection"));

// $router->get("/", function(){
//  echo "Hello ";
// });

// use Discounts\ApiControllers\CustomersApiController;
// $customersApiController = new CustomersApiController();

// use Discounts\ApiControllers\ProductsApiController;
// $productsApiController = new ProductsApiController();

// use Discounts\ApiControllers\OrdersApiController;
// $ordersApiController = new OrdersApiController();


// //Api Routes
// // process the order here
// $router->post("order/process", function() use ($ordersApiController) {
    
//     $ordersApiController->processOrderAction();
// });

// //get all customers
// $router->get("customers/read", function() use ($customersApiController) {
//   $customersApiController->readAction();
// });

// //create a customer
// //json format:
// /*
//     {
//         "name": "Captain Picard",
//         "revenue": "23158.67",
//         "since": "2012-01-10"
//     }
//  */
// $router->post("customers/create", function() use ($customersApiController) {
//   $customersApiController->createAction();
// });

// //get all products
// $router->get("products/read", function() use ($productsApiController) {
//   $productsApiController->readAction();
// });

// //create a product
// //json format:
// /*
//   {
//     "id": "A108",
//     "description": "product description here",
//     "category": "1",
//     "price": "26.95"
// }
//  */

// $router->post("products/create", function() use ($productsApiController) {
//   $productsApiController->createAction();
// });


// //find a product by id
// $router->get("products/read/(\d+)", function($id) use ($productsApiController) {
//   $productsApiController->findRecordAction($id);
// });


$router->run();

