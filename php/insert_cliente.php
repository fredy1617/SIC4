<?php 
include('../php/conexion.php');
include('is_logged.php');
date_default_timezone_set('America/Mexico_City');

$Nombres = $conn->real_escape_string($_POST['valorNombres']);
$Telefono = $conn->real_escape_string($_POST['valorTelefono']);
$Comunidad = $conn->real_escape_string($_POST['valorComunidad']);
$Direccion = $conn->real_escape_string($_POST['valorDireccion']);
$Referencia = $conn->real_escape_string($_POST['valorReferencia']);
$Paquete = $conn->real_escape_string($_POST['valorPaquete']);
$Abono = $conn->real_escape_string($_POST['valorAbono']);
$Descuento = $conn->real_escape_string($_POST['valorDescuento']);
if ($Descuento == "") {
	$Descuento = 0;
}
$Registro = date('Y-m-d');

$sql_instalacion = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM comunidades WHERE id_comunidad=$Comunidad"));


$precioInstalacion = $sql_instalacion['instalacion'];
$totalInstalacion = $precioInstalacion - $Descuento;
$id_user = $_SESSION['user_name'];

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";

if($Descuento > $precioInstalacion){
$mensaje = '<script >M.toast({html:"Solo puedes descontar $'.$precioInstalacion.'.00 pesos.", classes: "rounded"})</script>';
}else{
	if (isset($Nombres)) {
	 	$sql_consulta = "SELECT * FROM clientes WHERE nombre='$Nombres' AND telefono='$Telefono' AND lugar='$Comunidad' AND direccion='$Direccion' AND referencia='$Referencia'";
	 	$consultaBusqueda = mysqli_query($conn, $sql_consulta);
	 	if(mysqli_num_rows($consultaBusqueda)>0){
	 		$mensaje = '<script >M.toast({html:"Ya se encuentra un cliente con los mismos datos registrados.", classes: "rounded"})</script>';
	 	}else{
			//o $consultaBusqueda sea igual a nombre + (espacio) + apellido
			$sql = "INSERT INTO clientes (nombre, telefono, lugar, direccion, referencia, total, dejo, paquete, fecha_registro,registro) 
				VALUES('$Nombres', '$Telefono', '$Comunidad', '$Direccion', '$Referencia', '$totalInstalacion', '$Abono', '$Paquete', '$Registro','$id_user')";
			if(mysqli_query($conn, $sql)){
				$mensaje = '<script >M.toast({html:"La instalación se dió de alta satisfactoriamente.", classes: "rounded"})</script>';
				echo "<script>window.open('../php/folioCliente.php', '_blank')</script>";
			}else{
				$mensaje = '<script >M.toast({html:"Ha ocurrido un error.", classes: "rounded"})</script>';	
			}
		}

	}
}
echo $mensaje;
mysqli_close($conn);
?>