<?php
// Iniciar la sesión antes de cualquier salida
session_start();

if (!isset($_SESSION['id_medico'])) {
    echo "Por favor, inicie sesión para editar el historial médico.";
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
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha pasado un ID de historial médico
if (!isset($_GET['id_historial'])) {
    echo "ID de historial médico no especificado.";
    exit();
}

// Obtener el ID del historial médico
$id_historial = $_GET['id_historial'];

// Consulta para obtener los datos del historial médico
$sql = "SELECT * FROM historial_medico WHERE id_historial = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_historial);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No se encontró el historial médico.";
    exit();
}

$row = $result->fetch_assoc();

// Obtener datos del paciente
$sqlPaciente = "SELECT id_paciente, nombre, apellido FROM pacientes WHERE id_paciente = ?";
$stmtPaciente = $conn->prepare($sqlPaciente);
$stmtPaciente->bind_param("i", $row['id_paciente']);
$stmtPaciente->execute();
$resultPaciente = $stmtPaciente->get_result();

if ($resultPaciente->num_rows === 0) {
    echo "No se encontró el paciente.";
    exit();
}

$paciente = $resultPaciente->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Editar Historial Médico</title>
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
                    <h1 class="mt-4">Editar Historial Médico</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Editar Historial Médico</li>
                    </ol>
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Editar Historial Médico</h3>
                                </div>
                                <div class="card-body">
                                    <form action="sp_actualizarHistorialMedico.php" method="POST">
                                        <input type="hidden" name="id_historial" value="<?php echo $row['id_historial']; ?>" />
                                        <input type="hidden" name="id_medico" value="<?php echo $_SESSION['id_medico']; ?>" />

                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="inputPaciente" name="id_paciente" disabled>
                                                <option value="<?php echo $paciente['id_paciente']; ?>">
                                                    <?php echo $paciente['id_paciente'] . ' - ' . $paciente['nombre'] . ' ' . $paciente['apellido']; ?>
                                                </option>
                                            </select>
                                            <label for="inputPaciente">Paciente</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputDiagnostico" name="diagnostico" type="text" value="<?php echo $row['diagnostico']; ?>" required />
                                            <label for="inputDiagnostico">Diagnóstico</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputTratamiento" name="tratamiento" type="text" value="<?php echo $row['tratamiento']; ?>" required />
                                            <label for="inputTratamiento">Tratamiento</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputFechaConsulta" name="fecha_consulta" type="date" value="<?php echo $row['fecha_consulta']; ?>" required />
                                            <label for="inputFechaConsulta">Fecha de Consulta</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="inputObservaciones" name="observaciones" required><?php echo $row['observaciones']; ?></textarea>
                                            <label for="inputObservaciones">Observaciones</label>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-block">Actualizar Historial Médico</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">CAJAY</div>
                        <div>
                            <a href="#!">Privacidad</a>
                            &middot;
                            <a href="#!">Términos</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybE0e4Biy/lbFshz7p6sLbe8x5A3D59bF8gLQdF5c2Zc3mMlZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-t6S2g2e3I1m6m6m6d8g8Hc1Yt1t1Ib3R+cV6lY6hD0LZ0Zo06Yj+uS4yI0g1j8yD" crossorigin="anonymous"></script>
</body>
</html>
