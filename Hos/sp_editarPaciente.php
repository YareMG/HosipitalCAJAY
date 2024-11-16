<?php
// Iniciar la sesión
session_start();

// Verificar si el paciente está logueado
if (!isset($_SESSION['id_paciente'])) {
    echo "Acceso denegado. Por favor, inicie sesión.";
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

// Obtener los datos del formulario
$id_paciente = $_POST['id_paciente'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];
$grupo_sanguineo = $_POST['grupo_sanguineo'];

// Preparar la consulta para actualizar los datos del paciente
$query = "UPDATE pacientes SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ?, grupo_sanguineo = ? WHERE id_paciente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssi", $nombre, $apellido, $email, $telefono, $direccion, $grupo_sanguineo, $id_paciente);

// Ejecutar la consulta y verificar si fue exitosa
if ($stmt->execute()) {
    // Redirigir a la página de perfil con un mensaje de éxito
    header("Location: Datos_paciente.php?mensaje=Datos actualizados exitosamente.");
    exit();
} else {
    // Mostrar un mensaje de error
    echo "Error al actualizar los datos: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
