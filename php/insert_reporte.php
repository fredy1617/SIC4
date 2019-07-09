<?php
session_start();
include('../php/conexion.php');
date_default_timezone_set('America/Mexico_City');
$Referencia = $conn->real_escape_string($_POST['valorReferencia']);
$Descripcion = $conn->real_escape_string($_POST['valorDescripcion']);
$IdCliente = $conn->real_escape_string($_POST['valorIdCliente']);
$Fecha = date('Y-m-d');
$id_user = $_SESSION['user_id'];

if (!$Referencia == "") {
  $sql2= "UPDATE clientes SET referencia='$Referencia' WHERE id_cliente=$IdCliente ";
  mysqli_query($conn, $sql2);
}
//o $consultaBusqueda sea igual a nombre + (espacio) + apellido
$sql = "INSERT INTO reportes (id_cliente, descripcion, fecha, registro) VALUES ($IdCliente, '$Descripcion', '$Fecha', $id_user)";
if(mysqli_query($conn, $sql)){
	?>
  <script>    
    var a = document.createElement("a");
      a.href = "../views/reportes.php";
      a.click();
  </script>
  <?php
}else{
	echo  '<script>M.toast({html:"Ha ocurrido un error.", classes: "rounded"})</script>';	
}

mysqli_close($conn);
?>  