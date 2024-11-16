<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registro de Paciente</title>
        <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" >
        <link href="styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>

    <header class="header">
    <a href="#" class="logoo"> <i class="fas fa-heartbeat"></i>CAJAY</a>

    <nav class="navbar">
    <a href="index.php">Home</a>

    </nav>
</header>

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Registro de Medicos</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="sp_guardarCM.php" method="POST">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFirstName" name="nombre" type="text" placeholder="Ingresa tu nombre" required />
                                                        <label for="inputFirstName">Nombre(s)</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputLastName" name="apellido" type="text" placeholder="Ingresa tu apellido" required />
                                                        <label for="inputLastName">Apellido</label>
                                                    </div>
                                                </div>
                                            </div>
                                               <div class="form-floating mb-3">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputEspecialidad" name="especialidad" type="text" placeholder="Ingresa tu especialidad" required />
                                                        <label for="inputLastName">Especialidad</label>
                                                    </div>
                                                </div>

                                                <div class="form-floating mb-3">
                                                <input class="form-control" id="inputTelefono" name="telefono" type="text" placeholder="Ingresa tu teléfono" />
                                                <label for="inputTelefono">Teléfono</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                                                <label for="inputEmail">Correo Electrónico</label>
                                            </div>
                                            
                                            
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" name="contraseña" type="password" placeholder="Crea una contraseña" required />
                                                        <label for="inputPassword">Contraseña</label>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputlicencia_medica" name="licencia_medica" type="text" placeholder="ingresa tu licencia" required />
                                                <label for="inputLicencia_medica">Licencia Medica</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputFechaContratacion" name="fecha_contratacion" type="date" required />
                                                <label for="inputFechaContratacion">Fecha de Contratacion</label>
                                            </div>

                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary btn-block" type="submit">Registrar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="indexA.php">¿Ya tienes cuenta? Ir a Iniciar Sesión</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
    </body>
</html>