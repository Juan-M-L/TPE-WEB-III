<?php
require_once 'libs/router.php';

require_once 'app/controllers/controller.php';
$router = new Router();

$router->addRoute('vehicle/:id', 'GET',  'Controller', 'vehicleById');
$router->addRoute('vehicle', 'POST', 'Controller', 'addVehicle');

//$router->addRoute(<Endpoint>, <Tipo de solicitud HTTP>, <Controlador>, <Función del controlador>);
/*EJEMPLOS
$router->addRoute(vehicle                   , 'GET'    , 'MainController' , 'getAll');
$router->addRoute(vehicle.'/:id'            , 'GET'    , 'MainController' , 'get');
$router->addRoute(vehicle.'/:id'            , 'DELETE' , 'MainController' , 'delete');
$router->addRoute(vehicle                   , 'POST'   , 'MainController' , 'create');
$router->addRoute(vehicle.'/:id'            , 'PUT'    , 'MainController' , 'update');
$router->addRoute(vehicle.'/:id/finalizada' , 'PUT'    , 'MainController' , 'setFinalize');
*/

//Recibe y procesa la solicitud, junto al tipo de solicitud HTTP. 
$router->route($_GET['action'], $_SERVER['REQUEST_METHOD']);
