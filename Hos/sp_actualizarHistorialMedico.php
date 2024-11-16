<?php
// Iniciar la sesión
session_start();

if (!isset($_SESSION['id_medico'])) {
    echo "Por favor, inicie sesión para realizar esta acción.";
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
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se han recibido los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_historial = $_POST['id_historial'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento'];
    $fecha_consulta = $_POST['fecha_consulta'];
    $observaciones = $_POST['observaciones'];

    // Consulta para actualizar el historial médico
    $sql = "UPDATE historial_medico SET 
                diagnostico = ?, 
                tratamiento = ?, 
                fecha_consulta = ?, 
                observaciones = ? 
            WHERE id_historial = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $diagnostico, $tratamiento, $fecha_consulta, $observaciones, $id_historial);

    if ($stmt->execute()) {
        echo "Historial médico actualizado correctamente.";
        // Puedes redirigir a otra página, por ejemplo:
        header("Location: HistorialPaci.php");
        exit();
    } else {
        echo "Error al actualizar el historial médico: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Método de solicitud no permitido.";
}

$conn->close();
?>
