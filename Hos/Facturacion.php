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

// Consultar la base de datos para obtener la facturación del paciente
$sql = "SELECT f.id_factura, f.fecha_factura, f.monto_total, f.estado_pago, c.fecha_cita 
        FROM facturacion f
        JOIN citas_medicas c ON f.id_cita = c.id_cita
        WHERE f.id_paciente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_paciente);
$stmt->execute();
$result = $stmt->get_result();

$facturas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $facturas[] = $row;
    }
} else {
    echo "<div class='alert alert-danger'>No se encontró facturación para este paciente.</div>";
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
    <title>Facturación</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="Datos_paciente.php">CAJAY</a>
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
                        <a class="nav-link" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Receta Médica
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Conectado como Paciente</div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Facturación</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">CAJAY</li>
                    </ol>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-file-invoice me-1"></i>
                                    Información de Facturación
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($facturas)): ?>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID Factura</th>
                                                    <th>Fecha de Factura</th>
                                                    <th>Monto Total</th>
                                                    <th>Estado de Pago</th>
                                                    <th>Fecha de Cita</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($facturas as $factura): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($factura['id_factura']); ?></td>
                                                        <td><?php echo htmlspecialchars($factura['fecha_factura']); ?></td>
                                                        <td><?php echo htmlspecialchars($factura['monto_total']); ?></td>
                                                        <td><?php echo htmlspecialchars($factura['estado_pago']); ?></td>
                                                        <td><?php echo htmlspecialchars($factura['fecha_cita']); ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <p>No se ha registrado facturación.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="Datos_paciente.php">Regresar a la página principal</a>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
