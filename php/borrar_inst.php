<?php
include('../php/conexion.php');
$IdCliente = $conn->real_escape_string($_POST['valorIdCliente']);
$tipo = $conn->real_escape_string($_POST['tipo']);
if ($tipo == "reporte") {
  $ruta = "../views/reportes.php";
}elseif ($tipo == "instalacion") {
  $ruta = "../views/instalaciones.php";
}
  if(mysqli_query($conn, "DELETE FROM `tmp_pendientes` WHERE `tmp_pendientes`.`id_cliente` = $IdCliente")){
    echo '<script >M.toast({html:"Instalacion Borrada de la Ruta.", classes: "rounded"})</script>';
    ?>
  <script>    
      var a = document.createElement("a");
        a.href =  <?php echo $ruta; ?>;
        a.click();
  </script>
  <?php
    }else{
    echo "<script >M.toast({html: 'Ha ocurrido un error.', classes: 'rounded'});/script>";
  }

mysqli_close($conn);
?>        
  