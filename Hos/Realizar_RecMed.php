<?php
// Iniciar la sesión antes de cualquier salida
session_start();

if (!isset($_SESSION['id_medico'])) {
    echo "Por favor, inicie sesión para realizar la Receta Medica.";
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

// Consultar los pacientes
$sql_pacientes = "SELECT id_paciente, nombre, apellido FROM pacientes";
$result_pacientes = $conn->query($sql_pacientes);

// Consultar los medicamentos
$sql_medicamentos = "SELECT id_medicamento, nombre FROM medicamentos";
$result_medicamentos = $conn->query($sql_medicamentos);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Registro de Receta Médica</title>
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
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']); // Limpiar el mensaje después de mostrarlo
                }
                ?>
                
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Receta Médica</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">CAJAY</li>
                    </ol>

                    <!-- Formulario para realizar receta médica -->
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Crear Receta Médica</h3>
                                </div>
                                <div class="card-body">
                                    <form action="sp_RMedicamentos.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <label for="paciente"> </label>
                                            <select class="form-control" id="paciente" name="id_paciente" required>
                                                <option value="">Seleccione un paciente</option>
                                                <?php while ($paciente = $result_pacientes->fetch_assoc()): ?>
                                                    <option value="<?php echo $paciente['id_paciente']; ?>">
                                                        <?php echo $paciente['id_paciente'] . ' - ' . $paciente['nombre'] . ' ' . $paciente['apellido']; ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                            <label for="inputMedico">Paciente</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <label for="id_medicamento"> </label>
                                            <select class="form-control" id="id_medicamento" name="id_medicamento" required>
                                                <option value="">Seleccione un medicamento</option>
                                                <?php while ($medicamento = $result_medicamentos->fetch_assoc()): ?>
                                                    <option value="<?php echo $medicamento['id_medicamento']; ?>"><?php echo $medicamento['nombre']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                            <label for="inputMedico">Médicamento</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="number" class="form-control" id="cantidad" name="cantidad" required />
                                            <label for="inputMedico">Cantidad</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="instrucciones" name="instrucciones" rows="3" required></textarea>
                                            <label for="inputMedico">Instrucciones</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" required />
                                            <label for="inputFechaCita">Fecha de Emisión</label>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary btn-block" type="submit">Crear Receta</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="#">Ver recetas médicas existentes</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin del formulario -->
                </div>
            </main>
            <footer class="bg-light text-center text-lg-start">
                <div class="text-center p-3">
                    &copy; 2024 CAJAY.
                    <div class="d-flex justify-content-center">
                        <div>
                            <a href="#">Política de Privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>

<?php $conn->close(); // Cerrar la conexión a la base de datos ?>

