<?php
include('../php/conexion.php');
$ValorDe = $conn->real_escape_string($_POST['valorDe']);
$ValorA = $conn->real_escape_string($_POST['valorA']);
?>
<br><br>
<table class="bordered highlight responsive-table">
    <thead>
      <tr>
        <th>No.</th>
        <th>Id_Cliente</th>
        <th>Nombre</th>
        <th>Comunidad</th>
        <th width="12%">Fecha</th>
        <th>Técnicos</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql_instalaciones = "SELECT * FROM clientes WHERE fecha_instalacion>='$ValorDe' AND fecha_instalacion<='$ValorA'";
      $resultado_instalaciones = mysqli_query($conn, $sql_instalaciones);
      $aux = mysqli_num_rows($resultado_instalaciones);
      if($aux>0){
      while($instalaciones = mysqli_fetch_array($resultado_instalaciones)){
        $id_comunidad = $instalaciones['lugar'];
        $comunidad = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM comunidades WHERE id_comunidad = '$id_comunidad'"));
        ?>
        <tr>
          <td><?php echo $aux;?></td>
          <td><b><?php echo $instalaciones['id_cliente'];?></b></td>
          <td><?php echo $instalaciones['nombre'];?></td>
          <td><?php echo $comunidad['nombre'];?></td>
          <td><?php echo $instalaciones['fecha_instalacion'];?></td>
          <td><?php echo $instalaciones['tecnico'];?></td>
        </tr>
        <?php
        $aux--;
      }
      }else{
        echo "<center><b><h5>No se encontraron instalaciones</h5></b></center>";
      }
?>
<?php 
mysqli_close($conn);
?>        
    </tbody>
</table><br><br><br>