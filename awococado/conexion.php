<?php
    include(__DIR__ . '/../core/variables.php');
    date_default_timezone_set('America/Mexico_City');
	$enlaceBitacora=mysqli_connect($host.":".$puerto, $usuarioB, $contraseñaB, $bdB);
	$enlace=mysqli_connect($host.":".$puerto, $usuarioA, $contraseñaA, $bdA);

	if (mysqli_connect_errno()){
		$sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Conexión", "", "No se pudo realizar la conexión a la base de datos", "'.mysqli_connect_error().'")';
        mysqli_query($enlaceBitacora,$sql);
        exit();
	}
	
	try{
        $conexion = new PDO('mysql:host=localhost:3307;dbname='.$bdA.';charset=utf8', $usuarioA, $contraseñaA);
    } catch (Exception $e){
        $sql = 'insert into errores values (null, CONVERT_TZ(NOW(),"+00:00","-06:00"), "Conexión", "", "No se pudo realizar la conexión a la base de datos", "'.$e->getMessage().'")';
        mysqli_query($enlaceBitacora,$sql);
        exit();
    }
?>