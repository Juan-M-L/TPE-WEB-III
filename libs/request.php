<?php

class Request {
    public $body = null;
    public $params = null;
    public $query = null;

    public function __construct() {
        try {
            //Obtiene la solicitud (En JSON) enviada por el usuario y la decodifica.
            $this->body = json_decode(file_get_contents('php://input'));
        } catch (Exception $e) {
            //Si la operación falla, se asigna un valor nulo.
            $this->body = null;
        }
        // Asigna al atributo $query el array $_GET convertido en un objeto para un manejo más cómodo.
        $this->query = (object) $_GET;
    }
}