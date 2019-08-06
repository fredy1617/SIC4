<?php 
	include ('conexion.php');
	$Texto = $conn->real_escape_string($_POST['texto']);
	//Filtro anti-XSS
	$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
	$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");

	$Texto = str_replace($caracteres_malos, $caracteres_buenos, $Texto);
	$id_comunidad = $Texto;
	$ver = explode("-", $Texto);
	$SiIp = explode("*", $Texto);
	$ip = "";
	$limite = 'Limit 20';
	if (count($ver) > 1) {
		$nombre= $ver[1];

		$consulta = mysqli_query($conn, "SELECT * FROM comunidades WHERE nombre LIKE '%$nombre%'Limit 1");
		$filas = mysqli_num_rows($consulta);
		if ($filas == 0) {
		$mensaje = '<script>M.toast({html:"No se encontraron comunidades.", classes: "rounded"})</script>';
		} else {
		  	$comunidad = mysqli_fetch_array($consulta);
		  	$id_comunidad = $comunidad['id_comunidad'];
		  	$limite ='';
		}
	}elseif (count($SiIp)>1) {
		$ip = trim($SiIp[1]);
	}

	$mensaje = '';

	$sql = "SELECT * FROM clientes WHERE instalacion IS NOT NULL $limite";

	if ($Texto != ""){
		$sql = "SELECT * FROM clientes WHERE ip = '$ip' OR lugar LIKE '$id_comunidad' OR nombre LIKE '%$Texto%'  OR   id_cliente LIKE '$Texto'   AND instalacion IS NOT NULL $limite";
	}
	$consulta = mysqli_query($conn, $sql);
	//Obtiene la cantidad de filas que hay en la consulta
	$filas = mysqli_num_rows($consulta);

	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	$filas2 = 1;
	if ($filas == 0) {
		$sql2 = "SELECT * FROM especiales WHERE nombre LIKE '%$Texto%'  OR   id_cliente LIKE '$Texto'";
		$consulta = mysqli_query($conn, $sql2);
		//Obtiene la cantidad de filas que hay en la consulta
		$filas2 = mysqli_num_rows($consulta);
	}
	if ($filas2 == 0) {
			$mensaje = '<script>M.toast({html:"No se encontraron clientes.", classes: "rounded"})</script>';
		
	} else {
		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle		
		while($resultados = mysqli_fetch_array($consulta)) {
			$id_comunidad = $resultados['lugar'];
			$sql_comunidad = mysqli_fetch_array(mysqli_query($conn,"SELECT nombre FROM comunidades WHERE id_comunidad = $id_comunidad"));
			$no_cliente = $resultados['id_cliente'];
			$nombre = $resultados['nombre'];
			$servicio = $resultados['servicio'];
			$lugar = $sql_comunidad['nombre'];
			$telefono = $resultados['telefono'];
			$ip = $resultados['ip'];

			//Output
			$mensaje .= '			
		          <tr>
		            <td>'.$no_cliente.'</td>
		            <td><b>'.$nombre.'</b></td>
		            <td><b>'.$servicio.'</b></td>
		            <td>'.$lugar.'</td>
		            <td><form method="post" action="../views/crear_pago.php"><input id="no_cliente" name="no_cliente" type="hidden" value="'.$no_cliente.'"><button class="btn-floating btn-tiny waves-effect waves-light pink"><i class="material-icons">payment</i></button></form></td>
		            <td><form method="post" action="../views/form_reportes.php"><input id="no_cliente" name="no_cliente" type="hidden" value="'.$no_cliente.'"><button class="btn-floating btn-tiny waves-effect waves-light pink"><i class="material-icons">report_problem</i></button></form></td>
		            <td><form method="post" action="../views/credito.php"><input id="no_cliente" name="no_cliente" type="hidden" value="'.$no_cliente.'"><button class="btn-floating btn-tiny waves-effect waves-light pink"><i class="material-icons">credit_card</i></button></form></td>
		          </tr>';     

		}//Fin while $resultados
	} //Fin else $filas

echo $mensaje;
mysqli_close($conn);
?>