<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('nav.php');
  include('../php/conexion.php');
  include('../php/cobrador.php');
?>
<title>SIC | Instalaciones Pendientes</title>
<script>
function ruta(id_cliente) {
    if (id_cliente == "") {
      M.toast({html:"Ocurrio un error al seleccionar el cliente.", classes: "rounded"});
    }else{
      $.post("../php/insert_tmp_pendientes.php", {
          valorIdCliente: id_cliente,
        }, function(mensaje) {
            $("#resultado_ruta").html(mensaje);
        }); 
    }
};
</script>
</head>
<body>
	<div class="container">
    	<h3>Instalaciones Pendientes</h3>
        <table class="bordered highlight">
            <thead>
                <tr>
                    <th>No. Cliente</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Lugar</th>
                    <th>Alta</th>
                    <th>Agregar</th>
                </tr>
            </thead>
            <tbody>
    	   <?php 
    		$sql_pendientes = mysqli_query($conn,"SELECT * FROM clientes WHERE instalacion is NULL ORDER BY id_cliente");
    		while($pendientes = mysqli_fetch_array($sql_pendientes)){
                $id_comunidad = $pendientes['lugar'];
                $sql_comunidad = mysqli_fetch_array(mysqli_query($conn,"SELECT nombre FROM comunidades WHERE id_comunidad=$id_comunidad"));
    			?>
                <tr>
                    <td><?php echo $pendientes['id_cliente'];?></td>
                    <td><?php echo $pendientes['nombre'];?></td>
                    <td><?php echo $pendientes['telefono'];?></td>
                    <td><?php echo $sql_comunidad['nombre'];?></td>
                    <td><form method="post" action="../views/alta_instalacion.php"><input type="hidden" name="id_cliente" value="<?php echo $pendientes['id_cliente'];?>"><button button type="submit" class="btn btn-floating green darken-3 waves-effect waves-light"><i class="material-icons">done</i></button></form></td>
                    <td><a onclick="ruta(<?php echo $pendientes['id_cliente'];?>);" class="btn btn-floating green darken-3 waves-effect waves-light"><i class="material-icons">add</a></td>
                </tr>
                <?php
    		}
    	?>
            </tbody>
        </table>
        <br><br><br>
        <h3>Ruta</h3>
        <div id="resultado_ruta">
            <table class="bordered highlight">
                <thead>
                    <tr>
                        <th>No. Cliente</th>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Lugar</th>
                        <th>Dirección</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                $sql_tmp = mysqli_query($conn,"SELECT * FROM tmp_pendientes");
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
                    </tr>
                <?php
                    }
                }
                mysqli_close($conn);
                ?>
                </tbody>
            </table>
        </div>
        <br><br>
        <a href="#ruta" class="btn waves-light waves-effect right green darken-3">Imprimir</a>
    </div>
    <br><br><br>
</body>
</html>