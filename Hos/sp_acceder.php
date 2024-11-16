<?php
session_start(); // Inicia la sesión

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '12345678', 'hospital');

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$email = $_POST['email'];
$contraseña = $_POST['contraseña'];

// Consulta para verificar el usuario
$sql = "SELECT * FROM pacientes WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Verifica si hay resultados
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verifica la contraseña (puedes usar password_hash y password_verify para mayor seguridad)
    if ($row['contraseña'] === $contraseña) { // Cambia esto si usas hash
        $_SESSION['id_paciente'] = $row['id_paciente']; // Almacena el ID del paciente en la sesión
        header("Location: Datos_paciente.php"); // Redirige al perfil del paciente
        exit();
    } else {
        echo "<div class='alert alert-danger'>Contraseña incorrecta.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Email no encontrado.</div>";
}

// Cierra la declaración y la conexión
$stmt->close();
$conn->close();
?>

