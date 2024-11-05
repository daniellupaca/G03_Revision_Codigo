<?php
include_once __DIR__ . '../../Model/MedicoModel.php';

class MedicoController {
    private $medicoModel;

    public function __construct() {
        $this->medicoModel = new MedicoModel();
    }

    public function insertarDoctor($data) {
        $this->medicoModel->insertarDoctor($data);
    }

    public function updateDoctor($data) {
        $this->medicoModel->updateDoctor(
            $data['ID'],
            $data['Nombres'],
            $data['Apellidos'],
            $data['DNI'],
            $data['Direccion'],
            $data['Correo'],
            $data['Telefono'],
            $data['Sexo'],
            $data['NumColegiatura'],
            $data['FechaNacimiento'],
            $data['Activo']
        );
    }

    public function obtenerDetalleDoctor($id) {
        return $this->medicoModel->obtenerDetalleDoctor($id);
    }    

    //METODO DE HORARIOS

    public function horarioDoctor($data){
        $this->medicoModel->horarioDoctor($data);
    }

    public function updateHorario($data){
        $this->medicoModel->updateHorario(
            $data['ID'],
            $data['MedicoID'],
            $data['FechaAtencion'],
            $data['InicioAtencion'],
            $data['FinAtencion'],
            $data['Activo']
        );
    }

    public function obtenerDetalleHorario($id){
        return $this->medicoModel->obtenerDetalleHorario($id);
    }

}

$controller = new MedicoController();

// Manejo de la solicitud AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'getDoctorDetails') {
    $id = $_POST['id'];
    $controller = new MedicoController();
    $doctorDetails = $controller->obtenerDetalleDoctor($id);
    echo json_encode($doctorDetails);
    exit();
}else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'getHorarioDetails'){
    $id = $_POST['id'];
    $controller = new MedicoController();
    $horarioDetails = $controller->obtenerDetalleHorario($id);
    echo json_encode($horarioDetails);
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['accion']) && $_POST['accion'] === 'registrar'){
        $data = array(
            'Nombres' => $_POST['Nombres'],
            'Apellidos' => $_POST['Apellidos'],
            'DNI' => $_POST['DNI'],
            'Direccion' => $_POST['Direccion'],
            'Correo' => $_POST['Correo'],
            'Telefono' => $_POST['Telefono'],
            'Sexo' => $_POST['Sexo'],
            'NumColegiatura' => $_POST['NumColegiatura'],
            'FechaNacimiento' => $_POST['FechaNacimiento'],
            'Activo' => $_POST['Activo']
        );

        $controller->insertarDoctor($data);
    }elseif(isset($_POST['accion']) && $_POST['accion'] === 'editar'){
        $data = array(
            'ID' => $_POST['ID'],
            'Nombres' => $_POST['Nombres'],
            'Apellidos' => $_POST['Apellidos'],
            'DNI' => $_POST['DNI'],
            'Direccion' => $_POST['Direccion'],
            'Correo' => $_POST['Correo'],
            'Telefono' => $_POST['Telefono'],
            'Sexo' => $_POST['Sexo'],
            'NumColegiatura' => $_POST['NumColegiatura'],
            'FechaNacimiento' => $_POST['FechaNacimiento'],
            'Activo' => $_POST['Activo']
        );

        $controller->updateDoctor($data);
    }elseif(isset($_POST['accion']) && $_POST['accion'] === 'registrarhorario'){
        $data = array(
            'MedicoID' => $_POST['MedicoID'],
            'FechaAtencion' => $_POST['FechaAtencion'],
            'InicioAtencion' => $_POST['InicioAtencion'],
            'FinAtencion' => $_POST['FinAtencion'],
            'Activo' => $_POST['Activo']
        );

        $controller->horarioDoctor($data);
    }elseif(isset($_POST['accion']) && $_POST['accion'] === 'updatehorario'){
        $data = array(
            'ID' => $_POST['ID'],
            'MedicoID' => $_POST['MedicoID'],
            'FechaAtencion' => $_POST['FechaAtencion'],
            'InicioAtencion' => $_POST['InicioAtencion'],
            'FinAtencion' => $_POST['FinAtencion'],
            'Activo' => $_POST['Activo']
        );

        $controller->updateHorario($data);
    }
}

?>
 