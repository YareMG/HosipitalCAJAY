<?php
// Iniciar la sesión
session_start();

// Verificar si el paciente ha iniciado sesión
if (!isset($_SESSION['id_paciente'])) {
    // Si no está logueado, redirigir al login
    header("Location: login.php");
    exit();
}

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

// Verificar si los datos han sido enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores enviados desde el formulario y la sesión
    $id_paciente = $_SESSION['id_paciente'];  // Obtenido de la sesión
    $id_medico = $_POST['id_medico'];
    $fecha_cita = $_POST['fecha_cita'];
    $motivo = $_POST['motivo'];
    $estado_cita = $_POST['estado_cita'];

    // Validar que el ID del médico y la fecha de la cita no estén vacíos
    if (!empty($id_medico) && !empty($fecha_cita)) {
        // Preparar la consulta para insertar la cita médica
        $sql = "INSERT INTO citas_medicas (id_paciente, id_medico, fecha_cita, motivo, estado_cita) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        // Ejecutar la consulta
        $stmt->bind_param("iisss", $id_paciente, $id_medico, $fecha_cita, $motivo, $estado_cita);
        
        if ($stmt->execute()) {
            // Redirigir a una página de éxito
            header("Location: CitaMed.php");
            exit();
        } else {
            echo "Error al registrar la cita: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "El ID del médico y la fecha de la cita son obligatorios.";
    }
} else {
    echo "Método de solicitud no válido.";
}

$conn->close();
?>
