<!DOCTYPE html>
<html>
<head>
	<title>SIC | Reporte de Refacciones</title>
<?php
include ('fredyNav.php');
?>
</head>
<body>
	<div class="container">
		<div class="row">
			<h3 class="hide-on-med-and-down">Reporte de Refacciones:</h3>	
			<h5 class="hide-on-large-only">Reporte de Refacciones:</h5>	
		</div>
		<div class="row">
			<div class="col s12 l5 m5">
                <label for="fecha_de">De:</label>
                <input id="fecha_de" type="date" >    
            </div>
            <div class="col s12 l5 m5">
                <label for="fecha_a">A:</label>
                <input id="fecha_a" type="date" >
            </div><br>
            <div>
                <button class="btn waves-light waves-effect right pink" onclick="buscar_refacciones();"><i class="material-icons prefix">send</i></button>
            </div>
		</div>
		<div class="row">
			<table lass="bordered highlight responsive-table" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Descripcion</th>
						<th>Cantidad</th>
						<th>Cliente</th>
						<th>Telefono</th>
						<th>Dispositivo</th>
					</tr>		
				</thead>
				<tbody id="datos">
					
				</tbody>
			</table>			
		</div>
	</div>
</body>
</html>