<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('fredyNav.php');
  include ('../php/conexion.php');
?>
<title>SIC | Alta Instalaciones</title>
<script>
function alta_instalacion_SM(bandera) {
    var textoTecnicos = '';
    for(var i=1;i<=bandera;i++){
      if(document.getElementById('tecnico'+i).checked==true){
        var textoCheck = $("input#tecnico"+i).val();
        textoTecnicos = textoTecnicos+textoCheck+', ';
      }
    }
    M.toast({html :"No hay numero."+textoTecnicos, classes: "rounded"});

    textoTecnicos = textoTecnicos.slice(0, -2);
    M.toast({html :"Despues."+textoTecnicos, classes: "rounded"});

    var textoIP = $("input#ip").val();
    var textoMaterial = $("textarea#material").val();    
    var textoObservacion = $("textarea#observacion").val();
    var textoIdCliente = $("input#id_cliente").val();  
    var textoTipo = $("select#tipo").val();

    if (textoTipo == "") {
      M.toast({html:"Seleccione algun tipo.", classes: "rounded"});
    }else if (textoIP == "") {
      M.toast({html:"El campo IP se encuentra vacío.", classes: "rounded"});
    }else if(textoMaterial == ""){
      M.toast({html:"El campo Material se encuentra vacío.", classes: "rounded"});
    }else if(textoTecnicos == ''){
      M.toast({html:"Seleccione un técnico por favor.", classes: "rounded"});
    }else {
      $.post("../php/alta_instalacion_SM.php", {
          valorIP: textoIP,
          valorMaterial: textoMaterial,
          valorObservacion: textoObservacion,
          valorIdCliente: textoIdCliente,
          valorTecnicos: textoTecnicos,
          valorTipo: textoTipo,
        }, function(mensaje) {
            $("#resultado_cliente").html(mensaje);
        }); 
    }
};

function alta_instalacion(bandera) {
    var textoTecnicos = '';
    for(var i=1;i<=bandera;i++){
      if(document.getElementById('tecnico'+i).checked==true){
        var textoCheck = $("input#tecnico"+i).val();
        textoTecnicos = textoTecnicos+textoCheck+', ';
      }
    }
    textoTecnicos = textoTecnicos.slice(0, -2);
    var textoIP = $("input#ip").val();
    var textoMaterial = $("textarea#material").val();
    var textoIdCliente = $("input#id_cliente").val();
    var textoTipo = $("select#tipo").val();

    if (textoTipo == "") {
      M.toast({html:"Seleccione algun tipo.", classes: "rounded"});
    }else if (textoIP == "") {
      M.toast({html:"El campo IP se encuentra vacío.", classes: "rounded"});
    }else if(textoMaterial == ""){
      M.toast({html:"El campo Material se encuentra vacío.", classes: "rounded"});
    }else if(textoTecnicos == ''){
      M.toast({html:"Seleccione un técnico por favor.", classes: "rounded"});
    }else {
      $.post("../php/alta_instalacion.php", {
          valorIP: textoIP,
          valorMaterial: textoMaterial,
          valorIdCliente: textoIdCliente,
          valorTecnicos: textoTecnicos,
          valorTipo: textoTipo,
        }, function(mensaje) {
            $("#resultado_cliente").html(mensaje);
        }); 
    }
};
</script>
</head>
<body>
<div class="container" id="resultado_cliente">
</div>
	<div class="container row">
    	<?php
        $id_cliente = $_POST['id_cliente'];
        $datos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM clientes WHERE id_cliente=$id_cliente"));

        $id_comunidad = $datos['lugar'];
        $comunidad = mysqli_fetch_array(mysqli_query($conn, "SELECT nombre FROM comunidades WHERE id_comunidad=$id_comunidad"));

        $id_paquete = $datos['paquete'];
        $paquete = mysqli_fetch_array(mysqli_query($conn, "SELECT subida, bajada FROM paquetes WHERE id_paquete=$id_paquete"));
        ?>
      <div class="row" >
      <h3 class="hide-on-med-and-down">Dar de Alta a Cliente</h3>
      <h5 class="hide-on-large-only">Dar de Alta a Cliente</h5>
      </div>
        <ul class="collection">
            <li class="collection-item avatar">
              <img src="../img/cliente.png" alt="" class="circle">
              <span class="title"><b>No. Cliente: </b><?php echo $datos['id_cliente'];?></span>
              <p><b>Nombre(s): </b><?php echo $datos['nombre'];?><br>
                <b>Telefono: </b><?php echo $datos['telefono'];?><br>
                 <b>Comunidad: </b><?php echo $comunidad['nombre'];?><br>
                 <b>Dirección: </b><?php echo $datos['direccion'];?><br>
                 <b>Paquete: </b> Subida: <?php echo $paquete['subida'];?> | Bajada: <?php echo $paquete['bajada'];?><br>
                 <b>Total: </b>$<?php echo $datos['total'];?><br>
                 <b>Dejó: </b>$<?php echo $datos['dejo'];?><br>
                 <b>Resta: </b>$<?php echo $datos['total']-$datos['dejo'];?><br>
                 <span class="new badge pink hide-on-med-and-up" data-badge-caption="INACTIVO"></span>               
              </p>
              <a href="#!" class="secondary-content hide-on-small-only"><span class="new badge pink" data-badge-caption="INACTIVO"></span></a>
            </li>
        </ul>
        <div class="row">
        <form class="col s12">
          <div class="row">
            <div class="col s12 m6 l6">
            <br>
            <div class="input-field">
              <i class="material-icons prefix">settings_ethernet</i>
              <input id="ip" type="text" class="validate" data-length="15" required>
              <label for="ip">IP:</label>
            </div>
            <div class="input-field">
              <i class="material-icons prefix">work</i>
              <textarea id="material" class="materialize-textarea validate" data-length="150" required></textarea>
              <label for="material">Material:</label>
            </div>
            <div class="input-field">
              <i class="material-icons prefix">comment</i>
              <textarea id="observacion" class="materialize-textarea validate" data-length="150" required></textarea>
              <label for="observacion">Observacion Tecnica:</label>
            </div>
            </div>
            <!-- AQUI SE ENCUENTRA LA DOBLE COLUMNA EN ESCRITORIO.-->
            <div class="col s12 m6 l6"><br>
            <input id="id_cliente" type="hidden" class="validate" data-length="200" value="<?php echo $datos['id_cliente'];?>" required><br>
            <div class="input-fiel row">
              <select id="tipo" class="browser-default" required>
                <option value="" selected>Tipo:</option>
                <option value="0">Prepago</option>
                <option value="1">Contrato</option>
              </select>
            </div><br> 
            <label>Técnicos:</label>
                <p>
                  <?php
                  $bandera = 1; 
                  $sql_tecnico = mysqli_query($conn,"SELECT * FROM users WHERE area='Taller' OR area='Redes'");
                  while($tecnico = mysqli_fetch_array($sql_tecnico)){
                    ?>
                    <div class="col s12 m6 l4">
                      <input type="checkbox" value="<?php echo $tecnico['user_name'];?>" id="tecnico<?php echo $bandera;?>"/>
                      <label for="tecnico<?php echo $bandera;?>"><?php echo $tecnico['user_name'];?></label>
                    </div>
                    <?php
                    $bandera++;
                  }$bandera--;
                  ?>
                </p>
              </div>
              </div>
        </form>
        </div><br><br>
        <div class="row">
          <a onclick="alta_instalacion(<?php echo $bandera;?>);" class="waves-effect waves-light btn pink right"><i class="material-icons right">send</i>ALTA SERVIDOR</a>
          <br><br>
          <a onclick="alta_instalacion_SM(<?php echo $bandera;?>);" class="waves-effect waves-light btn pink right"><i class="material-icons right">send</i> ALTA MANUAL. </a>          
        </div>
    </div>
    <?php
    mysqli_close($conn);
    ?>
</body>
</html>