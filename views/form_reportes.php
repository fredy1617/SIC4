<html>
<head>
  <title>SIC | Reporte</title>
<?php 
include('fredyNav.php');
?>
<script>
  function verificar_reporte() {  
    var texoReferencia = $("textarea#referencia").val();
    var textoDescripcion = $("textarea#descripcion").val();
    var textoIdCliente = $("input#id_cliente").val();

    if(textoDescripcion==""){
      M.toast({html:"El campo descripción no puede estar vacío.", classes: "rounded"})
    }else{
      $.post("modal_rep.php", {
          valorReferencia: texoReferencia,
          valorDescripcion: textoDescripcion,
          valorIdCliente: textoIdCliente 
        }, function(mensaje) {
            $("#Continuar").html(mensaje);
        });
    }
  };
  function instertar_reporte(){
    var texoReferencia = $("input#referencia").val();
    var textoDescripcion = $("input#descripcion").val();
    var textoIdCliente = $("input#id_cliente").val();
    $.post("../php/insert_reporte.php", {
          valorReferencia: texoReferencia,
          valorDescripcion: textoDescripcion,
          valorIdCliente: textoIdCliente 
        }, function(mensaje) {
            $("#mostrar_pagos").html(mensaje);
    });
  };
</script>

</head>
<main>
<body>
<?php
require('../php/conexion.php');
$no_cliente = $_POST['no_cliente'];
$sql = mysqli_query($conn, "SELECT * FROM clientes WHERE id_cliente=$no_cliente");
$filas = mysqli_num_rows($sql);
if ($filas == 0) {
  $sql = mysqli_query($conn, "SELECT * FROM especiales WHERE id_cliente=$no_cliente");
}
$datos = mysqli_fetch_array($sql);


//Sacamos la Comunidad
$id_comunidad = $datos['lugar'];
$comunidad = mysqli_fetch_array(mysqli_query($conn, "SELECT nombre FROM comunidades WHERE id_comunidad='$id_comunidad'"));

?>
<div class="container" id="Continuar">
  <h4>Creando Reporte para el cliente:</h4>

  <div id="resultado_insert_pago">
  </div>
  <ul class="collection">
    <li class="collection-item avatar">
      <img src="../img/cliente.png" alt="" class="circle">
      <span class="title"><b>No. Cliente: </b><?php echo $datos['id_cliente'];?></span>
      <p><b>Nombre(s): </b><?php echo $datos['nombre'];?><br>
        <b>Telefono: </b><?php echo $datos['telefono'];?><br>
         <b>Comunidad: </b><?php echo $comunidad['nombre'];?><br>
         <b>Dirección: </b><?php echo $datos['direccion'];?><br>
         <b>Referencia: </b><?php echo $datos['referencia'];?><br>
         <b>Fecha de Instalación: </b><?php echo $datos['fecha_instalacion'];?><br> 
         <span class="new badge pink hide-on-med-and-up" data-badge-caption="ACTIVO"></span><br>

      </p>
      <a class="secondary-content"><span class="new badge pink hide-on-small-only" data-badge-caption="ACTIVO"></span></a>
    </li>
  </ul>

  <div class="row">
    <div class="col s12">
      <form class="col s12" name="formMensualidad">
      <br>
      <div class="row">
        <div class="input-field col s12 m6 l6">
          <i class="material-icons prefix">comment</i>
          <textarea id="referencia" class="materialize-textarea validate" data-length="150" required></textarea>
          <label for="referencia">Referencia: </label>
        </div>
        <div class="input-field col s12 m6 l6">
          <i class="material-icons prefix">description</i>
          <textarea id="descripcion" class="materialize-textarea validate" data-length="200"></textarea>
          <label for="descripcion">Descripción:</label>
        </div>
      </div>
      <input id="id_cliente" value="<?php echo htmlentities($datos['id_cliente']);?>" type="hidden">
    </form>
    <a onclick="verificar_reporte();" class="waves-effect waves-light btn pink right"><i class="material-icons right">send</i>Registrar Reporte</a>
    </div>
  </div>

<h4>Historial Reportes</h4>
  <div id="mostrar_pagos">
    <table class="bordered highlight responsive-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Fecha</th>
        <th>Descripción</th>
        <th>Ultima Modificación</th>
        <th>Solución</th>
        <th>Técnico</th>
        <th>Estatus</th>
      </tr>
    </thead>
    <tbody>
<?php
$sql_pagos = "SELECT * FROM reportes WHERE id_cliente = ".$datos['id_cliente']." ORDER BY id_reporte DESC";
$resultado_pagos = mysqli_query($conn, $sql_pagos);
$aux = mysqli_num_rows($resultado_pagos);
if($aux>0){
while($pagos = mysqli_fetch_array($resultado_pagos)){
  $id_tecnico = $pagos['tecnico'];
  $tecnico = mysqli_fetch_array(mysqli_query($conn, "SELECT user_name FROM users WHERE user_id = '$id_tecnico'"));
  if($pagos['atendido']==1){
    $atendido = '<span class="green new badge" data-badge-caption="Atendido">';
  }else if($pagos['atendido']==2){
    $atendido = '<span class="yellow darken-3 new badge" data-badge-caption="EnProceso">';
  }else{
    $atendido = '<span class="red new badge" data-badge-caption="Revisar">';
  }
  ?>
  <tr>
    <td><b><?php echo $aux;?></b></td>
    <td><?php echo $pagos['fecha'];?></td>
    <td><?php echo $pagos['descripcion'];?></td>
    <td><?php echo $pagos['fecha_solucion'];?></td>
    <td><?php echo $pagos['solucion'];?></td>
    <td><?php echo $tecnico['user_name'];?></td>
    <td><?php echo $atendido;?></td>
  </tr>
  <?php
  $aux--;
}
}else{
  echo "<center><b><h3>Este cliente aún no ha registrado reportes</h3></b></center>";
}
?> 
        </tbody>
      </table>
  </div>
<br>
<?php 
mysqli_close($conn);
?>
</div>
</body>
</main>
</html>
