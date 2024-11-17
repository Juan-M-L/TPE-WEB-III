<?php
require_once 'libs/router.php';

require_once 'app/controllers/vehicle.controller.php';
require_once 'app/controllers/model.controller.php';
$router = new Router();

$router->addRoute('vehicle',     'GET',  'VehicleController', 'allVehicles');
$router->addRoute('vehicle/:id', 'GET',  'VehicleController', 'vehicleById');
$router->addRoute('vehicle',     'POST', 'VehicleController', 'addVehicle');
$router->addRoute('model',       'POST', 'ModelController',   'addModel');

$router->setDefaultRoute('VehicleController', 'returnNotFound');

//Recibe y procesa la solicitud, junto al tipo de solicitud HTTP. 
$router->route($_GET['action'], $_SERVER['REQUEST_METHOD']);
