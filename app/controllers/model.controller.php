<?php
require_once 'app/views/json.view.php';
require_once 'app/models/model.php';

class ModelController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new MainModel();
        $this->view = new JSONView();
    }

    public function addModel($request) {
        $message = new stdClass();

        //Verifica que todos los campos estén completos.
        if (!isset($request->body->nombre)) {
            $message->message = 'Falta el campo nombre.';
            return $this->view->response($message, 400);
        }
        if (!isset($request->body->anio)) {
            $message->message = 'Falta el campo anio.';
            return $this->view->response($message, 400);
        }
        if (!isset($request->body->capacidad)) {
            $message->message = 'Falta el campo capacidad.';
            return $this->view->response($message, 400);
        }
        if (!isset($request->body->combustible)) {
            $message->message = 'Falta el campo combustible.';
            return $this->view->response($message, 400);
        }
        
        //Verifica que no se haya ingresado un string o float en anio y capacidad.
        if (!is_int($request->body->anio)) {
            $message->message = 'El campo anio sólo acepta números enteros';
            return $this->view->response($message, 400);
        }
        if (!is_int($request->body->capacidad)) {
            $message->message = 'El campo capacidad sólo acepta números enteros';
            return $this->view->response($message, 400);
        }

        //Verifica que no haya números extraños en anio, y que no haya números inferiores a 1 en capacidad.
        if ($request->body->anio > getdate()["year"] || $request->body->anio < 1900) {
            $message->message = 'El campo anio no acepta valores superiores a '.getdate()["year"].' o inferiores a 1900.';
            return $this->view->response($message, 400);
        }
        if ($request->body->capacidad < 1) {
            $message->message = 'No se permiten valores menores a 1 en el campo capacidad.';
            return $this->view->response($message, 400);
        }

        $nombre = $request->body->nombre;
        $anio = $request->body->anio;
        $capacidad = $request->body->capacidad;
        $combustible = $request->body->combustible;

        //Verifica que el modelo no esté ya presente en la base de datos.
        $categories = $this->model->getAllCategories();
        foreach ($categories as $category) {
            if (strtolower($nombre) == strtolower($category->Nombre)) {
                $message->message = 'El modelo especificado ('.$nombre.') ya existe.'; 
                return $this->view->response($message, 400);
            }
        }
        $this->model->addCategory($nombre, $anio, $capacidad, $combustible);
        $message->message = 'Modelo agregado';
        return $this->view->response($message, 201);
    }
}