<?php
// Verificar que todos los campos estén presentes en el formulario
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['fecha_nacimiento']) && isset($_POST['genero']) && isset($_POST['direccion']) && isset($_POST['telefono']) && isset($_POST['email']) && isset($_POST['contraseña']) && isset($_POST['grupo_sanguineo']) && isset($_POST['fecha_registro'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $genero = $_POST['genero'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $grupo_sanguineo = $_POST['grupo_sanguineo'];
    $fecha_registro = $_POST['fecha_registro'];

    $cnx = mysqli_connect("localhost", "root", "12345678", "hospital");


    if (!$cnx) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Verificar si el email ya existe
    $sql_check = "SELECT * FROM pacientes WHERE email = ?";
    $stmt_check = mysqli_prepare($cnx, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        // El email ya está registrado
        echo "El email ya está registrado.";
    } else {
        // Si el email no está registrado, proceder con la inserción
        $sql = "INSERT INTO pacientes (nombre, apellido,fecha_nacimiento, genero, direccion, telefono, email, contraseña, grupo_sanguineo, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($cnx, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssssss", $nombre, $apellido,$fecha_nacimiento,$genero,$direccion,$telefono, $email, $contraseña, $grupo_sanguineo, $fecha_registro);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: indexA.php"); 
            exit;
        } else {
            echo "Error al registrar: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_stmt_close($stmt_check);

    
    mysqli_close($cnx);

} else {
    echo "Por favor complete todos los campos del formulario.";
}
?>
