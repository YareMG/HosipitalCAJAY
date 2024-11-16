<?php
session_start(); // Iniciamos la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_paciente'])) {
    // Si no está iniciada la sesión, redirige al login
    header("Location: accesos.php");
    exit();
}

// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '12345678', 'hospital');

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el ID del paciente desde la sesión
$id_paciente = $_SESSION['id_paciente'];

// Consultar la base de datos para obtener los datos del paciente
$sql = "SELECT * FROM pacientes WHERE id_paciente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_paciente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
    $fecha_nacimiento = $row['fecha_nacimiento'];
    $genero = $row['genero'];
    $direccion = $row['direccion'];
    $telefono = $row['telefono'];
    $email = $row['email'];
    $grupo_sanguineo = $row['grupo_sanguineo'];
    $fecha_registro = $row['fecha_registro'];
} else {
    echo "<div class='alert alert-danger'>No se encontraron datos del paciente.</div>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Perfil Paciente</title>
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
                    <h1 class="mt-4">Perfil del Paciente</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">CAJAY</li>
                    </ol>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-user me-1"></i>
                                    Información del Paciente
                                </div>
                                <div class="card-body">
                                    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
                                    <p><strong>Apellido:</strong> <?php echo htmlspecialchars($apellido); ?></p>
                                    <p><strong>Fecha de Nacimiento:</strong> <?php echo htmlspecialchars($fecha_nacimiento); ?></p>
                                    <p><strong>Género:</strong> <?php echo htmlspecialchars($genero); ?></p>
                                    <p><strong>Dirección:</strong> <?php echo htmlspecialchars($direccion); ?></p>
                                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($telefono); ?></p>
                                    <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($email); ?></p>
                                    <p><strong>Grupo Sanguíneo:</strong> <?php echo htmlspecialchars($grupo_sanguineo); ?></p>
                                    <p><strong>Fecha de Registro:</strong> <?php echo htmlspecialchars($fecha_registro); ?></p>
                                    <a href="EditarDPaciente.php?id_paciente=<?php echo $id_paciente; ?>" class="btn btn-primary">Editar Datos</a>
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
                            <a href="#">Politicas</a>
                            &middot;
                            <a href="#">Terminos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
