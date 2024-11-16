<?php
// Verificar que todos los campos estén presentes en el formulario
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['especialidad']) && isset($_POST['telefono']) && isset($_POST['email']) && isset($_POST['contraseña']) && isset($_POST['licencia_medica']) && isset($_POST['fecha_contratacion'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad = $_POST['especialidad'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $licencia_medica = $_POST['licencia_medica'];
    $fecha_contratacion = $_POST['fecha_contratacion'];

    $cnx = mysqli_connect("localhost", "root", "12345678", "hospital");


    if (!$cnx) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Verificar si el email ya existe
    $sql_check = "SELECT * FROM medicos WHERE email = ?";
    $stmt_check = mysqli_prepare($cnx, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $email);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_store_result($stmt_check);

    if (mysqli_stmt_num_rows($stmt_check) > 0) {
        // El email ya está registrado
        echo "El email ya está registrado.";
    } else {
        // Si el email no está registrado, proceder con la inserción
        $sql = "INSERT INTO pacientes (nombre, apellido,especialidad, telefono, email, contraseña, licencia_medica, fecha_contratacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($cnx, $sql);
        mysqli_stmt_bind_param($stmt, "ssssssss", $nombre, $apellido,$especialidad,$telefono, $email, $contraseña, $licencia_medica, $fecha_contratacion);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: AccesoMed.php"); 
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
