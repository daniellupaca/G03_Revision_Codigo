<?php
include_once __DIR__ . '../../Model/PersonalModel.php';

class PersonalController {
    private $personalModel;

    public function __construct() {
        $this->personalModel = new PersonalModel();
    }

    public function actualizarPersonal($data){
        $this->personalModel->actualizarPersonal(
            $data['dniusuario'],
            $data['direccion'],
            $data['telefono']
        );
    }
    
}

$controller = new PersonalController();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['accion']) && $_POST['accion'] === "actualizar"){
        $data = array(
            'dniusuario' => $_POST['dniusuario'],
            'direccion' => $_POST['direccion'],
            'telefono' => $_POST['telefono']
        );

        $controller->actualizarPersonal($data);
    }
}

?>
