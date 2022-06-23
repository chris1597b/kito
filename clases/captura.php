<?php
	require '../config/config.php';
	require '../config/database.php';
	$db = new Database();
	$con = $db->conectar();

    
    if($id>0){
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null; 
		unset($_SESSION['carrito']); 
    }session_destroy();