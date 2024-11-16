<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "hospital";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$id_paciente = $_POST['id_paciente'];
$id_historial = $_POST['id_historial'];
$id_receta = $_POST['id_receta'];
$observaciones = $_POST['observaciones'];
$fecha_ultimo_update = $_POST['fecha_ultimo_update'];

// Preparar y vincular la consulta
$stmt = $conn->prepare("INSERT INTO expediente (id_paciente, id_historial, id_receta, observaciones, fecha_ultimo_update) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iiiss", $id_paciente, $id_historial, $id_receta, $observaciones, $fecha_ultimo_update);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Expediente registrado exitosamente.";
} else {
    echo "Error al registrar el expediente: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();

// Redireccionar a la página de expedientes
header("Location: expediente.php");
exit();
?>
