<?php 
include('../php/conexion.php');
date_default_timezone_set('America/Mexico_City');
$IdReporte = $conn->real_escape_string($_POST['valorIdReporte']);
$Falla = $conn->real_escape_string($_POST['valorFalla']);
$Solucion = $conn->real_escape_string($_POST['valorSolucion']);
$Tecnico = $conn->real_escape_string($_POST['valorTecnico']);
$Atendido = $conn->real_escape_string($_POST['valorAtendido']);
$Fecha_visita = $conn->real_escape_string($_POST['valorFecha']);
$FechaAtendido = date('Y-m-d');

if($Atendido == 'Sí'){
	$Atendido = '1';	
	$Atender_Visita = '1';
}else{
	$Atendido = '2';
	$Atender_Visita ='2';
} 	
$mas = "";
if ($Fecha_visita != 0) {
	$Atendido = '1';

	$reporte   = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM reportes WHERE id_reporte =$IdReporte"));
	$nombreTecnico  = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM users WHERE user_id = '$Tecnico'"));
	$Array = explode("*", $reporte['descripcion']);
    $descripcion = $Array[0];

    if (count($Array)>1) {
        $descripcion = $Array[1];
    }
	$Nombre = $nombreTecnico['firstname'];
	$mas= ", visita = 1, fecha_visita = '$Fecha_visita', descripcion = '".$Nombre." Tienes una visita el día de HOY. Problema : *".$descripcion." ' , atender_visita = '$Atender_Visita'";
}

//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";

	$sql = "UPDATE reportes SET falla = '$Falla', solucion = '$Solucion', tecnico = '$Tecnico', atendido = '$Atendido', atender_visita = '$Atender_Visita',  fecha_solucion = '$FechaAtendido'".$mas." WHERE id_reporte = $IdReporte";
	if(mysqli_query($conn, $sql)){
		$mensaje = '<script>M.toast({html:"Reporte actualizado correctamente.", classes: "rounded"})</script>';
		echo '<script>
				location.href="../views/reportes.php";
			 </script>';
					echo '<script>recargar_rep()</script>';
	}else{
		$mensaje = '<script>M.toast({html:"Ha ocurrido un error UPDATE.", classes: "rounded"})</script>';	
	}

echo $mensaje;
echo mysqli_error($conn);
mysqli_close($conn);
?>