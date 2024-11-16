<?php
$id_medicamento = $_GET['id_medicamento'];
$cnx=mysqli_connect("localhost", "root", "12345678", "hospital");
$sql = "DELETE FROM medicamentos where id_medicamento like $id_medicamento";
$rta=mysqli_query($cnx, $sql);
if(!$rta){
    echo "No se elimino";
}
else{
    header("Location: medicamentosP.php");
}
?>