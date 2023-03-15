
const nombre_filter = document.querySelector("#nombre_filter");
const precio_filter = document.querySelector("#precio_filter");
const medida_filter = document.querySelector("#medida_filter");
const tipo_filter = document.querySelector("#tipo_filter");
const btn_filter = document.querySelector("#btn_filter");
const btn_filter_regresar = document.querySelector("#btn_filter_regresar");
const tbody_tipoDeTragos = document.querySelector(".tbody_tipoDeTragos");

const div_padre = document.querySelector("#div_contenedor_tabla");
const btnActivo= document.querySelector("#activos");
const btnInactivo= document.querySelector("#inactivos");

document.addEventListener("DOMContentLoaded", () => {

    fetch("./APIproductos.php") //Trae los tipos de tragos de la API
        .then(res => res.json())
        .then(datos => generarHTML(datos))
        .catch(error => {
            const mensajeDeError = document.getElementById("mensaje-de-error");
            mensajeDeError.innerText = "Ocurrió un error al obtener los datos: " + error;
            mensajeDeError.style.display = "block";
            setTimeout(() => {
                mensajeDeError.style.display = "none";
            }, 2000);
        })

})

const datosBusqueda = {
    nombre: "",
    precio: "",
    medida: "",
    tipo: ""
}

btn_filter.addEventListener("click", () => {

    datosBusqueda.nombre = nombre_filter.value
    datosBusqueda.precio = precio_filter.value
    datosBusqueda.medida = medida_filter.value
    datosBusqueda.tipo = tipo_filter.value
    filtrarTipoDeTrago();
})

function filtrarTipoDeTrago() {
    const resultado = nuevoDatos.filter(filtrarNombre).filter(filtrarPrecio).filter(filtrarMedida).filter(filtrarTipo)
    generarHTML(resultado)
}

function filtrarNombre(data) {

    if (datosBusqueda.nombre) {
        return data.nombre == datosBusqueda.nombre
    }
    return data
}

function filtrarPrecio(data) {

    if (datosBusqueda.precio) {
        return data.precio == datosBusqueda.precio
    }
    return data
}

function filtrarMedida(data) {

    if (datosBusqueda.medida) {
        return data.medida == datosBusqueda.medida
    }
    return data
}

function filtrarTipo(data) {

    if (datosBusqueda.tipo) {
        return data.tipo == datosBusqueda.tipo
    }
    return data
}

btn_filter_regresar.addEventListener("click", () => {

    nombre_filter.value = "";
    precio_filter.value = "";
    medida_filter.value = "";
    tipo_filter.value = "";
    
    generarHTML(mostrarFiltro)

    fetch("./APIproductos.php") //Trae los tipos de tragos de la API
        .then(res => res.json())
        .then(datos => generarHTML(datos))
        .catch(error => {
            const mensajeDeError = document.getElementById("mensaje-de-error");
            mensajeDeError.innerText = "Ocurrió un error al obtener los datos: " + error;
            mensajeDeError.style.display = "block";
            setTimeout(() => {
                mensajeDeError.style.display = "none";
            }, 2000);
        })
})

let nuevoDatos = []  // va a tener los datos que viene de la base de datos asi se los paso en la funcion de filtrar
let mostrarFiltro = [];

function generarHTML(datos) {
    
    nuevoDatos = datos
    mostrarFiltro = nuevoDatos;
    limpiarHTML();

    datos.forEach(data => {
        
        const { id_productos, nombre, medida,stock, precio, tipo, imagen } = data
        const tr = document.createElement("tr");
        tr.innerHTML = `
        <td>${nombre}</td>
        <td>${medida}</td>
        <td>${stock}</td>
        <td>${precio}</td>
        <td>${tipo}</td>
        <td>${imagen ? `<img src="../imagenesProductos/${imagen}" width="100px" alt="imagen">` : 'No hay imagen'}</td>
        <td>
            <a href="comprasProductos.php?url=${id_productos}" class="a-iconos"><img src="../imagenes/añadir-carrito.png" alt="eliminar" class="iconos"></a>
            <a href="descuentoProductos.php?url=${id_productos}" class="w-100 h-100"><img src="../imagenes/eliminar-carrito.png" alt="hola" class="iconos"></a>
            <a href="modificarProductos.php?upd=${id_productos}" ><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            </a>
            <a href="eliminarProductos.php?usr=${id_productos}"class="w-100 h-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </a>
            </div>
        </td>
        `
        
        tbody_tipoDeTragos.appendChild(tr);
    });
}

btnActivo.addEventListener("click", () => {
    limpiarHTML();

    fetch("./APIproductos.php") //Trae los tipos de tragos de la API
        .then(res => res.json())
        .then(datos => generarHTML(datos))
        .catch(error => {
            const mensajeDeError = document.getElementById("mensaje-de-error");
            mensajeDeError.innerText = "Ocurrió un error al obtener los datos: " + error;
            mensajeDeError.style.display = "block";
            setTimeout(() => {
                mensajeDeError.style.display = "none";
            }, 2000);
    })
})

btnInactivo.addEventListener("click", () => {
    fetch("./APIinactivos.php") //Trae los tipos de tragos de la API
        .then(res => res.json())
        .then(datos => generarInactivos(datos))
        .catch(error => {
            const mensajeDeError = document.getElementById("mensaje-de-error");
            mensajeDeError.innerText = "Ocurrió un error al obtener los datos: " + error;
            mensajeDeError.style.display = "block";
            setTimeout(() => {
                mensajeDeError.style.display = "none";
            }, 2000);
        })
})

function generarInactivos(datos) {
    
    limpiarHTML();
    datos.forEach(data => {
        
        const { id_productos, nombre, medida, stock, precio, tipo, imagen } = data
        const tr = document.createElement("tr");
        tr.innerHTML = `
        <td>${nombre}</td>
        <td>${medida}</td>
        <td>${stock}</td>
        <td>${precio}</td>
        <td>${tipo}</td>
        <td>${imagen ? `<img src="../imagenesProductos/${imagen}" width="100px" alt="imagen">` : 'No hay imagen'}</td>
        <td>
            <form name='form' id='form' method='POST' action='productosActivos.php'>
            <input type='hidden' value='${id_productos}' name='id' id='id'>
            <button type='submit' class='btn btn-primary'> Activar</button>
            </form>
        </td>
        `
        
        tbody_tipoDeTragos.appendChild(tr);
    });
}

function limpiarHTML() {
    while (tbody_tipoDeTragos.firstChild) {
        tbody_tipoDeTragos.removeChild(tbody_tipoDeTragos.firstChild)
    }
}