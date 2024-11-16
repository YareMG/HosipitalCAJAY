<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_medico'])) {
    echo "Acceso no autorizado.";
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
$id_expediente = $_POST['id_expediente'];
$observaciones = $_POST['observaciones'];
$fecha_ultimo_update = $_POST['fecha_ultimo_update'];

// Obtener id_paciente desde la base de datos
$sqlPaciente = "SELECT id_paciente FROM expediente WHERE id_expediente = ?";
$stmtPaciente = $conn->prepare($sqlPaciente);
$stmtPaciente->bind_param("i", $id_expediente);
$stmtPaciente->execute();
$resultPaciente = $stmtPaciente->get_result();

if ($resultPaciente->num_rows === 0) {
    echo "No se encontró el expediente.";
    exit();
}

$rowPaciente = $resultPaciente->fetch_assoc();
$id_paciente = $rowPaciente['id_paciente'];

// Consulta para actualizar el expediente (sin id_medico si no existe en la tabla)
$sql = "UPDATE expediente SET id_paciente = ?, observaciones = ?, fecha_ultimo_update = ? WHERE id_expediente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issi", $id_paciente, $observaciones, $fecha_ultimo_update, $id_expediente);

if ($stmt->execute()) {
    echo "Expediente actualizado exitosamente.";
    header("Location: expediente.php");
    exit();
} else {
    echo "Error al actualizar el expediente: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$stmtPaciente->close();
$conn->close();
?>

