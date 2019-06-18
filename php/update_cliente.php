<?php 
include('../php/conexion.php');
date_default_timezone_set('America/Mexico_City');
$IdCliente = $conn->real_escape_string($_POST['valorIdCliente']);
$Nombres = $conn->real_escape_string($_POST['valorNombres']);
$Telefono = $conn->real_escape_string($_POST['valorTelefono']);
$Comunidad = $conn->real_escape_string($_POST['valorComunidad']);
$Direccion = $conn->real_escape_string($_POST['valorDireccion']);
$Referencia = $conn->real_escape_string($_POST['valorReferencia']);
$Paquete = $conn->real_escape_string($_POST['valorPaquete']);
$IP = $conn->real_escape_string($_POST['valorIP']);
$FechaCorte = $conn->real_escape_string($_POST['valorFechaCorte']);
$Tipo = $conn->real_escape_string($_POST['valorTipo']);


//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";
if(filter_var($IP, FILTER_VALIDATE_IP)){
	$Contratro = 0;
	$Prepago = 1;
	if ($Tipo == 1) {
		$Contratro = 1;
		$Prepago = 0;		
	}
	$sql = "UPDATE clientes SET nombre = '$Nombres', telefono = '$Telefono', lugar = '$Comunidad', direccion = '$Direccion', referencia = '$Referencia', paquete = '$Paquete', ip = '$IP', fecha_corte = '$FechaCorte', contrato = '$Contratro', Prepago = '$Prepago' WHERE id_cliente = $IdCliente ";
	if ($Tipo == "") {
	$sql = "UPDATE clientes SET nombre = '$Nombres', telefono = '$Telefono', lugar = '$Comunidad', direccion = '$Direccion', referencia = '$Referencia', paquete = '$Paquete', ip = '$IP', fecha_corte = '$FechaCorte' WHERE id_cliente = $IdCliente";
	}
	
	if(mysqli_query($conn, $sql)){
		$mensaje = '<script>M.toast({html :"Se ha actualizado la informacion correctamente.", classes: "rounded"})</script>';
		
		echo '<script>recargar2()</script>';
	}else{
		$mensaje = '<script>M.toast({html :"Ha ocurrido un error.", classes: "rounded"})</script>';	
	}
}else{
	$mensaje = '<script>M.toast({html :"Por favor ingrese una IP valida.", classes: "rounded"})</script>';	
}

echo $mensaje;
mysqli_close($conn);
?>