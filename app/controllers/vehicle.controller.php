<?php
require_once 'app/views/json.view.php';
require_once 'app/models/model.php';

class VehicleController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new MainModel();
        $this->view = new JSONView();
    }
    
    public function allVehicles() {
        $data = $this->model->getVehicleData();
        if (empty($data)) {
            return $this->view->response($data, 204);
        }
        return $this->view->response($data, 200);
    }

    //Obtiene un vehículo por su ID.
    public function vehicleById($request) {
        $id = $request->params->id;
        $message = new stdClass();
        
        //Verifica que no haya caracteres que no son dígitos.
        foreach (str_split($id) as $char) {
            //Si encuentra un caracter que no es dígito, retorna error 400.
            if (!ctype_digit($char)) {
                $message->message = 'El parámetro id sólo acepta números enteros.';
                return $this->view->response($message, 400);    
            }
        }

        $data = $this->model->getVehicleById($id);
        if (empty($data)) {
            return $this->view->response($data, 204);
        }
        return $this->view->response($data, 200);
    }

    //Añade un vehículo, asociándole un modelo. Si el modelo especificado no existe, tirará error.
    public function addVehicle($request) {
        $message = new stdClass();

        //Verifica que todos los campos estén completos.
        if (!isset($request->body->marca)) {
            $message->message = 'Falta el campo marca';
            return $this->view->response($message, 400);
        }
        if (!isset($request->body->modelo)) {
            $message->message = 'Falta el campo modelo';
            return $this->view->response($message, 400);
        }
        if (!isset($request->body->kilometraje)) {
            $message->message = 'Falta el campo kilometraje';
            return $this->view->response($message, 400);
        }
        if (!isset($request->body->precio)) {
            $message->message = 'Falta el campo precio';
            return $this->view->response($message, 400);
        }

        //Verifica que no se haya ingresado un string en kilometraje y/o precio.
        if (!is_int($request->body->kilometraje)) {
            $message->message = 'El campo kilometraje sólo acepta el 0 (cero) y números enteros positivos';
            return $this->view->response($message, 400);
        }
        if (!is_numeric($request->body->precio)) {
            $message->message = 'El campo precio sólo acepta números enteros o de coma flotante positivos';
            return $this->view->response($message, 400);
        }

        //Verifica que no haya valores negativos presentes en kilometraje y precio.
        if ($request->body->kilometraje < 0) {
            $message->message = 'No se permiten valores negativos en el campo kilometraje';
            return $this->view->response($message, 400);
        }
        if ($request->body->precio < 0) {
            $message->message = 'No se permiten valores negativos en el campo precio';
            return $this->view->response($message, 400);
        }

        //Asigna los valores del request a variables.
        $marca = $request->body->marca;
        $modelo = $request->body->modelo;
        $kilometraje = $request->body->kilometraje;
        $precio = $request->body->precio;

        //Verifica que el modelo especificado esté presente en la base de datos.
        $categories = $this->model->getAllCategories();
        foreach ($categories as $category) {
            if (strtolower($modelo) == strtolower($category->Nombre)) {
                $modelo = $category->Id;
                $this->model->addVehicle($marca, $modelo, $kilometraje, $precio);
                $message->message = 'Vehículo agregado'; 
                return $this->view->response($message, 201);
            }
        }
        $message->message = 'No se puede agregar el vehículo; El modelo especificado ('.$modelo.') no existe.'; 
        return $this->view->response($message, 400);
    }

    public function returnNotFound() {
        $message = new stdClass();
        $message->message = 'No encontrado';
        return $this->view->response($message, 404);
    }
}