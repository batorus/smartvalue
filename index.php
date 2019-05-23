<?php
// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');

require_once "app/autoload.php";

use Bramus\Router\Router;
$router = new Router();

use Smartvalue\Database\PDOConnection;
$conn = new PDOConnection;

use Smartvalue\Models\Countries;

$countries = new Countries($conn);

//var_dump($c->findRecordById(0));

//find a record by id
 $router->get("countries/(\d+)", function(int $id) use ($countries) {
  try{ 
   var_dump($countries->findRecordById($id));
  }catch(\PDOException $e){
      echo $e->getMessage();
  }
 });
 
  $router->get("countries/(\w+)", function(string $code) use ($countries) {
  try{ 
   var_dump($countries->findRecordByCountryCode($code));
  }catch(\PDOException $e){
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

