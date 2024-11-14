<?php
require_once 'config.php';

class MainModel {
    protected $db;
    private $dbError;

    //Inicia conexión con la base de datos. 
    public function __construct() {
        try {
            //Intenta realizar una nueva conexión.
            $this->db = new PDO(
                "mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS
            );
        } catch (PDOException $e) {
            $this->dbError = "Error de conexión con la base de datos: " . $e->getMessage();
        }
    }

    //Obtiene el valor $dbError, que indica si hubo o no un error de conexión con la BD.
    public function getDBError() {
        return $this->dbError;
    }

    //VEHÍCULOS.

    //Consigue todos los datos uniendo los contenidos de ambas tablas.
    public function getVehicleData() {
        if ($this->dbError) return [];
        $data = $this->db->prepare("SELECT 
        Auto.Id as AutoId, 
        Auto.Marca, 
        Auto.ModeloId, 
        Auto.Precio, 
        Modelo.Nombre
        FROM Auto JOIN Modelo ON Auto.ModeloId = Modelo.Id;");
        $data->execute();
        return $data->fetchAll();
    }

    //Consigue un array con un vehículo que tiene el id solicitado.
    public function getVehicleById($id) {
        if ($this->dbError | $id == false) return [];
        $data = $this->db->prepare("SELECT 
        Auto.Id as AutoId, 
        Auto.Marca, 
        Auto.ModeloId, 
        Auto.Kilometraje, 
        Auto.Precio, 
        Modelo.Nombre, 
        Modelo.Anio, 
        Modelo.Capacidad, 
        Modelo.Combustible
        FROM Auto JOIN Modelo ON Auto.ModeloId = Modelo.Id
        WHERE auto.Id = ?;");
        $data->execute(array($id));
        return $data->fetch(PDO::FETCH_OBJ);
    }

    //Agrega un auto a la base de datos.
    public function addVehicle($marca, $modeloId, $kilometraje, $precio) {
        $data = $this->db->prepare("INSERT INTO Auto (Marca, ModeloId, Kilometraje, Precio) VALUES (?,?,?,?);");
        $data->execute(array($marca, $modeloId, $kilometraje, $precio));
    }

    public function updateVehicle($id, $marca, $modeloId, $kilometraje, $precio) {
        $data = $this->db->prepare("UPDATE Auto SET Marca = ?, ModeloId = ?, Kilometraje = ?, Precio = ? WHERE Id = ?;");
        $data->execute(array($marca, $modeloId, $kilometraje, $precio, $id));
    }

    public function deleteVehicle($id) {
        $data = $this->db->prepare("DELETE FROM Auto WHERE Id = ?;");
        $data->execute(array($id));
    }

    public function addCategory($nombre, $anio, $capacidad, $combustible) {
        $data = $this->db->prepare("INSERT INTO modelo (nombre, anio, capacidad, combustible) VALUES (?,?,?,?);");
        $data->execute(array($nombre, $anio, $capacidad, $combustible));
    }

}
