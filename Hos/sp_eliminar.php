<?php
$id_cita = $_GET['id_cita'];
$cnx=mysqli_connect("localhost", "root", "12345678", "hospital");
$sql = "DELETE FROM citas_medicas where id_cita like $id_cita";
$rta=mysqli_query($cnx, $sql);
if(!$rta){
    echo "No se elimino";
}
else{
    header("Location: Citas_pro.php");
}
?>