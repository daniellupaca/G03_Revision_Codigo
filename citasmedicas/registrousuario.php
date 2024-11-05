<?php 
  include_once 'conexion.php';
  $conn = conectarse();
  if (isset($_POST['dniusuario'])) {
    $dni = $_POST['dniusuario'];
    $stmt = $conn->prepare("SELECT * FROM tbusuario WHERE dniusuario = ?");
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
      echo '<span style="color: red;">El DNI está registrado.</span>';
    } else {
      echo '<span style="color: green;">El DNI está disponible.</span>';
    }
    $stmt->close();
    $conn->close();
    exit; 
  }

  // Manejar la solicitud AJAX para verificar el correo
  if (isset($_POST['correousuario'])) {
    $correo = $_POST['correousuario'];
    $stmt = $conn->prepare("SELECT * FROM tbusuario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
      echo '<span style="color: red;">El correo ya está registrado.</span>';
    } else {
      echo '<span style="color: green;">El correo está disponible.</span>';
    }
    $stmt->close();
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de usuario</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
  <style>
    .form-wrapper {
      max-width: 600px; 
    }
  </style>
</head>
<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-6 form-wrapper">
            <div class="card mb-0">
              <div class="card-body">
                <h2 class="text-center">Formulario de Registro</h2><br/>
                <form id="registerForm" method="POST" action="Controller/RegistroController.php">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="dniusuario" class="form-label">DNI:</label>
                      <input type="number" class="form-control" id="dniusuario" name="dniusuario" placeholder="Ingrese su DNI" required>
                      <div id="resultado"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="telefonousuario" class="form-label">Teléfono:</label>
                      <input type="number" class="form-control" id="telefonousuario" name="telefonousuario" placeholder="Ingrese su teléfono" required>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="nombreusuario" class="form-label">Nombres:</label>
                      <input type="text" class="form-control" id="nombreusuario" name="nombreusuario" placeholder="Ingrese sus nombres" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="apellidousuario" class="form-label">Apellidos:</label>
                      <input type="text" class="form-control" id="apellidousuario" name="apellidousuario" placeholder="Ingrese sus apellidos" required>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="direccionusuario" class="form-label">Dirección:</label>
                    <input type="text" class="form-control" id="direccionusuario" name="direccionusuario" placeholder="Ingrese su dirección" required>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                    <label for="fechanacimientousuario" class="form-label">Fecha de Nacimiento:</label>
                    <input type="date" class="form-control" id="fechanacimientousuario" name="fechanacimientousuario" required>
                    <span id="edadMessage"></span>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="sexousuario" class="form-label">Sexo:</label>
                      <select class="form-control" id="sexousuario" name="sexousuario" required>
                          <option value="">--Seleccione--</option>
                          <option value="M">Masculino</option>
                          <option value="F">Femenino</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="correousuario" class="form-label">Correo Electrónico:</label>
                      <input type="email" class="form-control" id="correousuario" name="correousuario" placeholder="Ingrese su correo" required>
                      <div id="resultadoCorreo"></div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="contrasenia" class="form-label">Contraseña</label>
                      <input type="password" class="form-control" id="contrasenia" name="contrasenia" placeholder="Ingrese una contraseña" required>
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2" onclick="openConfirmationModal()">Crear cuenta</button>
                </form>
                <center>
                  <label>Si tienes una cuenta registrada, por favor.. <a href="index.php">Iniciar Sesión</a></label>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL DE CONFORMIDAD -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Vista Previa de los Datos</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p><strong>Documento Nacional de Identidad:</strong> <span id="confirmDni"></span></p>
          <p><strong>Teléfono:</strong> <span id="confirmTelefono"></span></p>
          <p><strong>Nombres:</strong> <span id="confirmNombre"></span></p>
          <p><strong>Apellidos:</strong> <span id="confirmApellido"></span></p>
          <p><strong>Dirección:</strong> <span id="confirmDireccion"></span></p>
          <p><strong>Fecha de Nacimiento:</strong> <span id="confirmFecha"></span></p>
          <p><strong>Sexo:</strong> <span id="confirmSexo"></span></p>
          <p><strong>Correo:</strong> <span id="confirmCorreo"></span></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar Registro</button>
          <button type="button" class="btn btn-primary" onclick="submitForm()">Confirmar Registro</button>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function openConfirmationModal() {
      // Obtenemos los valores de los campos del formulario
      document.getElementById('confirmDni').innerText = document.getElementById('dniusuario').value;
      document.getElementById('confirmTelefono').innerText = document.getElementById('telefonousuario').value;
      document.getElementById('confirmNombre').innerText = document.getElementById('nombreusuario').value;
      document.getElementById('confirmApellido').innerText = document.getElementById('apellidousuario').value;
      document.getElementById('confirmDireccion').innerText = document.getElementById('direccionusuario').value;
      document.getElementById('confirmFecha').innerText = document.getElementById('fechanacimientousuario').value;
      document.getElementById('confirmSexo').innerText = document.getElementById('sexousuario').value;
      document.getElementById('confirmCorreo').innerText = document.getElementById('correousuario').value;

      // Mostramos el modal
      new bootstrap.Modal(document.getElementById('confirmationModal')).show();
    }

    function submitForm() {
      // Enviamos el formulario si el usuario confirma
      document.getElementById('registerForm').submit();
    }
  </script>
  <script>
    $(document).ready(function(){
      $('#fechanacimientousuario').on('change', function() {
        let birthDate = new Date($(this).val());
        let age = new Date().getFullYear() - birthDate.getFullYear();
        let message = '';
        let color = '';
        if (age < 18) {
          message = 'No eres mayor de edad';
          color = 'red';
        } else {
          message = 'Eres mayor de edad';
          color = 'green';
        }
        $('#edadMessage').text(message).css('color', color);
      });
    });
  </script>
  <script>
        function verificarDNI() {
            const dni = document.getElementById('dniusuario').value;
            const resultadoDiv = document.getElementById('resultado');
            const correoInput = document.getElementById('correousuario');
            const telefonoInput = document.getElementById('telefonousuario');
            const nombresInput = document.getElementById('nombreusuario');
            const apellidosInput = document.getElementById('apellidousuario');
            const direccionInput = document.getElementById('direccionusuario');
            const fechaInput = document.getElementById('fechanacimientousuario');
            const sexoInput = document.getElementById('sexousuario');
            const contraseniaInput = document.getElementById('contrasenia');


            // Verificar que se haya ingresado un DNI
            if (dni === "") {
                resultadoDiv.innerHTML = "";
                correoInput.disabled = false;
                telefonoInput.disabled = false;
                nombresInput.disabled = false;
                apellidosInput.disabled = false;
                direccionInput.disabled = false;
                fechaInput.disabled = false;
                sexoInput.disabled = false;
                contraseniaInput.disabled = false;
                return;
            }

            // Crear la solicitud AJAX
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Manejar la respuesta
            xhr.onload = function () {
                if (this.status === 200) {
                    resultadoDiv.innerHTML = this.responseText;

                    if (this.responseText.includes("El DNI está registrado.")) {
                        correoInput.disabled = true; // Bloquea el campo de correo
                        telefonoInput.disabled = true;
                        nombresInput.disabled = true;
                        apellidosInput.disabled = true;
                        direccionInput.disabled = true;
                        fechaInput.disabled = true;
                        sexoInput.disabled = true;
                        contraseniaInput.disabled = true;
                    } else {
                        correoInput.disabled = false; // Habilita el campo de correo
                        telefonousuario.disabled = false;
                        nombresInput.disabled = false;
                        apellidosInput.disabled = false;
                        direccionInput.disabled = false;
                        fechaInput.disabled = false;
                        sexoInput.disabled = false;
                        contraseniaInput.disabled = false;
                    }
                } else {
                    resultadoDiv.innerHTML = "Error al verificar el DNI.";
                }
            };

            // Enviar la solicitud
            xhr.send("dniusuario=" + dni);
        }

        function verificarCorreo() {
            const correo = document.getElementById('correousuario').value;
            const resultadoDiv = document.getElementById('resultadoCorreo');

            if (correo === "") {
                resultadoDiv.innerHTML = "";
                return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (this.status === 200) {
                    resultadoDiv.innerHTML = this.responseText;
                } else {
                    resultadoDiv.innerHTML = "Error al verificar el correo.";
                }
            };

            xhr.send("correousuario=" + correo);
        }
        window.onload = function() {
            const dniInput = document.getElementById('dniusuario');
            dniInput.addEventListener('input', verificarDNI);

            const correoInput = document.getElementById('correousuario');
            correoInput.addEventListener('input', verificarCorreo);
        };
    </script>
</body>
</html>
