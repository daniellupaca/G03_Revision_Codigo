<?php
include_once __DIR__ . '/../conexion.php';

class RegistroModel {
    private $conn;
    private $table_name = "tbusuario";
    private $pacientes_table = "pacientes"; // Nueva tabla de pacientes

    public function __construct() {
        $this->conn = conectarse();
    }

    public function insertUser($data) {
        $dniusuario = $data['dniusuario'];
        $nombreusuario = $data['nombreusuario'];
        $apellidousuario = $data['apellidousuario'];
        $direccionusuario = $data['direccionusuario'];
        $telefonousuario = $data['telefonousuario'];
        $fechanacimientousuario = $data['fechanacimientousuario'];
        $sexousuario = $data['sexousuario'];
        $correousuario = $data['correousuario'];
        $contrasenia = $data['contrasenia'];

        // Verificar si el usuario ya existe
        if ($this->userExists($dniusuario)) {
            echo "<script>
                window.alert('Usuario ya existe con el DNI proporcionado');
                window.location.href = '../registrousuario.php';
              </script>";
            exit();
        }

        $query = "INSERT INTO " . $this->table_name . " 
                  (dniusuario, nombres, apellidos, direccion, telefono, fechanacimiento, sexo, correo, contrasenia, fk_idrol)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 2)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssssss", $dniusuario, $nombreusuario, $apellidousuario, $direccionusuario, $telefonousuario, $fechanacimientousuario, $sexousuario, $correousuario, $contrasenia);

        if ($stmt->execute()) {
            return true;
        } else {
            return json_encode(["success" => false, "message" => "Error: " . $this->conn->error]);
        }
    }

    public function insertPaciente($data) {
        $id = $this->conn->real_escape_string($data['ID']);
        $nombres = $this->conn->real_escape_string($data['nombres']);
        $apellidos = $this->conn->real_escape_string($data['apellidos']);
        $dni = $this->conn->real_escape_string($data['dni']);
        $direccion = $this->conn->real_escape_string($data['direccion']);
        $telefono = $this->conn->real_escape_string($data['telefono']);
        $sexo = $this->conn->real_escape_string($data['sexo']);
        $fechaNacimiento = $this->conn->real_escape_string($data['fechaNacimiento']);
        $activo = $this->conn->real_escape_string($data['activo']);

        $query = "INSERT INTO " . $this->pacientes_table . " 
                  (ID, Nombres, Apellidos, DNI, Direccion, Telefono, Sexo, FechaNacimiento, Activo)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        if($stmt = $this->conn->prepare($query)){
            $stmt->bind_param("sssssssss", $id, $nombres, $apellidos, $dni, $direccion, $telefono, $sexo, $fechaNacimiento, $activo);

            if ($stmt->execute()) {
                echo "<script>
                            window.alert('Se registró correctamente su Usuario');
                            window.location.href = '../index.php';
                      </script>"; 
                    exit();
            } else {
                echo "<script>
                            window.alert('No se registró correctamente su Usuario');
                            window.location.href = '../index.php';
                      </script>"; 
                    exit();
            }

            $stmt->close();
        }else{
            echo "Error en la preparacion de la declaracion: " . $this->conn->error;
        }
    }

    private function userExists($dni) {
        $query = "SELECT dniusuario FROM " . $this->table_name . " WHERE dniusuario = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}
?>
