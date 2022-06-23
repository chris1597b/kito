<?php
    require 'config/config.php';    
	require 'config/database.php';
	$db = new Database();
	$con = $db->conectar();
    $id = isset($_GET['id']) ? $_GET['id']: '';
    $token = isset($_GET['token']) ? $_GET['token']: '';
    if($id == '' || $token == ''){
        echo '-----------------ERROR AL PROCESAR LA PETICION------------------';
        exit;
    }else{
        $token_tmp = hash_hmac('sha512',$id,KEY_TOKEN);
        if($token == $token_tmp){
            $sql = $con->prepare("SELECT count(id) FROM productos WHERE id=? AND  activo=1"); /*si es 0 el producto no se mostrara*/
            $sql->execute([$id]);
            if($sql->fetchColumn() > 0){
                $sql = $con->prepare("SELECT nombre, descripcion, precio, descuento, paypal FROM productos WHERE id=? AND  activo=1 LIMIT 1"); /*si es 0 el producto no se mostrara*/
                $sql->execute([$id]);
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $nombre = $row['nombre'];
                $descripcion = $row['descripcion'];
                $precio = $row['precio'];
                $descuento = $row['descuento'];
                $paypal = $row['paypal'];
                $precio_desc = $precio - (($precio * $descuento) / 100);
                $dir_images = 'images1/producto/' . $id . '/';
                $rutaImg = $dir_images . 'principal.jpeg';
                $dir_images1 = 'images1/producto/' . $id . '/';
                $rutaImg1 = $dir_images1 . 'prueba.jpeg';

                if(!file_exists($rutaImg)){
                    $rutaImg = 'images1/no-photo.jpg';
                }
                $imagenes1 = array();
                if(file_exists($dir_images1)){
                    $dir = dir($dir_images1);
                    while(($archivo = $dir->read()) != false){
                        if($archivo != 'prueba.jpeg' && (strpos($archivo,'jpg'))|| strpos($archivo, 'jpg')){
                            $imagenes1[] = $dir_images1 . $archivo; 
                        }
                    }
                    $dir->close();
                }
            
                if(!file_exists($rutaImg)){
                    $rutaImg = 'images1/no-photo.jpg';
                }
                $imagenes = array();
                if(file_exists($dir_images)){
                    $dir = dir($dir_images);
                    while(($archivo = $dir->read()) != false){
                        if($archivo != 'principal.jpeg' && (strpos($archivo,'jpeg')) && strpos($archivo, 'jpg')|| strpos($archivo, 'mp4')){
                            $imagenes[] = $dir_images . $archivo; 
                        }
                    }
                    $dir->close();
                }
            }
        }else{
            echo '-----------------ERROR AL PROCESAR LA PETICION--------------'; 
            exit;  
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,user-scalable=no">
	<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> <!--...link iconos...-->
	<link rel="stylesheet" type="text/css" href="detalles.css">
	<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@500&family=Roboto&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Koulen&family=Poppins:ital,wght@1,800&family=Source+Code+Pro:wght@200&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
	<link rel="icon" type="img/png" href="images1/1imag.jpg">
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Shade&display=swap" rel="stylesheet">
	
    <link href="https://fonts.googleapis.com/css2?family=Righteous&family=Rubik+Glitch&display=swap" rel="stylesheet"><link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <title>detalles</title>
</head>
<body>
    
    <div class="tree">
        <div class="boton_video">
                        <button onclick="playPause(),divLogin()"><p id="play" >PLAY</p></button> 
            <div class="video" >
                    <?php foreach ($imagenes as $img) { ?>
                        
                            <video id="video1"  muted>
                                <source src="<?php echo $img;?>" type="video/mp4">
                            </video>  

                    <?php } ?> 
            </div> 
        </div>
        <img src="images1/CODE.jpg" alt="" class="principal">
        <header class="bar-menu">
            <div class="siderbar">		
                <div class="siderbar active">
                    <div class="logo">
                        <a href="index.php" ><i  class="fa-brands fa-korvue"></i></a>
                        <a href="index.php" > kito </a>
                    </div>
                    <ul class="nav_list">
                        <li>
                            <a href="#">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" placeholder="Buscar.." name="">
                            </a>					
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa-solid fa-user-astronaut"></i>
                                <span class="links_name">User</span>
                            </a>			
                        </li>
                        <li>
                            <a href="index.html">
                                <i class="fa-brands fa-kickstarter-k"></i>
                                <span class="links_name">Inicio</span>
                            </a>			
                        </li>
                        <li>
                            <a href="index.php">
                            <i class="fa-solid fa-store"></i>
                                <span class="links_name">Tienda</span>
                            </a>			
                        </li>
                        <li id="uno">
                            <a href="checkout.php">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="links_name" id="cars">carrito <span id="num_cart"  ><?php echo $num_cart; ?></span></span>
                            </a>
                        </li>
                    </ul>
                    <div class="profile_content">
                        <div class="profile">
                            <div class="profile_details">
                                <img src="images1/cris.jpg" alt="">
                                <div class="name_job">
                                    <div class="name">CHRISTOPHER</div>
                                    <div class="job">Web designer</div>
                                </div>
                            </div>	
                            <i class="fa-solid fa-hand-point-left" id="log_out"></i>
                        </div>
                    </div>
                </div>		
            </div>
        </header>
        <div class="container">
            <ul class="thumb">
                <li onmouseover="changeImageSrc('<?php echo $rutaImg;?>')"><img src="<?php echo $rutaImg;?>"></li>
                <?php foreach ($imagenes1 as $img) { ?>  
                <li onmouseover="changeImageSrc('<?php echo $img;?>')"><img src="<?php echo $img;?>"></li>

            <?php } ?> 
            </ul>
            <div class="imgbox">
                
                <ul class="figura">
                    <!--<li><i class="fa-regular fa-bookmark"></i></li>
                    <li><i class="fa-regular fa-heart"></i></li>-->
                </ul>
                
                <h2 class="title"><?php echo $nombre; ?></h2>

                <img  id="demo" src="<?php echo $rutaImg;?>" class="shoesss">
                
                <ul class="size" src="<?php echo $rutaImg;?>">

                    <li><a href="https://www.facebook.com/christopher.bardales.12"><i class="fa-brands fa-facebook-square"></i></a></li>
                    <li><a href="https://api.whatsapp.com/send/?phone=936102987&text&app_absent=0"><i class="fa-brands fa-whatsapp"></i></a></li>
                    <li> <a href="https://www.instagram.com/christopher_7798/"><i class="fa-brands fa-instagram"></i></a></li>
        
                </ul>

                <!--<button class="btn btn-outline-primary" type="button" onclick="addProducto('<?php echo $id; ?>','<?php echo $cantidad; ?>,' '<?php echo $token_tmp; ?>')"> Agregar al carrito </button>
                -->
            </div>

            <div class="detalles">
                <h2 class="title"><?php echo $nombre; ?></h2>
                <p class="description"><?php echo $descripcion; ?></p>
                <div class="moneda">
                    <?php if($descuento > 0){ ?>
                        <p><del><?php echo MONEDA . number_format($precio,'2','.',','); ?></del></p>
                        <h2>
                            <?php echo MONEDA . number_format($precio_desc,'2','.',','); ?>
                            <small><?php echo $descuento; ?>% descuento</small>
                        </h2>
                        <?php } else {  ?>

                    <span class="product__price"><?php echo MONEDA . number_format($precio,'2','.',','); ?></span>
                    <?php } ?>
                </div>
                
                <div class="boton" style="text-align: center;" ><?php echo $paypal; ?></div>
                <div class="botkojklñn">
                   
            
            </div>          
        </div>
    </div>
            


	<!-- JavaScript Bundle with Popper
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>	 -->	
	<script src="detalles.js"></script>
    
</body>
</html>