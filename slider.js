const slider = document.querySelector("#slider");
let sliderSection =  document.querySelectorAll(".slider__section");
let sliderSectionLast =  sliderSection[sliderSection.length -1];

const btnLeft = document.querySelector("#btn-left");
const btnRight = document.querySelector("#btn-right");

slider.insertAdjacentElement('afterbegin',sliderSectionLast);

function Next(){
	 let sliderSectionFirst = document.querySelectorAll(".slider__section")[0];
	 slider.style.marginLeft = "-200%";
	 slider.style.transition = "all 0.5s"; /* varian el tiempo de cambio de imagen*/
	 setTimeout(function(){
	 	slider.style.transition = "none";
	 	slider.insertAdjacentElement('beforeend',sliderSectionFirst);
	 	slider.style.marginLeft = "-100%";
	 },500);
	}
	
	function Prev(){
	 let sliderSection = document.querySelectorAll(".slider__section");
	 let sliderSectionLast =  sliderSection[sliderSection.length -1];
	 slider.style.marginLeft = "0";
	 slider.style.transition = "all 0.5s"; /* varian el tiempo de cambio de imagen*/
	 setTimeout(function(){
	 	slider.style.transition = "none";
	 	slider.insertAdjacentElement('afterbegin',sliderSectionLast);
	 	slider.style.marginLeft = "-100%";
	 },500);
	}
	btnRight.addEventListener('click',function(){
		Next();
	});
	btnLeft.addEventListener('click',function(){
		Prev();
	});

	/* ........cambio automatico........*/

	setInterval(function(){
		Next();
	},5000);/* 5 segundos=5000*/
/*...........Producto...........*/
function addProducto(id,token){
    let url = 'clases/carrito.php'
    let formData = new FormData()
    formData.append('id',id)
    formData.append('token',token)

    fetch(url,{
        method:'POST',
        body:formData,
        mode:'cors'
    }).then(response  => response.json())
    .then(data =>{
        if(data.ok){
            let elemento = document.getElementById("num_cart");
            elemento.innerHTML  = data.numero;
        }
    })
}