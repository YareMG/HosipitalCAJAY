<?php
$id_expediente = $_GET['id_expediente'];
$cnx=mysqli_connect("localhost", "root", "12345678", "hospital");
$sql = "DELETE FROM expediente where id_expediente like $id_expediente";
$rta=mysqli_query($cnx, $sql);
if(!$rta){
    echo "No se elimino";
}
else{
    header("Location: expediente.php");
}
?>