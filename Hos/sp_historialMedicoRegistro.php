<?php
// Iniciar la sesión
session_start();

// Verificar si el médico está autenticado
if (!isset($_SESSION['id_medico'])) {
    echo "Por favor, inicie sesión para registrar el historial médico.";
    exit();
}

// Conexión a la base de datos
$servername = "localhost"; // Cambia esto si es necesario
$username = "root"; // Cambia esto si es necesario
$password = "12345678"; // Cambia esto si es necesario
$dbname = "hospital"; // Cambia esto si es necesario

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$id_medico = $_SESSION['id_medico'];
$id_paciente = $_POST['id_paciente'];
$diagnostico = $_POST['diagnostico'];
$tratamiento = $_POST['tratamiento'];
$fecha_consulta = $_POST['fecha_consulta'];
$observaciones = $_POST['observaciones'];

// Consulta SQL para insertar el nuevo historial médico
$sql = "INSERT INTO historial_medico (id_paciente, diagnostico, tratamiento, id_medico, fecha_consulta, observaciones) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ississ", $id_paciente, $diagnostico, $tratamiento, $id_medico, $fecha_consulta, $observaciones);

if ($stmt->execute()) {
    // Redirigir a una página de éxito o visualización
    header("Location: HistorialPaci.php?success=1");
    exit();
} else {
    // Manejo de errores
    echo "Error al registrar el historial médico: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
