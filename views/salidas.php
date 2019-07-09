<!DOCTYPE html>
<html lang="en">
<head>
<?php
  include('fredyNav.php');
  include('../php/conexion.php');
  include('../php/cobrador.php');

$tecnico = $_SESSION['user_id'];
?>
<title>SIC | Salidas</title>
<script>
function salida(imprimir) {
    var textoLink = $("textarea#link").val();
    var textoObservaciones = $("textarea#observaciones").val();
    var textoPrecio = $("input#precio").val();
    var textoIdDispositivo = $("input#id_dispositivo").val();
    var textoEstatus = $("select#estatus").val();

    textoTecnico = <?php echo $tecnico;?>;
    n=1;
    textoRefacciones = '';
    subtotal=0;
    entra = "Si";
    while(n<11){
      var textoNumero = $("input#numero"+n).val();
      if (textoNumero == null) {
          //M.toast({html :"No hay numero."+n, classes: "rounded"});
        }else{
          //M.toast({html :"Es: "+textoNumero, classes: "rounded"});
        var textoDesc = $("input#Desc_"+n).val();
        var textoPrecioR = $("input#precio"+n).val();
        if (textoDesc == "") {
           M.toast({html :"Ingrese una Descripción En: Descripcion No."+n, classes: "rounded"});
           entra = "No";
        }else if (textoPrecioR == "") {
           M.toast({html :"Ingrese un Precio En: Precio No."+n, classes: "rounded"});   
           entra = "No"      
        }else{
          var Precio = parseInt(textoPrecioR);
          subtotal+= Precio;
          entra = "Si";
          textoRefacciones += textoDesc+" - "+textoPrecioR+", ";
        }
        }
        n++;
    }
    if (entra == "No") {
      //M.toast({html:"Dice que no.", classes: "rounded"});
    }else if(textoPrecio == ""){
      M.toast({html:"El campo Mano de Obra se encuentra vacío.", classes: "rounded"});
    }else if(textoEstatus == '0'){
      M.toast({html:"Seleccione un Estatus por favor.", classes: "rounded"});
    }else {
      var textoPrecio = parseInt(textoPrecio);
      textoPrecio = textoPrecio+subtotal;

      $.post("../php/update_salida.php", {
          valorLink: textoLink,
          valorObservaciones: textoObservaciones,
          valorPrecio: textoPrecio,
          valorIdDispositivo: textoIdDispositivo,
          valorTecnico: textoTecnico,
          valorEstatus: textoEstatus,
          valorImprimir: imprimir,
          valorRefacciones: textoRefacciones
        }, function(mensaje) {
            $("#resultado_dispositivo").html(mensaje);
        }); 
    }
};
</script>
</head>
<main>
<body>
<div class="container" id="resultado_dispositivo">
</div>
	<div class="container row">
    <div class="row">
      <h2 class="hide-on-med-and-down">Salida</h2>
      <h4 class="hide-on-large-only">Salida</h4>
    </div>
    	<?php
        $id_dispositivo = $_POST['id_dispositivo'];
        $datos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM dispositivos WHERE id_dispositivo = $id_dispositivo"));
        ?>
        <ul class="collection">
            <li class="collection-item avatar">
              <div class="hide-on-large-only"><br><br></div>
              <img src="../img/cliente.png" alt="" class="circle">
              <span class="title"><b>Folio: </b><?php echo $datos['id_dispositivo'];?></span>
              <p><b>Nombre: </b><?php echo $datos['nombre'];?><br>
                <b>Telefono: </b><?php echo $datos['telefono'];?><br>
                 <b>Marca: </b><?php echo $datos['marca'];?><br>
                 <b>Modelo: </b><?php echo $datos['modelo'];?><br>
                 <b>Color: </b><?php echo $datos['color'];?><br>
                 <b>Contraseña: </b><?php echo $datos['contra'];?><br>
                 <b>Falla: </b><?php echo $datos['falla'];?><br>
                 <b>Cables: </b><?php echo $datos['cables'];?><br>
              </p>
              <a href="#!" class="primary-content"><span class="new badge red" data-badge-caption="<?php echo 'FECHA DE SALIDA: '.$datos['fecha_salida'];?>"></span></a>
              <br><br>
              <a href="#!" class="secondary-content"><span class="new badge green" data-badge-caption="<?php echo 'FECHA DE ENTRADA: '.$datos['fecha'];?>"></span></a>
            </li>
        </ul>
        <?php
        $id_user = $datos['tecnico'];
        if($id_user==''){
          $sql_usr[0] = 'Sin tecnico';
        }else{
          $sql_usr = mysqli_fetch_array(mysqli_query($conn, "SELECT user_name FROM users WHERE user_id=$id_user"));  
        }        
        ?>
        <form class="col s12" action="../php/folioSalida.php" target="_blank" method="POST">
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">insert_link</i>
              <textarea id="link" class="materialize-textarea validate" data-length="150" ><?php echo $datos['link'];?></textarea>
              <label for="link">Link de Mercado Libre:</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">comment</i>
              <textarea id="observaciones" class="materialize-textarea validate" data-length="150" ><?php echo $datos['observaciones'];?></textarea>
              <label for="observaciones">Observaciones:</label>
            </div>
          </div>
          <div class="row">
            <h4>Refacciones:</h4>
            <div class="button">
             <button type="button" id="add_Desc" class="waves-effect waves-light btn pink right"><i class="material-icons right">add</i>Agregar</button>
        </div>
          </div>
          <div class="row">
            <div class="input-field col s12 m4 l4">
              <i class="material-icons prefix">monetization_on</i>
              <input id="precio" type="number" class="validate" data-length="6" value="<?php echo $datos['precio'];?>" required>
              <label for="precio">Mano de Obra:</label>
            </div>
            <input id="id_dispositivo" type="hidden" class="validate" data-length="6" value="<?php echo $datos['id_dispositivo'];?>" required>
            
            <div class="input-field col l5 m5 s12">
              <select id="estatus" class="browser-default">
                <option value="<?php echo $datos['estatus'];?>" selected><?php echo $datos['estatus'];?></option>
                <option value="Entregado">Entregado</option>
                <option value="Listo (En Taller)">Listo (En Taller)</option>
              </select>
            </div>
             <input name="id_dispositivo" type="hidden" class="validate center" data-length="200" value="<?php echo $datos['id_dispositivo'];?>">
             <button onclick="salida(1);" type="submit" class="waves-effect waves-light btn pink right tooltipped" data-position="bottom" data-tooltip="Guardar e imprimir"><i class="material-icons right">print</i>Ticket</button><br><br>
             <a onclick="salida(0);" class="waves-effect waves-light btn pink right tooltipped" data-position="bottom" data-tooltip="Solo guardar"><i class="material-icons right">save</i>Guardar</a>
            </div>            
        </form>
       
    </div>
    <?php
    mysqli_close($conn);
    ?>
    <br><br><br>
</body>
<script>
  $(document).ready(function() {
    $("#add_Desc").click(function(){
        var contador = $("input[type='text']").length;

        $(this).before('<div class="row"><div class= "col s12 m6 l6"><div class="input-field"><i class="material-icons prefix">comment</i><input type="text" id="Desc_'+ contador +'" name="Desc[]"/><label for="Desc_'+ contador +'">Descripción No.'+ contador +' :</label></div></div><div class="col s10 m4 l4"><div class="input-field"><i class="material-icons prefix">attach_money</i><input type="number" id="precio'+ contador +'" name="precio[]"/><label for="precio'+ contador +'">Preco No.'+ contador +' :</label></div></div><input id="numero'+ contador +'" value="'+ contador +'" type="hidden"><button type="button" class="delete_Desc btn-floating btn-tiny waves-effect waves-light pink "><i class="material-icons prefix">delete</i></button></div>');
    });

    $(document).on('click', '.delete_Desc', function(){
        $(this).parent().remove();
    });
});
</script>
</main>
</html>