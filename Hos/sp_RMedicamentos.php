<?php
// Iniciar sesión
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si se recibieron todos los datos necesarios
if (isset($_POST['id_paciente'], $_POST['id_medicamento'], $_POST['cantidad'], $_POST['instrucciones'], $_POST['fecha_emision'])) {
    // Asignar los valores a variables
    $id_paciente = $_POST['id_paciente'];
    $id_medicamento = $_POST['id_medicamento'];
    $cantidad = $_POST['cantidad'];
    $instrucciones = $_POST['instrucciones'];
    $fecha_emision = $_POST['fecha_emision'];

    // Obtener el id_medico de la sesión
    $id_medico = $_SESSION['id_medico']; // Asegúrate de que este valor esté definido en la sesión

    // Insertar la receta en la base de datos
    $sql = "INSERT INTO recetas_medicas (id_paciente, id_medicamento, cantidad, instrucciones, fecha_emision, id_medico)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiisss", $id_paciente, $id_medicamento, $cantidad, $instrucciones, $fecha_emision, $id_medico);

    if ($stmt->execute()) {
        // Mensaje de éxito
        $_SESSION['message'] = "Receta médica guardada con éxito."; // Guardar mensaje en sesión
        header("Location: Realizar_RecMed.php"); // Redirigir a otro archivo
        exit(); // Asegurarse de que el script se detenga después de la redirección
    } else {
        echo "Error al crear la receta médica: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Por favor, complete todos los campos del formulario.";
}

$conn->close();
?>
