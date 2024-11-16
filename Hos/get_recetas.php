<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['id_paciente'])) {
    $id_paciente = $_GET['id_paciente'];

    $query = "SELECT r.id_receta FROM recetas_medicas r WHERE r.id_paciente = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();

    $recetas = array();
    while ($row = $result->fetch_assoc()) {
        $recetas[] = $row;
    }

    echo json_encode($recetas);
}

$conn->close();
?>
