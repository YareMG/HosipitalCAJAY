<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Registro de Cita Médica</title>
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
                            Facturacion
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
                    <div class="small">Conectado Como Paciente.</div>
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
                    <!-- Formulario de Registro de Cita Médica -->
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Registro de Cita Médica</h3>
                                </div>
                                <div class="card-body">
                                <form action="sp_CitaMed.php" method="POST">
    <input type="hidden" name="id_paciente" value="<?php echo $_SESSION['id_paciente']; ?>" />
    
    <div class="form-floating mb-3">
    <select class="form-control" id="inputMedico" name="id_medico" required>
        <option value="" disabled selected>Selecciona un Médico</option>
        <?php
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

        // Consulta para obtener médicos
        $query = "SELECT id_medico, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM medicos";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id_medico'] . "'>" . $row['nombre_completo'] . "</option>";
            }
        } else {
            echo "<option value=''>No hay médicos disponibles</option>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </select>
    <label for="inputMedico">Médico</label>
</div>


    <div class="form-floating mb-3">
        <input class="form-control" id="inputFechaCita" name="fecha_cita" type="datetime-local" required />
        <label for="inputFechaCita">Fecha y Hora de la Cita</label>
    </div>

    <div class="form-floating mb-3">
        <textarea class="form-control" id="inputMotivo" name="motivo" placeholder="Describe el motivo de la cita" required></textarea>
        <label for="inputMotivo">Motivo de la Cita</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-control" id="inputEstadoCita" name="estado_cita" required>
            <option value="Programada">Programada</option>
            <option value="Realizada">Realizada</option>
            <option value="Cancelada">Cancelada</option>
        </select>
        <label for="inputEstadoCita">Estado de la Cita</label>
    </div>

    <div class="mt-4 mb-0">
        <div class="d-grid">
            <button class="btn btn-primary btn-block" type="submit">Registrar Cita</button>
        </div>
    </div>
</form>

                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="TablaCM.php">Ver citas médicas existentes</a></div>
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
