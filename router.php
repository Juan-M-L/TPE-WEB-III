<?php
require_once 'libs/router.php';

require_once 'app/controllers/controller.php';
$router = new Router();

define("DEFAULT_ROUTE_PATH", 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);

$router->addRoute(DEFAULT_ROUTE_PATH, 'GET', 'Controller', 'vehicle');

//$router->addRoute(<Endpoint>, <Tipo de solicitud HTTP>, <Controlador>, <Función del controlador>);
/*EJEMPLOS
$router->addRoute(BASE_URL                   , 'GET'    , 'MainController' , 'getAll');
$router->addRoute(BASE_URL.'/:id'            , 'GET'    , 'MainController' , 'get');
$router->addRoute(BASE_URL.'/:id'            , 'DELETE' , 'MainController' , 'delete');
$router->addRoute(BASE_URL                   , 'POST'   , 'MainController' , 'create');
$router->addRoute(BASE_URL.'/:id'            , 'PUT'    , 'MainController' , 'update');
$router->addRoute(BASE_URL.'/:id/finalizada' , 'PUT'    , 'MainController' , 'setFinalize');
*/

//Recibe y procesa la solicitud, junto al tipo de solicitud HTTP. 
//TODO: Colocar un código que genere la URL para el primer parámetro de route.
$router->route('http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
