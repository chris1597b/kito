<?php
	require 'config/config.php';
	require 'config/database.php';
	$db = new Database();
	$con = $db->conectar();
	$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null; 
	$lista_carrito = array();
	if($productos != null){
		foreach ($productos as $clave => $cantidad){
			$sql = $con->prepare("SELECT id,nombre,precio,descuento,$cantidad AS cantidad FROM productos WHERE id=? AND activo=1"); /*si es 0 el producto no se mostrara*/
			$sql->execute([$clave]);
			$lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
	
		}
	}else {
        header("Location: index.php");
		exit;
    }		
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,user-scalable=no">
	<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> <!--...link iconos...-->
	<link rel="stylesheet" type="text/css" href="pago.css">
	<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@500&family=Roboto&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Koulen&family=Poppins:ital,wght@1,800&family=Source+Code+Pro:wght@200&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
	<link rel="icon" type="img/png" href="images1/1imag.jpg">
	<!-- Boxicons CDN Link -->
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<title>pago</title>
</head>
<body>
<img src="images/detalles.png" alt="" class="principal">
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
		<main class="main">
			
				
		</main>
	</div>
	
	<!-- lo puedo traer los nombres , precio ,etc de base de datos-->
	<div class="container mt-2" style="top: 40px;">
        <div class="row">
                <div class="col-6">
                    <h4>Detalles de pago</h4>
					<div id="paypal-button-container"></div>
                </div>  
				<div class="col-6">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Producto</th>
									<th>Subtotal</th>
									<!--<th>Total</th>-->
								</tr>
							</thead>
						

						<tbody>
							<?php if($lista_carrito == null){
								echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
								}else{
									$total = 0;
									foreach($lista_carrito as $producto){
										$_id = $producto['id'];
										$nombre = $producto['nombre'];
										$precio = $producto['precio'];
										$descuento = $producto['descuento'];
										$cantidad = $producto['cantidad'];
										$precio_desc = $precio-(($precio * $descuento) / 100);
										$subtotal = $cantidad * $precio_desc;
										$total += $subtotal;
									
								
							?>	
							<tr>
								<td><?php echo $nombre;?></td>
							
								<td>
									<div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,'.',',');?>
									</div>
								</td>                     
							</tr>
							<?php } ?>
							<tr>
								<td colspan="2">
									<p class="h3 text-end"  id="total"><?php echo MONEDA . number_format($total,2,'.',',');?></p>
								</td>
							</tr>	
						</tbody>
						<?php } ?>	
						</table>
					</div> 
				</div>                       
        </div>
	</div>

	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>	
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&currency=<?php echo CURRENCY; ?>" data-sdk-integration-source="button-factory"></script>
    <script>
        function initPayPalButton() {
        paypal.Buttons({
            style: {
            shape: 'rect',
            color: 'blue',
            layout: 'vertical',
            label: 'pay',
            
            },

            createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{"amount":{"currency_code":"USD","value":<?php echo $total ?>}}]
            });
            },


			onApprove: function(data, actions) {
				let URL = 'clases/captura.php'
				return actions.order.capture().then(function(orderData) {
	
					//REDICIONAMIENTO DE PAGINA
					window.location.href = "completado.php"
					
					
					
				});
			},

            onError: function(err) {
            console.log(err);
            }
        }).render('#paypal-button-container');
        }
        initPayPalButton();
    </script>		
</body>
</html>