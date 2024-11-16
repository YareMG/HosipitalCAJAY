<?php
// Iniciar la sesión antes de cualquier salida
session_start();

if (!isset($_SESSION['id_paciente'])) {
    echo "Por favor, inicie sesión para editar sus datos.";
    exit();
}

// Conexión a la base de datos (ajusta los parámetros según sea necesario)
$servername = "localhost"; // Cambia esto si es necesario
$username = "root"; // Cambia esto si es necesario
$password = "12345678"; // Cambia esto si es necesario
$dbname = "hospital"; // Cambia esto si es necesario

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener datos del paciente para mostrar en el formulario
$id_paciente = $_SESSION['id_paciente'];
$query = "SELECT * FROM pacientes WHERE id_paciente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_paciente);
$stmt->execute();
$result = $stmt->get_result();
$paciente = $result->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Editar Datos del Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="#">CAJAY</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Ajustes</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="CerrarSesion.php">Cerrar Sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">PACIENTE</div>
                        <a class="nav-link" href="Datos_paciente.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Perfil
                        </a>
                        <div class="sb-sidenav-menu-heading">Información</div>
                        <a class="nav-link" href="CitaMed.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Solicitar Cita
                        </a>
                        <a class="nav-link" href="TablaCM.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Citas Medicas
                        </a>
                        <a class="nav-link" href="Facturacion.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            Facturación
                        </a>
                        <div class="sb-sidenav-menu-heading">Clinica</div>
                        <a class="nav-link" href="HistorialMed.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Historial Médico
                        </a>
                        <a class="nav-link" href="Receta_Med.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Receta Médica
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Conectado Comó Paciente</div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Editar Datos del Paciente</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Editar Datos del Paciente</li>
                    </ol>
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Editar Datos del Paciente</h3>
                                </div>
                                <div class="card-body">
                                    <form action="sp_editarPaciente.php" method="POST">
                                        <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente']; ?>" />
                                        
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputNombre" name="nombre" type="text" value="<?php echo $paciente['nombre']; ?>" required />
                                            <label for="inputNombre">Nombre</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputApellido" name="apellido" type="text" value="<?php echo $paciente['apellido']; ?>" required />
                                            <label for="inputApellido">Apellido</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputFechaNacimiento" name="fecha_nacimiento" type="date" value="<?php echo $paciente['fecha_nacimiento']; ?>" required />
                                            <label for="inputFechaNacimiento">Fecha de Nacimiento</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputDireccion" name="direccion" type="text" value="<?php echo $paciente['direccion']; ?>" />
                                            <label for="inputDireccion">Dirección</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputTelefono" name="telefono" type="text" value="<?php echo $paciente['telefono']; ?>" />
                                            <label for="inputTelefono">Teléfono</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="email" type="email" value="<?php echo $paciente['email']; ?>" required />
                                            <label for="inputEmail">Correo Electrónico</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputGrupoSanguineo" name="grupo_sanguineo" type="text" value="<?php echo $paciente['grupo_sanguineo']; ?>" />
                                            <label for="inputGrupoSanguineo">Grupo Sanguíneo</label>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary btn-block" type="submit">Guardar Cambios</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="perfilPaci.php">Volver al perfil</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Hospital &copy; Cajay 2024</div>
                        <div>
                            <a href="#">Políticas</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
