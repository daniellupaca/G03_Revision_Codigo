<?php
include_once __DIR__ . '../../conexion.php';

class MedicoModel {
    private $conn;
    private $table_name = "medicos";

    public function __construct() {
        $this->conn = conectarse();
    }

    public function insertarDoctor($data) {
        $nombre = $this->conn->real_escape_string($data['Nombres']);
        $apellido = $this->conn->real_escape_string($data['Apellidos']);
        $DNI = $this->conn->real_escape_string($data['DNI']);
        $direccion = $this->conn->real_escape_string($data['Direccion']);
        $correo = $this->conn->real_escape_string($data['Correo']);
        $telefono = $this->conn->real_escape_string($data['Telefono']);
        $sexo = $this->conn->real_escape_string($data['Sexo']);
        $numColegiatura = $this->conn->real_escape_string($data['NumColegiatura']);
        $fecha_nac = $this->conn->real_escape_string($data['FechaNacimiento']);
        $estado = $this->conn->real_escape_string($data['Activo']);
    
        $query = "INSERT INTO $this->table_name (Nombres, Apellidos, DNI, Direccion, Correo, Telefono, Sexo, NumColegiatura, FechaNacimiento, Activo)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("sssssssssi", $nombre, $apellido, $DNI, $direccion, $correo, $telefono, $sexo, $numColegiatura, $fecha_nac, $estado);
    
            if($stmt->execute()){
                echo "<script>
                        window.alert('Se registró correctamente el doctor.');
                        window.location.href = '../Views/PersonalMedico/administrardoctor.php';
                      </script>";
                exit();
            } else {
                echo "<script>
                        window.alert('Error al registrar el doctor. Verifique los datos ingresados: " . $stmt->error . "');
                        window.location.href = '../Views/PersonalMedico/administrardoctor.php';
                     </script>";
            }
    
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $this->conn->error;
        }
    }
    

    public function obtenerDetalleDoctor($ID) {
        $ID = $this->conn->real_escape_string($ID);
        $query = "SELECT medicos.ID, medicos.Nombres, medicos.Apellidos, medicos.Direccion,
                  medicos.Correo, medicos.Telefono, medicos.Sexo, medicos.NumColegiatura, medicos.FechaNacimiento, medicos.Activo
                  FROM $this->table_name 
                  WHERE medicos.ID = '$ID'";
        
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function updateDoctor($idmedico, $nombre, $apellido, $DNI, $direccion, $correo,$telefono,$sexo,$numColegiatura,$fecha_nac,$estado ) {
        $idmedico = $this->conn->real_escape_string($idmedico);
        $nombre = $this->conn->real_escape_string($nombre);
        $apellido = $this->conn->real_escape_string($apellido);
        $DNI = $this->conn->real_escape_string($DNI);
        $direccion = $this->conn->real_escape_string($direccion);
        $correo = $this->conn->real_escape_string($correo);
        $telefono = $this->conn->real_escape_string($telefono);
        $sexo = $this->conn->real_escape_string($sexo);
        $numColegiatura = $this->conn->real_escape_string($numColegiatura);
        $fecha_nac = $this->conn->real_escape_string($fecha_nac);
        $estado = $this->conn->real_escape_string($estado);

        $query = "UPDATE medicos SET Nombres = ?, Apellidos = ?, DNI = ?, Direccion = ?, Correo = ?, Telefono = ?, Sexo = ?, NumColegiatura = ?, FechaNacimiento = ?, Activo = ?
                  WHERE ID = ?";
        
        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("ssississsii", $nombre, $apellido, $DNI, $direccion, $correo, $telefono, $sexo, $numColegiatura, $fecha_nac, $estado, $idmedico);

            if($stmt->execute()){
                echo "<script>
                        window.alert('Se actualizo correctamente la información del Medico.');
                        window.location.href = '../Views/PersonalMedico/administrardoctor.php';
                      </script>";
            }else{
                echo "<script>
                        window.alert('No se actualizo correctamente la información del Medico.');
                        window.location.href = '../Views/PersonalMedico/administrardoctor.php';
                      </script>";
            }

            $stmt->close();
        }else{
            echo "Error en la actualizacion del Medico" . $this->conn->error;
        }        
    }

    public function listarDoctores() {
        $query = "SELECT ID, Nombres, Apellidos, DNI, Direccion, Correo, Telefono, Sexo, NumColegiatura, FechaNacimiento, Activo 
                  FROM $this->table_name";
        
        $result = $this->conn->query($query);
        $doctores = array();

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $doctores[] = $row;
            }
        }

        return $doctores;
    }

    //METODO DE HORARIO

    public function horarioDoctor($data){
        $MedicoID = $this->conn->real_escape_string($data['MedicoID']);
        $FechaAtencion = $this->conn->real_escape_string($data['FechaAtencion']);
        $InicioAtencion = $this->conn->real_escape_string($data['InicioAtencion']);
        $FinAtencion = $this->conn->real_escape_string($data['FinAtencion']);
        $Activo = $this->conn->real_escape_string($data['Activo']);

        $query = "INSERT INTO horarios (MedicoID,FechaAtencion,InicioAtencion,FinAtencion,Activo) VALUES('$MedicoID','$FechaAtencion','$InicioAtencion','$FinAtencion',1)";

        if ($this->conn->query($query) === TRUE) {
            echo "<script>
                    window.alert('Horario registrado correctamente.');
                    window.location.href = '../Views/PersonalMedico/cronogramaPersonal.php';
                </script>";
        } else {
            echo "<script>
                    window.alert('Error al registrar el doctor. Verifique los datos ingresados');
                    window.location.href = '../Views/PersonalMedico/cronogramaPersonal.php';
                </script>";
        }
    }

    public function updateHorario($idhorario, $MedicoID, $FechaAtencion, $InicioAtencion, $FinAtencion, $estado) {
        $idhorario = $this->conn->real_escape_string($idhorario);
        $MedicoID = $this->conn->real_escape_string($MedicoID);
        $FechaAtencion = $this->conn->real_escape_string($FechaAtencion);
        $InicioAtencion = $this->conn->real_escape_string($InicioAtencion);
        $FinAtencion = $this->conn->real_escape_string($FinAtencion);
        $estado = $this->conn->real_escape_string($estado);

        $query = "UPDATE horarios SET MedicoID = ?, FechaAtencion = ?, InicioAtencion = ?, FinAtencion = ?, Activo = ? WHERE idhorario = ?";
    
        if ($stmt = $this->conn->prepare($query)) {
            $stmt->bind_param("isssii", $MedicoID, $FechaAtencion, $InicioAtencion, $FinAtencion, $estado, $idhorario);
    
            if ($stmt->execute()) {
                echo "<script>
                        window.alert('Horario actualizado correctamente.');
                        window.location.href = '../Views/PersonalMedico/cronogramaPersonal.php';
                    </script>";
                return true;
            } else {
                echo "<script>
                    window.alert('Horario no se actualizo correctamente.');
                    window.location.href = '../Views/PersonalMedico/cronogramaPersonal.php';
                </script>";
            }
    
            $stmt->close();
        } else {
            echo "Error al preparar la consulta de actualizacion del horario: " . $this->conn->error;
            return false;
        }
    }
    
    

    public function listarHorarios() {
        $query = "SELECT horarios.idhorario,horarios.MedicoID,medicos.ID,medicos.Nombres, medicos.Apellidos, horarios.FechaAtencion, horarios.InicioAtencion,horarios.FinAtencion, horarios.Activo 
                  FROM horarios
                  INNER JOIN medicos
                  ON medicos.ID = horarios.MedicoID";
        $result = $this->conn->query($query);
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    public function obtenerDetalleHorario($ID) {
        $ID = $this->conn->real_escape_string($ID);
        $query = "SELECT horarios.idhorario as HorarioID, medicos.Nombres,medicos.Apellidos,horarios.MedicoID, horarios.FechaAtencion, horarios.InicioAtencion, horarios.FinAtencion,horarios.Activo
                  FROM horarios
                  INNER JOIN medicos
                  ON medicos.ID = horarios.MedicoID 
                  WHERE horarios.MedicoID = '$ID'";
        
        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }
}
?>
