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
			//session_destroy();
			//print_r($_SESSION);
		}
	}	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,user-scalable=no">
	<link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> <!--...link iconos...-->
	<link rel="stylesheet" type="text/css" href="checkout.css">
	<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@500&family=Roboto&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Koulen&family=Poppins:ital,wght@1,800&family=Source+Code+Pro:wght@200&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
	<link rel="icon" type="img/png" href="images1/1imag.jpg">
	<!-- Boxicons CDN Link -->
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<title>checkout</title>
</head>
<body>
<img src="images/CODE.png" alt="" class="principal">
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
	<div class="container">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Producto</th>
						<th>Precio</th>
						<th>Cantidad</th>
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
					<td><?php echo MONEDA . number_format($precio_desc,2,'.',',');?></td>
					<td>
						<input type="number" min="1" max="1" step="1" value="<?php echo $cantidad ?>" size="5" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
					</td>
					<td>
						<div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,'.',',');?>
						</div>
					</td>   
					<td><a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id; ?>"data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a></td>
					
				</tr>
				<?php } ?>
				<tr>
					<td colspan="3"></td>
					<td colspan="2">
						<p class="h3" id="total"><?php echo MONEDA . number_format($total,2,'.',',');?></p>
					</td>
				</tr>	
			</tbody>
			<?php } ?>	
			</table>
		</div>
		<?php if ($lista_carrito != null) { ?>
		<div class="row">
			<div class="col-md-5 offset-md-7 d-grid gap-2">
				<a href="pago.php" class="btn btn-primary btn-lg">Realizar Pago</a>
			</div>
		</div>
		<?php } ?>
	</div>


	<!-- Modal -->
		<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="eliminaModalLabel">ALERTA ... !!		</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						¿ Desea Eliminar el Producto de la lista ?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
						<button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">ELIMINAR</button>
					</div>
				</div>
			</div>
		</div>
		<script>

		/*...........Actualizacion Producto...........*/
		function actualizaCantidad(cantidad,id){
			let url = 'clases/actualizar_carrito.php'
			let formData = new FormData()
			formData.append('action','agregar') //formData.append('action',agregar)
			formData.append('id',id)
			formData.append('cantidad',cantidad)

			fetch(url,{
				method:'POST',
				body:formData,
				mode:'cors'
			}).then(response  => response.json())
			.then(data =>{
				if(data.ok){
					let divsubtotal = document.getElementById('subtotal_' + id)
					divsubtotal.innerHTML = data.sub;
					let total = 0.00
					let list = document.getElementsByName('subtotal[]')
					for(let i=0; i < list.length; i++){
						total += parseFloat(list[i].innerHTML.replace(/[$,]/g,''))
					}
					total = new Intl.NumberFormat('en-US',{
						minimumFractionDigits: 2
					}).format(total)
					document.getElementById('total').innerHTML='<?php echo MONEDA; ?>'+total 
				}
			})
		}	
		/*............Elimina Modal.........*/
		let eliminaModal = document.getElementById('eliminaModal')
		eliminaModal.addEventListener('show.bs.modal',function(event){
			let button = event.relatedTarget
			let id = button.getAttribute('data-bs-id')
			let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
			buttonElimina.value = id
		})
		function eliminar() {
			let botonElimina = document.getElementById('btn-elimina')
			let id = botonElimina.value	
			let url = 'clases/actualizar_carrito.php'
			let formData = new FormData()
			formData.append('action','eliminar') //formData.append('action',agregar)
			formData.append('id',id)

			fetch(url,{
				method:'POST',
				body:formData,
				mode:'cors'
			}).then(response  => response.json())
			.then(data =>{
				if(data.ok){
					location.reload()
				}
			})
		}	
	</script>
	<!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>	
</body>
</html>