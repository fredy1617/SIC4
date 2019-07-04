<!DOCTYPE html>
<html>
<head>
	<title>SIC | Clientes</title>
<?php 
include('fredyNav.php');

#___________CHECK DE PROMESAS DE PAGO VENCIDAS______________
include('../php/conexion.php');
date_default_timezone_set('America/Mexico_City');
$Hoy = date('Y-m-d');
$sql = mysqli_query($conn, "SELECT * FROM deudas WHERE hasta is not null");

if (mysqli_num_rows($sql)>0) {
	while ($deuda = mysqli_fetch_array($sql)) {
		$Hasta = $deuda['hasta'];
		$Tipo = $deuda['tipo'];
		if ($Hasta >= $Hoy AND $Tipo = 'Mensualidad') {
			echo "Crear el reporte <br>";	
			echo "Borrar Pago <br>";
			echo "Borrar deuda<br>";	
		}
		//mysqli_query($conn, "INSERT INTO ");
	}
}
#__________________________________________________________
#__________________________________________________________
?>
<script >
	function buscar() {
    var texto = $("input#busqueda").val();

	$.post("../php/valida.php", {
          texto: texto,
        }, function(mensaje) {
            $("#datos").html(mensaje);
        }); 
	};
</script>
</head>
<body onload="buscar();">
	<div class="container">
		<div class="row">
			<br><br>
			<h3 class="hide-on-med-and-down col s12 m5 l5">Clientes:</h3>
      		<h5 class="hide-on-large-only col s12 m5 l5">Clientes:</h5>

      		<form class="col s12 m7 l7">
		      <div class="row">
		        <div class="input-field col s12">
		          <i class="material-icons prefix">search</i>
		          <input id="busqueda" name="busqueda" type="text" class="validate" onkeyup="buscar();">
		          <label for="busqueda">Buscar(C-Comunidad, #Cliente, Nombre, Ip*172.128.145.234)</label>
		        </div>
		      </div>
		    </form>
		</div>
		<div class="row">
			<table class="bordered highlight centered responsive-table">
			    <thead>
			      <tr>
			      	<th># Cliente</th>
			        <th>Nombre</th>
			        <th>Comunidad</th>
			        <th>Pago</th>
			        <th>Reporte</th>
			        <th>Credito</th>
			      </tr>
			    </thead>
			    <tbody id="datos">
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>