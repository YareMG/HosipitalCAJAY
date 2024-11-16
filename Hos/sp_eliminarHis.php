<?php
$id_historial = $_GET['id_historial'];
$cnx=mysqli_connect("localhost", "root", "12345678", "hospital");
$sql = "DELETE FROM historial_medico where id_historial like $id_historial";
$rta=mysqli_query($cnx, $sql);
if(!$rta){
    echo "No se elimino";
}
else{
    header("Location: HistorialPaci.php");
}
?>