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
                                        <h3 class="text-center font-weight-light my-4">Registro de Paciente</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="sp_guardarC.php" method="POST">
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
                                                <input class="form-control" id="inputEmail" name="email" type="email" placeholder="name@example.com" required />
                                                <label for="inputEmail">Correo Electrónico</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputFechaNacimiento" name="fecha_nacimiento" type="date" required />
                                                <label for="inputFechaNacimiento">Fecha de Nacimiento</label>
                                            </div>
                                            <div class="mb-3">
                                              <label for="inputGenero">Género</label>
                                                 <select class="form-control" id="inputGenero" name="genero" required>
                                                 <option value="" disabled selected>Selecciona un género</option>
                                                 <option value="Masculino">Masculino</option>
                                                 <option value="Femenino">Femenino</option>
                                                 <option value="Otro">Otro</option>
                                                </select>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputDireccion" name="direccion" type="text" placeholder="Ingresa tu dirección" />
                                                <label for="inputDireccion">Dirección</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputTelefono" name="telefono" type="text" placeholder="Ingresa tu teléfono" />
                                                <label for="inputTelefono">Teléfono</label>
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
    <label for="inputGrupoSanguineo"> </label>
    <select class="form-control" id="inputGrupoSanguineo" name="grupo_sanguineo" required>
        <option value="" disabled selected>Selecciona tu grupo sanguíneo</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
    </select>
</div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputFechaRegistro" name="fecha_registro" type="date" required />
                                                <label for="inputFechaRegistro">Fecha de Registro</label>
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