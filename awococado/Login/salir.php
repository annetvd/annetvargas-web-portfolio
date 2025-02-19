<?php
	session_start();
	unset($idUsuario);
	unset($nombre);
	unset($descripcion);
	session_destroy();
	require "../../core/variables.php";
	// header("location: https://awococado.$hostName/");
	header("location: http://$hostName/awococado/index.php");
?>