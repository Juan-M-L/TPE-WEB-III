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
    
    public function vehicle($request) {
        if (!is_numeric(substr($request->query->action, -1))) {
            return $this->view->response(new stdClass(), 400);
        }
        $id = substr($request->query->action, -1);
        $data = $this->model->getVehicleById($id);
        if (empty($data)) {
            return $this->view->response(new stdClass(), 204);
        }
        return $this->view->response($data);
    }

    //Añade un vehículo asociándole un modelo. Si no hay un modelo, creará uno.
    public function add($request) {
    
    }
}