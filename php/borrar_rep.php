<?php
include('../php/conexion.php');
$IdReporte = $conn->real_escape_string($_POST['valorIdReporte']);
$tipo = $conn->real_escape_string($_POST['tipo']);
if ($tipo == "reporte") {
  $ruta = "../views/reportes.php";
}elseif ($tipo == "instalacion") {
  $ruta = "../views/instalaciones.php";
}
  if(mysqli_query($conn, "DELETE FROM `tmp_reportes` WHERE `tmp_reportes`.`id_reporte` = $IdReporte")){
    echo '<script >M.toast({html:"Instalacion Borrada de la Ruta.", classes: "rounded"})</script>';
    ?>
  <script>    
      var a = document.createElement("a");
        a.href = <?php echo $ruta; ?>;
        a.click();
  </script>
  <?php
    }else{
    echo "<script >M.toast({html: 'Ha ocurrido un error.', classes: 'rounded'});/script>";
  }

mysqli_close($conn);
?> 