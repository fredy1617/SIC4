<html>
<head>
	<title>SIC | Editar Cliente</title>
<?php 
include('fredyNav.php');
include('../php/conexion.php');
include('../php/cobrador.php');
?>
<style type="text/css">
  .select-dropdown{
    overflow-y: auto !important;
}
</style>
<script>
function update_cliente() {
    var textoIdCliente = $("input#id_cliente").val();
    var textoNombres = $("input#nombres").val();
    var textoTelefono = $("input#telefono").val();
    var textoComunidad = $("select#comunidad").val();
    var textoDireccion = $("input#direccion").val();
    var textoFechaCorte = $("input#fecha_corte").val();
    var textoReferencia = $("input#referencia").val();
    var textoPaquete = $("select#paquete").val();
    var textoIP = $("input#ip").val();
    var textoTipo = $("select#tipo").val();
    var textoCoordenada = $("input#coordenada").val();

  
    if (textoNombres == "") {
      M.toast({html: "El campo Nombre(s) se encuentra vacío.", classes: "rounded"});
    }else if(textoTelefono == ""){
      M.toast({html: "El campo Telefono se encuentra vacío.", classes: "rounded"});
    }else if(textoComunidad == "0"){
      M.toast({html: "No se ha seleccionado una comunidad aún.", classes: "rounded"});
    }else if(textoDireccion == ""){
      M.toast({html: "El campo Dirección se encuentra vacío.", classes: "rounded"});
    }else if(textoReferencia == ""){
      M.toast({html: "El campo Referencia se encuentra vacío.", classes: "rounded"});
    }else if(textoPaquete == "0"){
      M.toast({html: "No se ha seleccionado un paquete de internet aún.", classes: "rounded"});
    }else if(textoIP == ""){
      M.toast({html: "El campo IP se encuentra vacío.", classes: "rounded"});
    }else{
      $.post("../php/update_cliente.php", {
          valorIdCliente: textoIdCliente,
          valorNombres: textoNombres,
          valorTelefono: textoTelefono,
          valorComunidad: textoComunidad,
          valorDireccion: textoDireccion,
          valorReferencia: textoReferencia,
          valorPaquete: textoPaquete,
          valorIP: textoIP,
          valorFechaCorte: textoFechaCorte,
          valorTipo: textoTipo,
          valorCoordenada: textoCoordenada
        }, function(mensaje) {
            $("#resultado_update_cliente").html(mensaje);
        }); 
    }
};
</script>
</head>
<main>
<body>
<div class="container">
<?php
$id_cliente = $_POST['no_cliente'];
$cliente = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM clientes WHERE id_cliente='$id_cliente'"));
$valor = "";
if ($cliente['contrato'] == 1) {
  $valor = "Contratro";
}
if ($cliente['Prepago'] == 1) {
  $valor = "Prepago";
}

$id_comunidad = $cliente['lugar'];
$comunidad = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM comunidades WHERE id_comunidad='$id_comunidad'"));
$id_paquete = $cliente['paquete'];
$paquete_cliente = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM paquetes WHERE id_paquete='$id_paquete'"));
?>

  <br><h3 class="hide-on-med-and-down">Editar cliente No. <?php echo $cliente['id_cliente'];?></h3>
  <h5 class="hide-on-large-only">Editar cliente No. <?php echo $cliente['id_cliente']; ?></h5><br><br>
  <div id="resultado_update_cliente">
  </div>
   <div class="row">
    <form class="col s12">
    <input id="id_cliente" type="hidden" class="validate" data-length="200" value="<?php echo $cliente['id_cliente'];?>" required>
      <div class="row">
        <div class="col s12 m6 l6">
        <div class="input-field">
          <i class="material-icons prefix">account_circle</i>
          <input id="nombres" type="text" class="validate" data-length="50" value="<?php echo $cliente['nombre'];?>" required>
          <label for="nombres">Nombre Completo:</label>
        </div>
        <div class="input-field">
          <i class="material-icons prefix">phone</i>
          <input id="telefono" type="text" class="validate" data-length="13" value="<?php echo $cliente['telefono'];?>" required>
          <label for="telefono">Teléfono:</label>
        </div>
        <div class="row">
        <div class="col s12 m6 l6">
        <label><i class="material-icons">location_on</i>Comunidad:</label>
        <div class="input-field">
          <select id="comunidad" class="browser-default" required>
            <option value="<?php echo $comunidad['id_comunidad'];?>" selected><?php echo $comunidad['nombre'];?> - $<?php echo $comunidad['instalacion'];?></option>
              <?php
                $sql = mysqli_query($conn,"SELECT * FROM comunidades ORDER BY nombre");
                while($comunidad = mysqli_fetch_array($sql)){
                  ?>
                    <option value="<?php echo $comunidad['id_comunidad'];?>"><?php echo $comunidad['nombre'];?> - $<?php echo $comunidad['instalacion'];?></option>
                  <?php
                } 
            ?>
          </select>
        </div>
      </div>
      <div class="col s12 m6 l6"><br>
        <div class="input-field">
              <i class="material-icons prefix">add_location</i>
              <input id="coordenada" type="text" class="validate" data-length="15" required>
              <label for="coordenada">Coordenada:</label>
            </div>
      </div>
      </div>
        <div class="input-field">
          <i class="material-icons prefix">location_on</i>
          <input id="direccion" type="text" class="validate" data-length="100" value="<?php echo $cliente['direccion'];?>" required>
          <label for="direccion">Direccion:</label>
        </div>
      </div>
      <!-- AQUI SE ENCUENTRA LA DOBLE COLUMNA EN ESCRITORIO.-->
      <div class="col s12 m6 l6">
        <div class="input-field">
          <i class="material-icons prefix">comment</i>
          <input id="referencia" type="text" class="validate" data-length="150" required value="<?php echo $cliente['referencia'];?>">
          <label for="referencia">Referencia:</label>
        </div>
        <div class="input-field">
          <i class="material-icons prefix">edit</i>
          <input id="ip" type="text" class="validate" data-length="15" value="<?php echo $cliente['ip'];?>" required>
          <label for="ip">IP:</label>
        </div>
      <div class="row">
        <div class="col s12 m6 l6">
      <label><i class="material-icons">import_export</i>Paquete:</label>
        <div class="input-field ">
          <select id="paquete" class="browser-default" required>
            <option value="<?php echo $paquete_cliente['id_paquete'];?>" selected>$<?php echo $paquete_cliente['mensualidad'];?> Velocidad: <?php echo $paquete_cliente['bajada'].'/'.$paquete_cliente['subida'];?></option>
            <?php
                $sql = mysqli_query($conn,"SELECT * FROM paquetes");
                while($paquete = mysqli_fetch_array($sql)){
                  ?>
                    <option value="<?php echo $paquete['id_paquete'];?>">$<?php echo $paquete['mensualidad'];?> Velocidad: <?php echo $paquete['bajada'].'/'.$paquete['subida'];?></option>
                  <?php
                } 
                mysqli_close($conn);
            ?>
          </select>
        </div>
      </div>
      <div class="col s12 m6 l6">
      <label><i class="material-icons">assignment</i>Tipo:</label>
        <div class="input-field ">
          <select id="tipo" class="browser-default" required>
            <option value="" selected><?php echo $valor; ?></option>
            <option value="0">Prepago</option> 
            <option value="1">Contrato</option>   
          </select>
        </div>
      </div>

      </div>
        <div class="input-field">
          <i class="material-icons prefix">date_range</i>
          <input id="fecha_corte" type="date" class="validate" value="<?php echo $cliente['fecha_corte'];?>" required>
          <label for="fecha_corte">Fecha de Corte:</label>
        </div>
      </div>
    </div>
</form>
      <a onclick="update_cliente();" class="waves-effect waves-light btn pink right"><i class="material-icons right">send</i>ACTUALIZAR CAMBIOS</a>
    
  </div> 
</div>
<br>
</body>
</main>
</html>
