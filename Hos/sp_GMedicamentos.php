<?php
// Iniciar la sesión antes de cualquier salida
session_start();

if (!isset($_SESSION['id_medico'])) {
    echo "Por favor, inicie sesión para acceder a esta sección.";
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

// Manejo de solicitudes POST para crear o actualizar medicamentos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_medicamento = isset($_POST['id_medicamento']) ? intval($_POST['id_medicamento']) : null;
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $dosis = $_POST['dosis'];
    $fabricante = $_POST['fabricante'];

    // Validación de datos
    if (empty($nombre) || empty($descripcion) || empty($dosis) || empty($fabricante)) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    // Verificar si se trata de una actualización o inserción
    if ($id_medicamento) {
        // Actualizar medicamento existente
        $query = "UPDATE medicamentos SET nombre=?, descripcion=?, dosis=?, fabricante=? WHERE id_medicamento=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $nombre, $descripcion, $dosis, $fabricante, $id_medicamento);
    } else {
        // Insertar nuevo medicamento
        $query = "INSERT INTO medicamentos (nombre, descripcion, dosis, fabricante) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $nombre, $descripcion, $dosis, $fabricante);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Medicamento guardado correctamente.";
        header("Location: medicamentosP.php"); // Redirigir a otro archivo
        exit();
    } else {
        echo "Error al guardar el medicamento: " . $stmt->error;
    }

    $stmt->close();
}

// Manejo de solicitudes GET para obtener todos los medicamentos
$query = "SELECT * FROM medicamentos";
$result = $conn->query($query);

$medicamentos = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $medicamentos[] = $row;
    }
}

$conn->close();
?>
