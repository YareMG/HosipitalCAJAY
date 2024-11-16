<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Generar un ID de historial para el nuevo expediente
$id_historial = ""; // Puedes establecer lógica aquí para generar un ID adecuado

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Registro de Expediente</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <!-- Menú de navegación superior -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="#">CAJAY</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown"><i class="fas fa-user fa-fw"></i></a>
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false">
                            <div class="sb-nav-link-icon"><i class="fas fa-folder"></i></div>
                            Datos Medicos
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="expediente.php">Expedientes</a>
                                <a class="nav-link" href="HistorialPaci.php">Historial</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">© 2024 Hospital</div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Registro de Expediente</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Registrar un nuevo expediente</li>
                    </ol>

                    <!-- Formulario de Registro de Expediente -->
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Datos del Expediente</h3>
                                </div>
                                <div class="card-body">
                                    <form action="sp_expedienteNew.php" method="POST">
                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="inputPaciente" name="id_paciente" required>
                                                <option value="" disabled selected>Selecciona un Paciente</option>
                                                <?php
                                                $query = "SELECT id_paciente, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM pacientes";
                                                $result = $conn->query($query);

                                                if ($result && $result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['id_paciente'] . "'>" . $row['nombre_completo'] . "</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>No hay pacientes disponibles</option>";
                                                }
                                                ?>
                                            </select>
                                            <label for="inputPaciente">Paciente</label>
                                        </div>

                                       

                                        <div class="form-floating mb-3">
                                            <select class="form-control" id="inputReceta" name="id_receta" required>
                                                <option value="" disabled selected>Selecciona una Receta</option>
                                                <!-- Las opciones se cargarán mediante JavaScript -->
                                            </select>
                                            <label for="inputReceta">ID Receta</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <textarea class="form-control" id="inputObservaciones" name="observaciones" placeholder="Observaciones" required></textarea>
                                            <label for="inputObservaciones">Observaciones</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputFechaUpdate" name="fecha_ultimo_update" type="date" required />
                                            <label for="inputFechaUpdate">Fecha de Última Actualización</label>
                                        </div>

                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <button class="btn btn-primary btn-block" type="submit">Registrar Expediente</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        // Al seleccionar un paciente, obtener las recetas relacionadas
        document.getElementById('inputPaciente').addEventListener('change', function() {
            var idPaciente = this.value;
            var selectReceta = document.getElementById('inputReceta');
            selectReceta.innerHTML = "<option value='' disabled selected>Cargando...</option>";

            fetch('get_recetas.php?id_paciente=' + idPaciente)
                .then(response => response.json())
                .then(data => {
                    selectReceta.innerHTML = "<option value='' disabled selected>Selecciona una Receta</option>";
                    data.forEach(function(receta) {
                        selectReceta.innerHTML += "<option value='" + receta.id_receta + "'>" + receta.id_receta + "</option>";
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    selectReceta.innerHTML = "<option value='' disabled>Error al cargar recetas</option>";
                });
        });
    </script>
</body>
</html>
<?php
// Cerrar la conexión
$conn->close();
?>
