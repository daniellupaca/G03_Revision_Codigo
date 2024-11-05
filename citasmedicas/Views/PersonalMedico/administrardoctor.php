<?php
  session_start();

  if (!isset($_SESSION['userId'])) {
      header("Location: ../../index.php");
      exit();
  }

  include_once '../../conexion.php';
  include_once '../../Model/MedicoModel.php';
  $medicoModel = new MedicoModel();
  $doctores = $medicoModel->listarDoctores();

  $conexion = conectarse();

  $query = "SELECT tbusuario.dniusuario, tbusuario.nombres, tbusuario.apellidos, tbusuario.contrasenia, tbusuario.correo, 
            tbusuario.telefono, tbusuario.fechanacimiento, tbrol.nombre, tbusuario.direccion 
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
  } else {
      echo "Error: Usuario no encontrado";
      exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrar Doctores</title>
  <link rel="shortcut icon" type="image/png" href="../../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../../assets/css/styles.min.css" />
</head>
<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="indexPersonal.php" class="text-nowrap logo-img">
            <img src="../../assets/images/logos/essalud_logo.jpg" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Perfil</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="indexPersonal.php" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Informacion del personal</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Mantenimiento</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="administrarcitas.php" aria-expanded="false">
                <span>
                  <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Citas Médicas</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="cronogramaPersonal.php" aria-expanded="false">
              <span>
                  <i><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-smile" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12zm12 -4v4m-8 -4v4m-4 4h16m-9.995 3h.01m3.99 0h.01" />
                  <path d="M10.005 17a3.5 3.5 0 0 0 4 0" />
                  </svg></i>
                </span>
                <span class="hide-menu">Administrar Cronograma</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="administrardoctor.php" aria-expanded="false">
                <span>
                  <i class="ti ti-cards"></i>
                </span>
                <span class="hide-menu">Administrar Doctores</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="administrarespecialidad.php" aria-expanded="false">
                <span>
                  <i class="ti ti-file-description"></i>
                </span>
                <span class="hide-menu">Administrar <br/>Especialidades</span>
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
                <span class="hide-menu">Chat Bot - Médico</span>
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
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
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
                  <img src="../../assets/images/profile/user-1.jpg" alt="" width="40" height="40" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3"><?php echo $nombreCompleto ?></p>
                    </a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <center>
              <h5 class="card-title fw-semibold mb-4"><strong>--Registrar Doctor--</strong></h5>
              </center>
              <div class="card">
                <div class="card-body">
                <form action="../../Controller/MedicoController.php" method="POST">
                    <div class="mb-3">
                        <label for="Nombres" class="form-label">Nombres Completos:</label>
                        <input type="text" class="form-control" id="nombNombresres" name="Nombres" placeholder="Ingrese los nombres completos" required>
                    </div>
                    <div class="mb-3">
                        <label for="Apellidos" class="form-label">Apellidos Completos:</label>
                        <input type="text" class="form-control" id="Apellidos" name="Apellidos" placeholder="Ingrese los apellidos completos" required>
                    </div>
                    <div class="mb-3">
                        <label for="DNI" class="form-label">Documento de Identidad (DNI):</label>
                        <input type="number" class="form-control" id="DNI" name="DNI" placeholder="Ingrese el DNI del doctor" required>
                    </div>
                    <div class="mb-3">
                        <label for="Direccion" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="Direccion" name="Direccion" placeholder="Ingrese la dirección" required>
                    </div>
                    <div class="mb-3">
                        <label for="Correo" class="form-label">Correo Electronico:</label>
                        <input type="email" class="form-control" id="Correo" name="Correo" placeholder="Ingrese el correo electronico" required>
                    </div>
                    <div class="mb-3">
                        <label for="Telefono" class="form-label">Telefono:</label>
                        <input type="number" class="form-control" id="Telefono" name="Telefono" placeholder="Ingrese el telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="Sexo" class="form-label">Sexo:</label>
                        <select class="form-control" id="Sexo" name="Sexo" required>
                            <option value="">--Selecciona un Genero--</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="NumColegiatura" class="form-label">Numero de Colegiatura:</label>
                        <input type="text" class="form-control" id="NumColegiatura" name="NumColegiatura" placeholder="Ingrese el numero de colegiatura del doctor" required>
                    </div>
                    <div class="mb-3">
                        <label for="FechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control" id="FechaNacimiento" name="FechaNacimiento" required>
                    </div>
                    <div class="mb-3">
                        <label for="Activo" class="form-label">Estado:</label>
                        <select class="form-control" id="Activo" name="Activo" required>
                            <option value="">--Selecciona un Estado--</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <input type="hidden" name="accion" value="registrar">
                    <center>
                        <button type="submit" class="btn btn-primary text-center">Registrar Doctor</button>
                    </center>
                </form>                  
                </div>
                <div class="card-body">
                  <center>
                  <h5 class="card-title fw-semibold mb-4"><strong>--Lista de Doctores--</strong></h5>
                  </center>
                  <div class="col-lg-12 d-flex align-items-stretch">
                        <div class="card w-100">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">DNI</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Medico</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Direccion</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Correo</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Telefono</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Estado</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Acciones</h6>
                                    </th>                                
                                </tr>
                                </thead>
                                <tbody>
                                   <?php foreach($doctores as $doctor): ?>
                                      <tr>
                                        <td><?php echo $doctor['DNI'] ?></td>
                                        <td><?php echo $doctor['Nombres'] ?> <?php echo $doctor['Apellidos'] ?></td>
                                        <td><?php echo $doctor['Direccion'] ?></td>
                                        <td><?php echo $doctor['Correo'] ?></td>
                                        <td><?php echo $doctor['Telefono'] ?></td>
                                        <td>
                                            <?php 
                                                if ($doctor['Activo'] == 1) {
                                                    echo 'Activo';
                                                } else {
                                                    echo 'Inactivo';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                          <button class="btn btn-secondary detalle-button" data-doctor='<?php echo json_encode($doctor); ?>'>Editar Informacion</button>
                                        </td>
                                      </tr>
                                   <?php endforeach; ?>         
                                </tbody>
                            </table>
                            </div>
                        </div>
                        </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>      
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="detalleDoctor" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editDoctorModalLabel">Editar Doctor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <form id="editDoctorForm" method="POST" action="../../Controller/MedicoController.php">
          <div class="modal-body">
            <input type="text" id="ID" name="ID" class="form-control" style="display: none;">
            <div class="mb-3">
              <label for="Nombres" class="form-label">Nombres Completos:</label>
              <input type="text" class="form-control" id="Nombres" name="Nombres" require>
            </div>
            <div class="mb-3">
              <label for="Apellidos" class="form-label">Apellidos Completos:</label>
              <input type="text" class="form-control" id="modalApellidos" name="Apellidos" require>
            </div>
            <div class="mb-3">
              <label for="DNI" class="form-label">Documento Nacional de Identidad:</label>
              <input type="number" class="form-control" id="modalDNI" name="DNI" require>
            </div>
            <div class="mb-3">
              <label for="Direccion" class="form-label">Dirección:</label>
              <input type="text" class="form-control" id="modalDireccion" name="Direccion" require>
            </div>
            <div class="mb-3">
              <label for="Correo" class="form-label">Correo Electronico:</label>
              <input type="email" class="form-control" id="modalCorreo" name="Correo" require>
            </div>
            <div class="mb-3">
              <label for="Telefono" class="form-label">Telefono:</label>
              <input type="number" class="form-control" id="modalTelefono" name="Telefono" require>
            </div>
            <div class="mb-3">
              <label for="Sexo" class="form-label">Sexo:</label>
              <select class="form-control" id="modalSexo" name="Sexo">
                <option value="">--Selecciona un Genero--</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="NumColegiatura" class="form-label">Numero de Colegiatura:</label>
              <input type="text" class="form-control" id="modalNumColegiatura" name="NumColegiatura" require>
            </div>
            <div class="mb-3">
              <label for="FechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
              <input type="date" class="form-control" id="modalFechaNacimiento" name="FechaNacimiento" require>
            </div>
            <div class="mb-3">
              <label for="Activo" class="form-label">Estado:</label>
              <select class="form-control" id="modalActivo" name="Activo">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
            <input type="hidden" name="accion" value="editar">
            <center>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </center>
          </form>
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

  
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const detalleButtons = document.querySelectorAll(".detalle-button");

        detalleButtons.forEach(button => {
            button.addEventListener("click", function() {
                const doctor = JSON.parse(this.getAttribute("data-doctor"));

                document.getElementById("ID").value = doctor.ID;                
                document.getElementById("Nombres").value = doctor.Nombres;
                document.getElementById("modalApellidos").value = doctor.Apellidos;
                document.getElementById("modalDNI").value = doctor.DNI;
                document.getElementById("modalDireccion").value = doctor.Direccion;
                document.getElementById("modalCorreo").value = doctor.Correo;
                document.getElementById("modalTelefono").value = doctor.Telefono;
                document.getElementById("modalSexo").value = doctor.Sexo;
                document.getElementById("modalNumColegiatura").value = doctor.NumColegiatura;
                document.getElementById("modalFechaNacimiento").value = doctor.FechaNacimiento;
                document.getElementById("modalActivo").value = doctor.Activo;

                const detalledoctorModal = new bootstrap.Modal(document.getElementById("detalleDoctor"));
                detalledoctorModal.show();
            });
        });
    });
</script>
</body>
</html>
