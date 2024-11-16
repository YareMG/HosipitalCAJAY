<?php
session_start();
session_destroy(); // Destruir la sesión
header("Location: accesos.php"); // Redirigir al login
exit();
?>
