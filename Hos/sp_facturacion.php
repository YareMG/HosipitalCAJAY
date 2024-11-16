<?php
session_start();

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['id_medico'])) {
    header("Location: Login.php"); // Redirigir a la página de inicio de sesión si no está autenticado
    exit();
}

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$id_paciente = $_POST['id_paciente'];
$id_cita = $_POST['id_cita'];
$monto_total = $_POST['monto_total'];
$fecha_factura = $_POST['fecha_factura'];
$estado_pago = $_POST['estado_pago'];

// Preparar y ejecutar la consulta de inserción
$sql = "INSERT INTO facturacion (id_paciente, id_cita, monto_total, fecha_factura, estado_pago)
VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iisss", $id_paciente, $id_cita, $monto_total, $fecha_factura, $estado_pago);

if ($stmt->execute()) {
    // Factura registrada con éxito
    header("Location: FacturaMed.php?msg=Factura registrada con éxito.");
} 

// Cerrar conexiones
$stmt->close();
$conn->close();
?>
