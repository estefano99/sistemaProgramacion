const tipo_tragos_nombre = document.querySelector(".tipo_tragos_nombre");
const input_filter = document.querySelector("#input_filter");
const btn_filter = document.querySelector("#btn_filter");
const btn_filter_regresar = document.querySelector("#btn_filter_regresar");
const tbody_tipoDeTragos = document.querySelector(".tbody_tipoDeTragos");

const div_padre = document.querySelector("#div_contenedor_tabla");
const btnActivo= document.querySelector("#activos");

document.addEventListener("DOMContentLoaded", () => {

    fetch("./APItipoDeTragos.php") //Trae los tipos de tragos de la API
        .then(res => res.json())
        .then(datos => generarHTML(datos))
        .catch(error => console.log(error))

})

const datosBusqueda = {
    nombre: ""
}

btn_filter.addEventListener("click", () => {

    datosBusqueda.nombre = input_filter.value
    filtrarTipoDeTrago();
})

btn_filter_regresar.addEventListener("click", () => {

    fetch("./APItipoDeTragos.php") //Trae los tipos de tragos de la API
        .then(res => res.json())
        .then(datos => generarHTML(datos))
        .catch(error => console.log(error))
        input_filter.value = "";
})

function filtrarTipoDeTrago() {
    const resultado = nuevoDatos.filter(filtrarNombre)
    generarHTML(resultado)
}

function filtrarNombre(tipoDeTrago) {

    if (datosBusqueda.nombre) {
        return tipoDeTrago.nombre == datosBusqueda.nombre
    }
    return tipoDeTrago
}


let nuevoDatos = []  // va a tener los datos que viene de la base de datos asi se los paso en la funcion de filtrar

function generarHTML(datos) {

    nuevoDatos = datos
    limpiarHTML();

    datos.forEach(data => {
        
        const { id_tipodetragos, nombre } = data

        const p = document.createElement("p");
        const input = document.createElement("input");
        const tr = document.createElement("tr");
        const td1 = document.createElement("td");
        const td2 = document.createElement("td");
        const icono1 = document.createElement("a");
        const icono2 = document.createElement("a");

        td1.classList.add("td",`td${nombre.replace(/\s/g,'')}`) //Saca los espacios en blanco

        p.textContent = nombre;
        p.classList.add("tipo_tragos_nombre");

        input.type = "hidden"
        input.name = "txtID"
        input.value = id_tipodetragos;

        icono1.href = `modificarTipoDeTragos.php?upd=${id_tipodetragos}`
        icono2.href = `eliminarTipoDeTragos.php?url=${id_tipodetragos}`

        icono1.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"                 stroke="currentColor"   class="w-6 h-6 iconos">
        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>`

        icono2.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
        </svg>`

        td1.appendChild(p);
        td1.appendChild(input);
        td2.appendChild(icono1);
        td2.appendChild(icono2);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tbody_tipoDeTragos.appendChild(tr);
    });

}

btnActivo.addEventListener("click",() =>{

    limpiarHTML();
    //Otra solucion
    location.reload();

    div_padre.innerHTML = `
    <div class="row">
        <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
            <div class="d-flex justify-content-center align-items-center mt-4">
                <div>
                    <input type="text" id="input_filter">
                </div>
                <div class="mx-2  btn-group">
                    <button class="btn btn-dark" type="button" id="btn_filter">Buscar</button>
                    <button class="btn btn-dark" type="button" id="btn_filter_regresar">Regresar</button>
                </div>
            </div>
                <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  
                <thead>
                    <tr>
                    <th class="col-4">Nombre tipo de trago</th>
                    <th class="col-4">Acciones</th>
                    </tr>
                </thead>
                <tbody class="tbody_tipoDeTragos">
                    
                </tbody>
            </table>
            </table>
        </div>
    </div>`

    fetch("./APItipoDeTragos.php") //Trae los tipos de tragos de la API
        .then(res => res.json())
        .then(datos => generarHTML(datos))
        .catch(error => console.log(error))

})


function limpiarHTML() {
    while (tbody_tipoDeTragos.firstChild) {
        tbody_tipoDeTragos.removeChild(tbody_tipoDeTragos.firstChild)
    }
}