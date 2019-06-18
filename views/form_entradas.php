<html>
<head>
	<title>SIC | Formulario Dispositivo</title>
<?php 
include('fredyNav.php');
include ('../php/cobrador.php');
?>
<script>
function insert_dis() {
    var textoNombres = $("input#nombres").val();
    var textoTelefono = $("input#telefono").val();
    var textoMarca = $("input#marca").val();
    var textoModelo = $("input#modelo").val();
    var textoColor = $("input#color").val();
    var textoContra = $("input#contra").val();
    var textoFalla = $("input#falla").val();
    var textoCables = $("input#cables").val();
  
    if (textoNombres == "") {
      M.toast({html: 'El campo Nombre se encuentra vacío.', classes: 'rounded'});
    }else if(textoTelefono == ""){      
      M.toast({html: 'El campo Telefono se encuentra vacío.', classes: 'rounded'});
    }else if(textoMarca == ""){      
      M.toast({html: 'El campo Marca se encuentra vacío.', classes: 'rounded'});
    }else if(textoModelo == ""){      
      M.toast({html: 'El campo Modelo se encuentra vacío.', classes: 'rounded'});
    }else if(textoColor == ""){      
      M.toast({html: 'El campo Color se encuentra vacío.', classes: 'rounded'});
    }else if(textoContra == ""){      
      M.toast({html: 'El campo Contraseña se encuentra vacío.', classes: 'rounded'});
    }else if(textoFalla == ""){      
      M.toast({html: 'El campo Falla se encuentra vacío.', classes: 'rounded'});
    }else if(textoCables == ""){
      M.toast({html: 'El campo Cables se encuentra vacío.', classes: 'rounded'});
    }else{
      $.post("../php/insert_dispositivo.php", {
          valorNombres: textoNombres,
          valorTelefono: textoTelefono,
          valorMarca: textoMarca,
          valorModelo: textoModelo,
          valorColor: textoColor,
          valorContra: textoContra,
          valorFalla: textoFalla,
          valorCables: textoCables
        }, function(mensaje) {
            $("#resultado_insert_dispositivo").html(mensaje);
        }); 
    }
    };
</script>
</head>
<main>
<body>
<div class="container">
  <br>
  <div>
    <h2 class="hide-on-med-and-down">Registar Dispositivo</h2>
    <h4 class="hide-on-large-only">Registar Dispositivo</h4>
  </div><br>
  <div id="resultado_insert_dispositivo">
  </div>
   <div class="row">
    <form class="col s12">
      <div class="row">
        <div class="col s12 m6 l6">
        <div class="input-field">
          <i class="material-icons prefix">account_circle</i>
          <input id="nombres" type="text" class="validate" data-length="50" required>
          <label for="nombres">Nombre Completo:</label>
        </div>
        <div class="input-field">
          <i class="material-icons prefix">phone</i>
          <input id="telefono" type="text" class="validate" data-length="13" required>
          <label for="telefono">Teléfono:</label>
        </div>
        <div class="input-field">
          <i class="material-icons prefix">local_offer</i>
          <input id="marca" type="text" class="validate" data-length="20" required>
          <label for="marca">Marca:</label>
        </div>
        <div class="input-field">
          <i class="material-icons prefix">phonelink</i>
          <input id="modelo" type="text" class="validate" data-length="20" required>
          <label for="modelo">Modelo:</label>
        </div>
        </div>
          <!-- AQUI SE ENCUENTRA LA DOBLE COLUMNA EN ESCRITORIO.-->
        <div class="col s12 m6 l6">
        <div class="input-field">
          <i class="material-icons prefix">color_lens</i>
          <input id="color" type="text" class="validate" data-length="30" required>
          <label for="color">Color:</label>
        </div>
        <div class="input-field">
          <i class="material-icons prefix">lock</i>
          <input id="contra" type="text" class="validate" data-length="20" required>
          <label for="contra">¿Contraseña?:</label>
        </div>
        <div class="input-field">
          <i class="material-icons prefix">report_problem</i>
          <input id="falla" type="text" class="validate" data-length="100" required>
          <label for="falla">Falla:</label>
        </div>
        <div class="input-field">
          <i class="material-icons prefix">power</i>
          <input id="cables" type="text" class="validate" data-length="50" required>
          <label for="cables">Cables:</label>
        </div>
      </div>
    </form>
      <a onclick="insert_dis();" class="waves-effect waves-light btn pink right"><i class="material-icons right">send</i>ENVIAR</a>
    
  </div> 
</div><br>
</body>
</main>
</html>
