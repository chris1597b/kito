/*...........Producto...........*/
function addProducto(id,cantidad,token){
    let url = 'clases/carrito.php'
    let formData = new FormData()
    formData.append('id',id)
    formData.append('cantidad',cantidad)
    formData.append('token',token)

    fetch(url,{
        method:'POST',
        body: formData,
        mode:'cors',
    }).then(response  => response.json())
    .then(data =>{
        if(data.ok){
            let elemento = document.getElementById("num_cart");
            elemento.innerHTML  = data.numero;
        }
    })
}
//.....Detalles..//
function changeImageSrc(anything){
	document.querySelector('.shoesss').src = anything;
} 
//.....video......//
var myVideo = document.getElementById("video1"); 

function playPause() { 
  if (myVideo.paused) 
    myVideo.play(); 
  else 
    myVideo.pause(); 
} 


