<?php
    require '../config/config.php';
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        //$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 1;
        $token = $_POST['token'];
        $token_tmp = hash_hmac('sha512',$id,KEY_TOKEN);
        //if($token == $token_tmp && $cantidad > 0 && is_numeric($cantidad)){
            if($token == $token_tmp){
            if(isset($_SESSION['carrito']['productos'][$id])){
                //$_SESSION['carrito']['productos'][$id] += $cantidad;
                $_SESSION['carrito']['productos'][$id] = 1;
            }else{
                //$_SESSION['carrito']['productos'][$id] = $cantidad;
                $_SESSION['carrito']['productos'][$id] = 1;
            }
            $datos['numero'] = count( $_SESSION['carrito']['productos']);
            $datos['ok']=true;
        } else {
            $datos['ok'] = false;
        }   
    }else{
        $datos['ok']=false;
    }
    echo json_encode($datos);