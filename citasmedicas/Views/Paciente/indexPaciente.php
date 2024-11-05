<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
    header("Location: ../../index.php");
    exit();
  }

  include_once '../../conexion.php';
  $conexion = conectarse();

  $query = "SELECT tbusuario.dniusuario, tbusuario.nombres, tbusuario.apellidos, tbusuario.contrasenia, tbusuario.correo, 
            tbusuario.telefono, tbusuario.fechanacimiento,tbusuario.sexo, tbrol.nombre, tbusuario.direccion 
            FROM tbusuario
            INNER JOIN tbrol
            ON tbrol.idrol = tbusuario.fk_idrol
            WHERE tbusuario.dniusuario = ?";

  $stmt = $conexion->prepare($query);
  $stmt->bind_param("s", $_SESSION['userId']);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombreCompleto = $row['nombres'] . ' ' . $row['apellidos'];
    $nombre = $row['nombres'];
    $apellido = $row['apellidos'];
    $correo = $row['correo'];
    $rol = $row['nombre'];
    $telefono = $row['telefono'];
    $fecha_nac = $row['fechanacimiento'];
    $sexo = $row['sexo'];
    $direccion = $row['direccion'];

  } else {
    echo "Error: Usuario no encontrado";
    exit();
  }

  $stmt->close();
  $conexion->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Paciente</title>
  <link rel="shortcut icon" type="image/png" href="../../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../../assets/css/styles.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <aside class="left-sidebar">
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="indexPaciente.php" class="text-nowrap logo-img">
            <img src="../../assets/images/logos/essalud_logo.jpg" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Perfil</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="indexPaciente.php" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Informacion del paciente</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Citas Medicas</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="agendarCita.php" aria-expanded="false">
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-book-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="1" stroke="#000000" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M19 4v16h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12z" />
                  <path d="M19 16h-12a2 2 0 0 0 -2 2" />
                  <path d="M9 8h6" />
                  </svg>
                </span>
                <span class="hide-menu">Reservar cita medica</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="cronogramaPaciente.php" aria-expanded="false">
                <span>
                  <i><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-smile" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12zm12 -4v4m-8 -4v4m-4 4h16m-9.995 3h.01m3.99 0h.01" />
                  <path d="M10.005 17a3.5 3.5 0 0 0 4 0" />
                  </svg></i>
                </span>
                <span class="hide-menu">Cronograma</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="doctorpaciente.php" aria-expanded="false">
                <span>
                  <i class="ti ti-cards"></i>
                </span>
                <span class="hide-menu">Doctores</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="especialidadpaciente.php" aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Especialidades</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">IA</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="chatbot.php" aria-expanded="false">
                <span>
                  <i class="ti ti-login"></i>
                </span>
                <span class="hide-menu">Chat Bot - Medico</span>
              </a>
            </li>
            <br/>
            <center>
            <li class="sidebar-item">
              <a class="btn btn-outline-danger" href="../../index.php" aria-expanded="false">               
                <span class="hide-menu">Cerrar Sesion</span>
              </a>
            </li>
            </center>
          </ul>
        </nav>
      </div>
    </aside>
    <div class="body-wrapper">
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../../assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3"><?php echo $nombreCompleto; ?></p>
                    </a>                   
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <center>
              <h5 class="card-title fw-semibold mb-4"><strong>--Informacion del Paciente--</strong></h5>
              </center>
              <div class="card">
                <div class="card-body">
                  <form action="../../Controller/PacienteController.php" method="POST">
                  <div class="mb-3">
                    <label for="dniusuario" class="form-label">Dni del Paciente:</label>
                    <input type="number" class="form-control" id="dniusuario" name="dniusuario" value="<?php echo $_SESSION['userId']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                      <label for="nombre" class="form-label">Nombres del Paciente:</label>
                      <input type="text" class="form-control" id="nombrepac" value="<?php echo $nombre; ?>" disabled>
                    </div>
                    <div class="mb-3">
                      <label for="apellidos" class="form-label">Apellidos del Paciente:</label>
                      <input type="text" class="form-control" id="apellidospac" value="<?php echo $apellido; ?>"  disabled>
                    </div>
                    <div class="mb-3">
                        <label for="direccionusuario" class="form-label">Direccion del Paciente:</label>
                        <input type="text" class="form-control" id="direccionusuario" name="direccionusuario" value="<?php echo $direccion; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telefonousuario" class="form-label">Telefono del Paciente:</label>
                        <input type="number" class="form-control" id="telefonousuario" name="telefonousuario" value="<?php echo $telefono; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="sexo" class="form-label">Sexo del Paciente:</label>
                        <input type="text" class="form-control" id="sexopac" value="<?php echo ($sexo == 'M') ? 'Masculino' : 'Femenino'; ?>" disabled>
                    </div>
                    <div class="mb-3">
                      <label for="fechanac" class="form-label">Fecha de Nacimiento:</label>
                      <input type="date" class="form-control" id="fechapac" value="<?php echo $fecha_nac; ?>" disabled>
                    </div>
                    <center>
                      <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </center>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/js/sidebarmenu.js"></script>
  <script src="../../assets/js/app.min.js"></script>
  <script src="../../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="../../assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="../../assets/js/dashboard.js"></script>
</body>
</html>