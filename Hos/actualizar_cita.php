<?php
session_start(); // Asegúrate de iniciar la sesión

// Verificar si se han recibido los datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_cita'], $_POST['fecha_cita'], $_POST['estado_cita'])) {
    // Obtener los datos del formulario
    $id_cita = $_POST['id_cita'];
    $fecha_cita = $_POST['fecha_cita'];
    $estado_cita = $_POST['estado_cita'];

    // Conectar a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "12345678";
    $dbname = "hospital";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para actualizar la cita médica
    $query = "UPDATE citas_medicas SET fecha_cita = ?, estado_cita = ? WHERE id_cita = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $fecha_cita, $estado_cita, $id_cita);

    if ($stmt->execute()) {
        // Redirigir a la página de citas médicas después de la actualización
        header("Location: Citas_pro.php?msg=Actualización exitosa");
        exit();
    } else {
        echo "Error al actualizar la cita: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    die("Datos incompletos.");
}
?>
