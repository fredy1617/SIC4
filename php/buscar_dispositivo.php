<?php
	include('conexion.php');

	$Texto = $conn->real_escape_string($_POST['texto']);

	//Filtro anti-XSS
	$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
	$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");

	$Texto = str_replace($caracteres_malos, $caracteres_buenos, $Texto);

	//Variable vacía (para evitar los E_NOTICE)
	$mensaje = "";

	$sql = "SELECT * FROM dispositivos LIMIT 25";

	if ($Texto != "") {
		$sql="SELECT * FROM dispositivos WHERE (nombre LIKE '%$Texto%' OR  id_dispositivo = '$Texto') LIMIT 25";
	}
	$consulta = mysqli_query($conn, $sql);
	//Obtiene la cantidad de filas que hay en la consulta
	$filas = mysqli_num_rows($consulta);

	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas == 0) {
		$mensaje = "<script>M.toast({html: 'No se encontraron dispositivos.', classes: 'rounded'})</script>";
	} else {

		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		while($resultados = mysqli_fetch_array($consulta)) {

			$id_dispositivo = $resultados['id_dispositivo'];
			$nombre = $resultados['nombre'];
			$telefono = $resultados['telefono'];
			$marca = $resultados['marca'];
			$contra = $resultados['contra'];
			$falla = $resultados['falla'];
			$fecha = $resultados['fecha'];
			$estatus =$resultados['estatus'];

			//Output
			$mensaje .= '			
		          <tr>
		            <td>'.$id_dispositivo.'</td>
		            <td>'.$nombre.'</td>
		            <td>'.$telefono.'</td>
		            <td>'.$marca.'</td>
		            <td>'.$contra.'</td>
		            <td>'.$falla.'</td>
		            <td>'.$fecha.'</td>
		            <td>'.$estatus.'</td>           
		          </tr>';

		}//Fin while $resultados
	} //Fin else $filas


//Devolvemos el mensaje que tomará jQuery
echo $mensaje;
mysqli_close($conn);
?>