<?php
session_start(); // Asegúrate de iniciar la sesión para acceder a los datos del paciente

// Verificar si se recibió el id_cita
if (isset($_GET['id_cita'])) {
    $id_cita = $_GET['id_cita'];

    // Conectar a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "hospital";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para obtener los datos de la cita
    $query = "SELECT c.id_cita, c.fecha_cita, c.estado_cita, p.id_paciente 
              FROM citas_medicas c 
              JOIN pacientes p ON c.id_paciente = p.id_paciente 
              WHERE c.id_cita = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_cita);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fecha_cita = $row['fecha_cita'];
        $estado_cita = $row['estado_cita'];
        $id_paciente = $row['id_paciente'];
    } else {
        die("No se encontró la cita médica.");
    }

    $stmt->close();
    $conn->close();
} else {
    die("ID de cita no proporcionado.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Editar Cita Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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
                        <div class="sb-sidenav-menu-heading">MEDICO</div>
                        <a class="nav-link" href="perfilMed.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Perfil
                        </a>
                        <div class="sb-sidenav-menu-heading">Información</div>
                        <a class="nav-link" href="Medico-Pacientes.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-injured"></i></div>
                            Pacientes
                        </a>
                        <a class="nav-link" href="Citas_pro.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Citas Programadas
                        </a>
                        <a class="nav-link" href="Realizar_RecMed.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Realizar Receta Medica
                        </a>
                        <a class="nav-link" href="medicamentosP.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-pills"></i></div>
                            Medicamentos
                        </a>
                        <a class="nav-link" href="FacturaMed.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                            Facturación
                        </a>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-folder"></i></div>
                                Datos Medicos
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="expediente.php">Expedientes</a>
                                    <a class="nav-link" href="HistorialPaci.php">Historial</a>
                                </nav>
                            </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small"></div>
                </div>
            </nav>
        </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">HOSPITAL</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">CAJAY</li>
                </ol>
                <!-- Formulario de Edición de Cita Médica -->
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header">
                                <h3 class="text-center font-weight-light my-4">Editar Cita Médica</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="actualizar_cita.php"> <!-- Cambia el action a tu archivo de actualización -->
                                    <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($id_cita); ?>" />
                                    <input type="hidden" name="id_paciente" value="<?php echo htmlspecialchars($id_paciente); ?>" required readonly />
                                    
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="fecha_cita" name="fecha_cita" type="datetime-local" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($fecha_cita))); ?>" required />
                                        <label for="fecha_cita">Fecha y Hora de la Cita</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select class="form-control" id="estado_cita" name="estado_cita" required>
                                            <option value="Programada" <?php if ($estado_cita == 'Programada') echo 'selected'; ?>>Programada</option>
                                            <option value="Realizada" <?php if ($estado_cita == 'Realizada') echo 'selected'; ?>>Realizada</option>
                                            <option value="Cancelada" <?php if ($estado_cita == 'Cancelada') echo 'selected'; ?>>Cancelada</option>
                                        </select>
                                        <label for="estado_cita">Estado de la Cita</label>
                                    </div>

                                    <div class="mt-4 mb-0">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-block" type="submit">Guardar Cambios</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="Citas_pro.php">Ver citas médicas existentes</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin del formulario -->
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
