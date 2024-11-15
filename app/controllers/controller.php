<?php
require_once 'app/views/json.view.php';
require_once 'app/models/model.php';

class Controller {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new MainModel();
        $this->view = new JSONView();
    }
    
    public function vehicleById($request) {
        $message = new stdClass();
        if (!is_numeric(substr($request->query->action, -1))) {
            $message->message = "No se especificó ningún número o el numero de ID ingresado no es válido";
            return $this->view->response($message, 400);
        }
        $id = substr($request->query->action, -1);
        $data = $this->model->getVehicleById($id);
        if (empty($data)) {
            return $this->view->response(new stdClass(), 204);
        }
        return $this->view->response($data);
    }

    //Añade un vehículo asociándole un modelo. Si no hay un modelo, creará uno.
    public function addVehicle($request) {
        $categories = $this->model->getAllCategories();
        $message = new stdClass();

        if (empty($request->body->marca)) {
            $message->message = 'Falta el campo Marca';
            return $this->view->response($message, 400);
        }
        if (empty($request->body->modelo)) {
            $message->message = 'Falta el campo Modelo';
            return $this->view->response($message, 400);
        }
        if (empty($request->body->kilometraje)) {
            $message->message = 'Falta el campo Kilometraje';
            return $this->view->response($message, 400);
        }
        if (empty($request->body->precio)) {
            $message->message = 'Falta el campo Precio';
            return $this->view->response($message, 400);
        }

        if ($request->body->kilometraje < 0) {
            $message->message = 'No se permiten valores negativos en el campo Kilometraje';
            return $this->view->response($message, 400);
        }
        if ($request->body->precio < 0) {
            $message->message = 'No se permiten valores negativos en el campo Precio';
            return $this->view->response($message, 400);
        }

        $marca = $request->body->marca;
        $modelo = $request->body->modelo;
        $kilometraje = $request->body->kilometraje;
        $precio = $request->body->precio;

        /*
        $this->mainModel->addVehicle($marca, $modelo, $kilometraje, $precio);
        */
    }

    //Actualiza los valores de un vehículo. No incluye los valores del modelo.
    public function update($request) {

    }
}