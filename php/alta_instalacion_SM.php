<?php
date_default_timezone_set('America/Mexico_City');
include('../php/conexion.php');
include_once('../API/api_mt_include2.php');
$IP = $_POST['valorIP'];
$filtrarMaterial = $_POST['valorMaterial'];
$filtrarObservacion = $_POST['valorObservacion'];
$filtrarIdCliente = $_POST['valorIdCliente'];
$filtrarTecnico = $_POST['valorTecnicos'];
$filtrarTipo = $_POST['valorTipo'];

//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");

$Material = str_replace($caracteres_malos, $caracteres_buenos, $filtrarMaterial);
$Observacion = str_replace($caracteres_malos, $caracteres_buenos, $filtrarObservacion);
$IdCliente = str_replace($caracteres_malos, $caracteres_buenos, $filtrarIdCliente);
$Tecnico = str_replace($caracteres_malos, $caracteres_buenos, $filtrarTecnico);
$Tipo = str_replace($caracteres_malos, $caracteres_buenos, $filtrarTipo);
$FechaInstalacion = date('Y-m-d');
$Hora = date('h:i:s');

$Contrato = 0;
$Prepago = 1;
if ($Tipo == 1) {
	$Contrato = 1;
	$Prepago = 0;
}
echo $Contrato;
if (filter_var($IP, FILTER_VALIDATE_IP)) {
	$sql_ip = "SELECT * FROM clientes WHERE ip='$IP'";
	if(mysqli_num_rows(mysqli_query($conn, $sql_ip))>0){
		echo '<script>M.toast({html:"Esta IP ya se encuentra asignada a un cliente.", classes: "rounded"})</script>';
	}else{
		//Buscamos el paquete
		$id_paquete1 = mysqli_fetch_array(mysqli_query($conn, "SELECT nombre, paquete FROM clientes WHERE id_cliente=$IdCliente"));
		$id_paquete = $id_paquete1['paquete'];
		$paquete = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM paquetes WHERE id_paquete=$id_paquete"));
		$limite = $paquete['subida']."/".$paquete['bajada'];
		//Buscamos el servidor
		$sql_lugar = mysqli_fetch_array(mysqli_query($conn, "SELECT lugar FROM clientes WHERE id_cliente=$IdCliente"));
		$lugar = $sql_lugar['lugar'];
		$sql_servidor = mysqli_fetch_array(mysqli_query($conn, "SELECT servidor, nombre FROM comunidades WHERE id_comunidad=$lugar"));
		$servidor = $sql_servidor['servidor'];
		$comunidad = $sql_servidor['nombre'];
		$datos = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM servidores WHERE id_servidor=$servidor"));

		$nombre_completo = $id_paquete1['nombre'];
		//////// configura tus datos		
		            $sql="UPDATE clientes SET ip='$IP', material='$Material', tecnico='$Tecnico', instalacion=1, fecha_instalacion='$FechaInstalacion', fecha_corte='$FechaInstalacion', contrato = '$Contratro', Prepago = '$Prepago', hora_alta = '$Hora' WHERE id_cliente=$IdCliente";
		            
		        	if(mysqli_query($conn, $sql)){                     
		            echo '<script>M.toast({html:"Cliente registrado.", classes: "rounded"})</script>';
		            echo '<script>M.toast({html:"Favor de dar de alta en el servidor al cliente.", classes: "rounded")</script>';
		            echo '<script>function recargar() {
						    setTimeout("location.href="../views/instalaciones.php"", 1000);
						  }</script>';
					echo '<script>recargar()</script>';
				}else{
					echo '<script>M.toast({html:"Ocurrio un error.", classes: "rounded"})</script>';
				}
		        }        
}else{
	echo '<script>M.toast({html:"Formato de IP incorrecto, por favor escriba una IP válida.", classes: "rounded"})</script>';
}

mysqli_close($conn);
?>