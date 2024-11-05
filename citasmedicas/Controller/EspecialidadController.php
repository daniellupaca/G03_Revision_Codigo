<?php
    include_once __DIR__ . '/../Model/EspecialidadModel.php';

    class EspecialidadController{
        private $especialidadModel;

        public function __construct()
        {
            $this->especialidadModel = new EspecialidadModel();
        }

        //ADMINISTRADOR
        public function insertEspecialidad($data){
            $this->especialidadModel->insertEspecialidad($data);
        }

        public function updateEspecialidad($data){
            $this->especialidadModel->updateEspecialidad(
                $data['ID'],
                $data['EspecialidadID'],
                $data['FechaModificacion'],
                $data['Activo']
            );
        }
    }

    $controller = new EspecialidadController();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['accion']) && $_POST['accion'] === 'registrar'){
            $data = array(
                'MedicoID' => $_POST['MedicoID'],
                'EspecialidadID' => $_POST['EspecialidadID'],
                'FechaRegistro' => $_POST['FechaRegistro']
            );

            $controller->insertEspecialidad($data);
        }elseif(isset($_POST['accion']) && $_POST['accion'] === 'editar'){
            $data = array(
                'ID' => $_POST['ID'],
                'EspecialidadID' => $_POST['EspecialidadID'],
                'FechaModificacion' => $_POST['FechaModificacion'],
                'Activo' => $_POST['Activo']
            );

            $controller->updateEspecialidad($data);
        }
    }


?>
