<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel= "stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" >
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<header class="header">
    <a href="#" class="logoo"> <i class="fas fa-heartbeat"></i>CAJAY</a>

    <nav class="navbar">
    <a href="accesos.php">Login</a>

    </nav>
</header>


<section>
        <div class="contenedor">
            <div class="formulario">
            <form action="sp_accederMed.php" method="POST">
                    <h2>Iniciar Sesión</h2>

                    <div class="input-contenedor">
                        <input type="email" name="email" required>
                        <label for="email">Email</label>
                    </div>

                    <div class="input-contenedor">
                    <input type="password" name="contraseña" required>
                        <label for="contraseña">Contraseña</label>
                    </div>

                    <div class="olvidar">
                        <label for="#">
                            <input type="checkbox"> Recordar
                            <a href="#">Olvidé mi contraseña</a>
                        </label>
                    </div>
                    
                <div>
                
                 <button type="submit">Acceder</button>
            </form>
                   <div class="registrar">
                    <p>No tengo Cuenta <a href="CuentaMed.php">Crear Cuenta</a></p>
                   </div>
                </div>

            </div>
        </div>
    </section>
    
</body>
</html>