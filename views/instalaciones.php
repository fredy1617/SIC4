<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('fredyNav.php');
  include('../php/conexion.php');
  include('../php/cobrador.php');
?>
<title>SIC | Instalaciones Pendientes</title>
<script>
  function borrar_inst(IdCliente){
    $.post("../php/borrar_inst.php", {
            tipo : "instalacion",
            valorIdCliente: IdCliente,
    }, function(mensaje) {
    $("#borrar_inst").html(mensaje);
    }); 
  };
  function borrar_rep(IdReporte){
    $.post("../php/borrar_rep.php", {
            tipo : "instalacion", 
            valorIdReporte: IdReporte,
    }, function(mensaje) {
    $("#reporte_borrar").html(mensaje);
    }); 
  };
  function eliminar_instalacion(id_cliente){
    $.post("../php/eliminar_instalacion.php", { 
            valorIdCliente: id_cliente,
    }, function(mensaje) {
    $("#cliente_borrado").html(mensaje);
    }); 
  };
  function ruta(id_cliente) {
      if (id_cliente == "") {
        M.toast({html:"Ocurrio un error al seleccionar el cliente.", classes: "rounded"});
      }else{
        $.post("../php/insert_tmp_pendientes.php", {
            valorIdCliente: id_cliente,
          }, function(mensaje) {
              $("#instalaciones_ruta").html(mensaje);
          }); 
      }
  };
  function modal(){
   $(document).ready(function(){
      $('#rutamodal').modal();
      $('#rutamodal').modal('open'); 
   });
  };
</script>
</head>
<main>
<body>
	<div class="container">            
    <div id="borrar_inst"></div>
    <div id="reporte_borrar"></div>
    <div id="cliente_borrado"></div>
                <div class="row" >
              <h3 class="hide-on-med-and-down">Instalaciones Pendientes</h3>
              <h5 class="hide-on-large-only">Instalaciones Pendientes</h5>
            </div>
            <table class="bordered highlight responsive-table">
                <thead>
                    <tr>
                        <th>No. Cliente</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Lugar</th>
    					          <th>Registro</th>
    					          <th>Alta</th>
                        <th>Agregar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
                <tbody>
        	<?php 
        		$sql_pendientes = mysqli_query($conn,"SELECT * FROM clientes WHERE instalacion is NULL ORDER BY id_cliente ASC");
        		while($pendientes = mysqli_fetch_array($sql_pendientes)){
              $id_comunidad = $pendientes['lugar'];
              $sql_comunidad = mysqli_fetch_array(mysqli_query($conn,"SELECT nombre FROM comunidades WHERE id_comunidad=$id_comunidad"));
        			?>
                    <tr>
                        <td><?php echo $pendientes['id_cliente'];?></td>
                        <td><?php echo $pendientes['nombre'];?></td>
                        <td><?php echo $pendientes['telefono'];?></td>
                        <td><?php echo $sql_comunidad['nombre'];?></td>
    					          <td><?php echo $pendientes['registro'];?></td>
                        <td><form method="post" action="../views/alta_instalacion.php"><input type="hidden" name="id_cliente" value="<?php echo $pendientes['id_cliente'];?>"><button button type="submit" class="btn btn-floating pink waves-effect waves-light"><i class="material-icons">done</i></button></form></td>
                        <td><a onclick="ruta(<?php echo $pendientes['id_cliente'];?>);" class="btn btn-floating pink waves-effect waves-light"><i class="material-icons">add</i></a></td>
                        <td><a onclick="eliminar_instalacion(<?php echo $pendientes['id_cliente']; ?>)" class="btn btn-floating red darken-1 waves-effect waves-light"><i class="material-icons">delete</i></a></td>
                    </tr>
                    <?php
        		}
        	?>
                </tbody>
            </table>
            <br><br><br><div class="row">
            <h3 class="hide-on-med-and-down">Ruta Instalaciones</h3>
            <h5 class="hide-on-large-only">Ruta Instalaciones</h5>
            <div id="instalaciones_ruta">
                <table class="bordered highlight responsive-table">
                    <thead>
                        <tr>
                            <th>No. Cliente</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Lugar</th>
                            <th>Dirección</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $sql_tmp = mysqli_query($conn,"SELECT * FROM tmp_pendientes WHERE ruta_inst =0");
                    $columnas = mysqli_num_rows($sql_tmp);
                    if($columnas == 0){
                        ?>
                        <h5 class="center">No hay instalaciones en ruta</h5>
                        <?php
                    }else{
                        while($tmp = mysqli_fetch_array($sql_tmp)){
                            $id_comunidad = $tmp['lugar'];
                            $sql_comunidad1 = mysqli_fetch_array(mysqli_query($conn,"SELECT nombre FROM comunidades WHERE id_comunidad=$id_comunidad"));
                    ?>
                        <tr>
                          <td><?php echo $tmp['id_cliente']; ?></td>
                          <td><?php echo $tmp['nombre']; ?></td>
                          <td><?php echo $tmp['telefono']; ?></td>
                          <td><?php echo $sql_comunidad1['nombre']; ?></td>
                          <td><?php echo $tmp['direccion']; ?></td>
                          <td><a onclick="borrar_inst(<?php echo $tmp['id_cliente']; ?>);" class="btn btn-floating red darken-1 waves-effect waves-light"><i class="material-icons">delete</i></a></td>
                
                        </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
              </div>
            </div><br>
          <div class="row">
          <h3 class="hide-on-med-and-down">Ruta Reportes</h3>
          <h5 class="hide-on-large-only">Ruta Reportes</h5>
          <div id="resultado_ruta_reporte">
            <table class="bordered highlight responsive-table">
                    <thead>
                        <tr>
                            <th>Reporte No.</th>
                            <th>Cliente</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $sql_tmp = mysqli_query($conn,"SELECT * FROM tmp_reportes WHERE ruta = 0");
                    $columnas = mysqli_num_rows($sql_tmp);
                    if($columnas == 0){
                        ?>
                        <h5 class="center">No hay reportes en ruta</h5>
                        <?php
                    }else{
                        while($tmp = mysqli_fetch_array($sql_tmp)){
                            $id_reporte = $tmp['id_reporte'];
                            $sql_reporte = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM reportes WHERE id_reporte = '$id_reporte'"));

                            $id_cliente = $sql_reporte['id_cliente'];
                            $sql_nombre = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM clientes WHERE id_cliente = '$id_cliente'"));
                    ?>
                        <tr>
                          <td><?php echo $sql_reporte['id_reporte']; ?></td>
                          <td><?php echo $sql_nombre['nombre']; ?></td>
                          <td><?php echo $sql_reporte['descripcion']; ?></td>
                          <td><?php echo $sql_reporte['fecha']; ?></td>
                          <td><a onclick="borrar_rep(<?php echo $sql_reporte['id_reporte']; ?>);" class="btn btn-floating red darken-1 waves-effect waves-light"><i class="material-icons">delete</i></a></td>
                        </tr>
                    <?php
                        }
                    }
                    mysqli_close($conn);
                    ?>
                    </tbody>
                </table>
          </div>
        </div>
        <br><br>
        <a onclick="modal();"class="btn waves-light waves-effect right pink">Imprimir</a>
</div><br><br><br>
</body>
</main>
</html>