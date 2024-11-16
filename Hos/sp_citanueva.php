<?php
// Iniciar la sesión para usar variables de sesión
session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el ID del médico está disponible en la sesión
if (isset($_SESSION['id_medico'])) {
    $id_medico = $_SESSION['id_medico']; // Obtener el ID del médico de la sesión
} else {
    die("Error: El ID del médico no está definido en la sesión.");
}

// Obtener datos del formulario
$id_paciente = $_POST['id_paciente'];
$fecha_cita = $_POST['fecha_cita'];
$motivo = $_POST['motivo'];
$estado_cita = $_POST['estado_cita'];

// Insertar la nueva cita en la base de datos
$sql = "INSERT INTO citas_medicas (id_paciente, id_medico, fecha_cita, motivo, estado_cita) 
        VALUES ('$id_paciente', '$id_medico', '$fecha_cita', '$motivo', '$estado_cita')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "Cita Guardada Exitodamente.";
    header("Location: Citas_pro.php"); // Redirigir a la tabla de citas
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

