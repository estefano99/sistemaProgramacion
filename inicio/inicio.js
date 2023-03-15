const celular = document.querySelector(".img-celular") 
const pc = document.querySelector(".img-pc") 
let x = window.innerWidth;
console.log(x)

document.addEventListener("DOMContentLoaded",cambiarImagen)

//Cambia la imagen dependiendo el ancho de la pantalla
function cambiarImagen(){

    if (x <= 800) {
        celular.style.display = "block";
        pc.style.display = "none";
        console.log("1")
    }else{
        console.log("2")
        celular.style.display = "none";
        pc.stytle.display = "block";
    }
}