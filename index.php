<?php
	require 'config/config.php';
	require 'config/database.php';
	$db = new Database();
	$con = $db->conectar();
	$sql = $con->prepare("SELECT id,nombre,precio,descuento FROM productos WHERE activo=1"); /*si es 0 el producto no se mostrara*/
	$sql->execute();
	$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
	//session_destroy();
	//print_r($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,user-scalable=no">
	<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> <!--...link iconos...-->
	<link rel="stylesheet" type="text/css" href="tienda.css">
	<link href="https://fonts.googleapis.com/css2?family=Koulen&family=Poppins:ital,wght@1,800&family=Source+Code+Pro:wght@200&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
	<link rel="icon" type="img/png" href="images1/1imag.jpg">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
	<!-- Boxicons CDN Link -->
	<!-- CSS only -->
	<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">-->
	<title>TIENDA</title>
</head>
<body>
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
		<div class="container-slider">
			<div class="slider" id="slider">
				<div class="slider__section">
					<img src="images1/1imag.jpg" class="slider__img">
					<div class="slider__content">
						<h2 class="slider__title">Elementos WEB Exclusivos </h2>
						<p class="slider__txt">Html , Css y Javascript</p>
						<a href="#MC" class="btn-shop">Comprar Ahora</a>
					</div>
				</div>
				<div class="slider__section">
					<img src="images1/2imag.jpg" class="slider__img"></img>
					<div class="slider__content">
						<h2 class="slider__title">Lo Mejor en Cars</h2>
						<p class="slider__txt">Para tus presentaciones</p>
						<a href="#MC" class="btn-shop">Comprar Ahora</a>
					</div>
				</div>
				<div class="slider__section">
					<img src="images1/3imag.png" class="slider__img"></img>
					<div class="slider__content">
						<h2 class="slider__title">Elementos Increibles</h2>
						<p class="slider__txt">Descuentos hasta 20%</p>
						<a href="#MC" class="btn-shop">Comprar Ahora</a>
					</div>
				</div>
				<div class="slider__section">
					<img src="images1/4imag.jpg" class="slider__img"></img>
					<div class="slider__content">
						<h2 class="slider__title">OBTEN TU PAGINA WEB</h2>
						<p class="slider__txt">Descuento hasta 40%</p>
						<a href="" class="btn-shop">Comprar Ahora</a>
					</div>
				</div>
				<div class="slider__btn slider__btn--right" id="btn-right">&#62;</div>
				<div class="slider__btn slider__btn--left" id="btn-left">&#60;</div>
			</div>  
		</div>
	</div>
	<!-- lo puedo traer los nombres , precio ,etc de base de datos-->
	<div class="container">
		<main class="main">
		
			<h2 class="main-title"><i class="bi bi-lightning-charge-fill"></i>My Collection<hr></h2>
			
			<div class="container1">
			
					<?php foreach ($resultado as $row) { ?>
					<section class="container-productos">
						<div id="MC"class="product" >
							<?php
								$descuento = $row['descuento'];
								$precio = $row['precio'];
								$precio_desc = $precio - (($precio * $descuento) / 100);
								$id = $row['id'];
								$imagen = "images1/producto/" . $id . "/principal.jpeg";
								if(!file_exists($imagen)){
									$imagen= "images1/no-photo.jpg";
								}
							?>
							<img src="<?php echo $imagen; ?>" class="product__img"></img>
							
							<div class="iuno">
								<img src="images1/java.png" alt="">
								<i class="bi bi-shield-fill-check"></i>
							</div>
							<div class="idos">
								<img src="images1/html.png" alt="">
							</div>
							<div class="itres">
								<img src="images1/css3.png" alt="">
							</div>
							<div class="product__description">
								<h3 class="product__title"><?php echo $row['nombre']; ?></h3>
								<span class="product__price"><del><?php echo number_format($row['precio'],2,'.',','); ?> USD</del></span>
								<p class="cuantos">1/1</p>				        
							</div>
							<div class="moneda">
								<?php if($descuento > 0){ ?>
		
								<div class="monedauno">
								
								<p><?php echo $descuento; ?>% descuento</p>
								</div>
								<?php } else {  ?>

								<p class="product__price"><?php echo MONEDA . number_format($precio,'2','.',','); ?></p>
								<?php } ?>
    						</div>
							<div class=" uno">
							<a title="Info" href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha512',$row['id'],KEY_TOKEN); ?>"><i class="bi bi-info product__icon"></i></a>
							</div>
							<div class=" dos">
							<i class="product__icon bi bi-bag-plus" title="Añadir al Carrito" onclick="addProducto(<?php echo $row['id']; ?> ,'<?php echo hash_hmac('sha512',$row['id'],KEY_TOKEN); ?>')"></i>
							</div>
					</section>
				<?php } ?>
			</div>
		
			<section class="container__testimonials">				
					<div class="card ">					
						<div class="card uno">
							<div class="card_load"><img src="images1/1cara.jpg" alt=""></div>
							<div class="card_load_extreme_title"><p>Jorge bryns </p> </div>
							<div class="card_load_extreme_descripion"><p>Gracias...!! Que sigan los exitos , muy buenas creaciones</p> </div>
						</div>
						<div class="card uno">
							<div class="card_load"><img src="images1/2cara.jpg" alt=""></div>
							<div class="card_load_extreme_title"><p>Ramsul J. </p> </div>
							<div class="card_load_extreme_descripion"><p>Lo mejor son los diseños exitos..!!!</p> </div>
						</div>
						<div class="card uno">
							<div class="card_load"><img src="images1/3cara.jpg" alt=""></div>
							<div class="card_load_extreme_title"><p>Karem Cruz </p> </div>
							<div class="card_load_extreme_descripion"><p>Los Mejores y mas modernos codigos gracias amigo..!!</p> </div>
						</div>
					</div>					
			</section>
			<div class="container-editor">
				<div class="editor__item">
					<img  src="images1/1imag.jpg" alt="" class="editor__img">
					<p class="editor__circle">HTML , CSS y JAVA</p>
				</div>
				<div class="editor__item">
					<img  src="images1/2imag.jpg" alt="" class="editor__img">
					<p class="editor__circle">Lo nuevo en Tendencia</p>
				</div>
			</div>
			<section class="container-tips">
				<div class="tip">
					<i class="fa-solid fa-hand"></i>
					<h2 class="tip__title">Satisfacción Garantizada</h2>
					<p class="tip__text">Te garanterizamos que tu sitio web se va a ver mas Moderno </p>
					
				</div>
				<div class="tip">
					<i class="fa-solid fa-rocket"></i>
					<h2 class="tip__title">Descargalo Rapido</h2>
					<p class="tip__text">Facil instalacion , copia el codigo y listo</p>
			
				</div>
				<div class="tip">
					<i class="fa-solid fa-gear"></i>
					<h2 class="tip__title">Actualizacion</h2>
					<p class="tip__text">Trabajamos en traerte lo nuevo en diseño de Elementos Web</p>
					
				</div>
			</section>
		</div>
		</main>
	</div>
	<footer class="main-footer">

	</footer>
	<script src="slider.js"></script>
</body>
</html>