<?php

require_once './libs/request.php';
require_once './libs/response.php';

class Route {
    private $url;
    private $verb;
    private $controller;
    private $method;
    private $params;

    public function __construct($url, $verb, $controller, $method) {
        $this->url = $url;
        $this->verb = $verb;
        $this->controller = $controller;
        $this->method = $method;
        $this->params = [];
    }

    // Verifica que la URL y el verbo HTTP coincidan con la ruta.
    public function match($url, $verb) {
        if($this->verb != $verb){
            return false;
        }
        $partsURL = explode("/", trim($url,'/'));
        $partsRoute = explode("/", trim($this->url,'/'));
        if(count($partsRoute) != count($partsURL)) {
            return false;
        }
        foreach ($partsRoute as $key => $part) {
            if (strlen($part) == 0 || $part[0] != ":") {
                if($part != $partsURL[$key])
                return false;
            } //es un parametro
            else
            $this->params[''.substr($part,1)] = $partsURL[$key];
        }
        return true;
    }

    // Ejecuta la ruta creando una instancia de un controlador y usándola para ejecutar el método que dicho controlador posee.
    public function run($request, $response) {
        $controller = $this->controller;  
        $method = $this->method;
        $request->params = (object) $this->params;
       
        (new $controller())->$method($request, $response);
    }
}

class Router {
    private $routeTable = [];
    private $defaultRoute;
    private $request;
    private $response;

    public function __construct() {
        $this->defaultRoute = null; // Se le asigna ruta por defecto con setDefaultRoute.
        $this->request = new Request();
        $this->response = new Response();
    }

    public function route($url, $verb) {
        //Busca en la tabla de ruteo una url y verbo que coincidan con la ruta especificada.
        foreach ($this->routeTable as $route) {
            //Si la url y el verbo coinciden con una ruta, ejecuta el controlador que corresponde.
            if($route->match($url, $verb)) {
                $route->run($this->request, $this->response);
                return;
            }
        }
        //Si ninguna ruta coincide con el pedido y se configuró ruta por defecto, se ejecuta esa ruta.
        if ($this->defaultRoute != null) {
            $this->defaultRoute->run($this->request, $this->response);
        }
    }
    
    public function addRoute ($url, $verb, $controller, $method) {
        $this->routeTable[] = new Route($url, $verb, $controller, $method);
    }

    public function setDefaultRoute($controller, $method) {
        $this->defaultRoute = new Route("", "", $controller, $method);
    }
}
