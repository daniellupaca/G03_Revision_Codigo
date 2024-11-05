<?php
    include_once __DIR__ . '../../conexion.php';

    class EspecialidadModel {
        private $conn;
        private $table_name = "medicos_especialidades";

        public function __construct() {
            $this->conn = conectarse();
        }

        public function insertEspecialidad($data) {
            $medicoid = $this->conn->real_escape_string($data['MedicoID']);
            $especialidadid = $this->conn->real_escape_string($data['EspecialidadID']);
            $fecha_reg = $this->conn->real_escape_string($data['FechaRegistro']);

            $query = "INSERT INTO " . $this->table_name . " 
                    (MedicoID, EspecialidadID, FechaRegistro, Activo)
                    VALUES (?, ?, ?, 1)";
            
            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("iis", $medicoid, $especialidadid, $fecha_reg);

                if ($stmt->execute()) {
                    echo "<script>
                                window.alert('Se le asigno correctamente la especialidad al Medico.');
                                window.location.href = '../Views/PersonalMedico/administrarespecialidad.php';
                        </script>"; 
                    exit();
                } else {
                    echo "<script>
                                window.alert('No se le asigno correctamente la especialidad al Medico.');
                                window.location.href = '../Views/PersonalMedico/administrarespecialidad.php';
                        </script>"; 
                    exit();
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion" . $this->conn->error;
            }
        }

        public function updateEspecialidad($idmediespe, $EspecialidadID, $FechaModificacion, $Activo) {
            $ID = $this->conn->real_escape_string($idmediespe);
            $especialidad = $this->conn->real_escape_string($EspecialidadID);
            $fecha_modi = $this->conn->real_escape_string($FechaModificacion);
            $estado = $this->conn->real_escape_string($Activo);
        
            $query = "UPDATE " . $this->table_name . " SET 
                    EspecialidadID = ?,
                    FechaModificacion = ?,
                    Activo = ?
                    WHERE ID = ?";

            if($stmt = $this->conn->prepare($query)){
                $stmt->bind_param("isii", $especialidad, $fecha_modi, $estado, $ID);
            
                if ($stmt->execute()) {
                    echo "<script>
                                window.alert('Se actualizo correctamente la especialidad al Medico.');
                                window.location.href = '../Views/PersonalMedico/administrarespecialidad.php';
                        </script>"; 
                    exit();
                } else {
                    echo "<script>
                                window.alert('No se actualizo correctamente la especialidad al Medico.');
                                window.location.href = '../Views/PersonalMedico/administrarespecialidad.php';
                        </script>"; 
                    exit();
                }

                $stmt->close();
            }else{
                echo "Error en la preparacion de la declaracion" . $this->conn->error; 
            }
        }

        public function listarEspecialidad() {
            $query = "SELECT medicos_especialidades.ID,medicos_especialidades.EspecialidadID,medicos.Nombres,medicos.Apellidos,especialidades.Nombre,especialidades.Descripcion,medicos_especialidades.FechaRegistro,medicos_especialidades.FechaModificacion,medicos_especialidades.Activo FROM medicos_especialidades
                    INNER JOIN medicos
                    ON medicos.ID = medicos_especialidades.MedicoID
                    INNER JOIN especialidades
                    ON especialidades.ID = medicos_especialidades.EspecialidadID";
            $result = $this->conn->query($query);
        
            $especialidades = array();
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $especialidades[] = $row;
                }
            }
        
            return $especialidades;
        }

        public function obtenerMedicos() {
            $query = "SELECT Nombres, Apellidos,ID FROM medicos";
            $result = $this->conn->query($query);
        
            $medicos = array();
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $medicos[] = $row;
                }
            }
        
            return $medicos;
        }

        public function obtenerEspecialidades() {
            $query = "SELECT Nombre,Descripcion,ID FROM especialidades";
            $result = $this->conn->query($query);
        
            $especialidades = array();
        
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $especialidades[] = $row;
                }
            }
        
            return $especialidades;
        }
    }
?>
