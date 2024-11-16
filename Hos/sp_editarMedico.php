<?php
// Iniciar la sesión
session_start();

// Verificar si el médico está logueado
if (!isset($_SESSION['id_medico'])) {
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
$id_medico = $_POST['id_medico'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];

// Preparar la consulta para actualizar los datos del médico
$query = "UPDATE medicos SET nombre = ?, apellido = ?, email = ?, telefono = ? WHERE id_medico = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $nombre, $apellido, $email, $telefono, $id_medico);

// Ejecutar la consulta y verificar si fue exitosa
if ($stmt->execute()) {
    // Redirigir a la página de perfil con un mensaje de éxito
    header("Location: perfilMed.php?mensaje=Datos actualizados exitosamente.");
    exit();
} else {
    // Mostrar un mensaje de error
    echo "Error al actualizar los datos: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
