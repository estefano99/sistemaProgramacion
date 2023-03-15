const rowTragos = document.querySelector("#rowTragos");
const divNashe = document.querySelector(".div-col-ventas2");
const tablaTragos = document.querySelector(".tbody-modificar");
const form_lista_tragos = document.querySelector("#form_lista_tragos");
const divColVentas = document.querySelector(".div-col-ventas2");
const div_row_tragos = document.querySelector(".div_row_tragos");
const formFavoritos = document.querySelector("#formFavoritos");
let pAcumuladorDinero = document.querySelector("#acumuladorDinero");

// VARIABLES
let tragosDeshabilitados = [];
let tragosTodos = [];
let esVentanaTipoTragos = true; //Dice cuando hay que deshabilitar los tragos y cuando no;
//Boton regresar
const btnRegresar = document.createElement("button");
btnRegresar.textContent = "Regresar";
btnRegresar.classList.add("btnRegresar");


document.addEventListener("DOMContentLoaded", () => {
    fetch("listaTragos.php", {})
    .then((res) => res.json())
    .then((datos) => generarHTML(datos));
});

function generarHTML(datos) {

  esVentanaTipoTragos = true;
  datos.forEach((trago) => {
    const { id_tipodetragos, nombre } = trago;

    const divTrago = document.createElement("div");
    divTrago.classList.add(
      "col-4",
      "div-grupo-tragos",
      "bg",
      "bg-secondary",
      "bg-gradient"
    );

    divTrago.innerHTML = `
            <form action="" name="form" class="form" id='form${id_tipodetragos}' method="post">
                <input type="hidden" name="id" value="${id_tipodetragos}">
                <button type="submit" class="btn-ventas" name="nombre">${nombre}</button>
            </form>
    `;

    //* FUNCION DE MOSTRAR TODOS LOS TRAGOS DE UN TIPO
    divTrago.onclick = (e) => {
      e.preventDefault();

      const data = e.target.parentElement;
      const formData = new FormData(data);
      limpiarHTML();
      fetch("ventasAPI.php", {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((tragos) => muestraTragos(tragos));
    };

    rowTragos.appendChild(divTrago);
  });
}

function muestraTragos(tragos) {

  esVentanaTipoTragos = false;
  const divTragos = document.createElement("div");
  divTragos.classList.add("divTragos");
  divNashe.appendChild(divTragos);

  
  tragos.forEach((trago) => {
    const { id_tragos, nombre, precio } = trago;
    
    const btnAgregarTrago = document.createElement("button");
    
    //checkear tragos deshabilitados
    if (tragosDeshabilitados.length) {
        const tragoADeshabilitar = tragosDeshabilitados.includes(id_tragos);

        if(tragoADeshabilitar) {
          btnAgregarTrago.classList.remove("enabled");
            btnAgregarTrago.classList.add("disabled","btnAgregarTrago",`btn${id_tragos}`);
            btnAgregarTrago.disabled = true;
        } else {
          btnAgregarTrago.classList.remove("enabled");
          btnAgregarTrago.classList.add("enabled","btnAgregarTrago",`btn${id_tragos}`);
          btnAgregarTrago.disabled = false;
        }

    }else{
        btnAgregarTrago.classList.add(
          "btnAgregarTrago",
          "enabled",
          "btn" + id_tragos
        );
    }


    btnAgregarTrago.textContent = `${nombre} - $${precio}`;
    btnAgregarTrago.dataset.id = id_tragos;

    btnAgregarTrago.addEventListener("click", () => {
      const rowTrago = document.createElement("tr");
      rowTrago.dataset.id = id_tragos;

      let contador = 1;

      rowTrago.innerHTML = `
                <td class='col-2 cantidad' >
                <input type='hidden' id='input${id_tragos}' name='cantidad_tragos[]' value='${contador}' class='w-100 input-tragos'>
                <p class='w-100 input-tragos letras-medidas' id='contador${id_tragos}'>${contador}</p>
                </td>
                <td class='col-6 cantidad'>
                    <input type='hidden' id="input_precio${id_tragos}" value='${precio}' class='w-100 input-tragos'>
                    <input type='hidden' name='id[]' value='${id_tragos}' class='w-100 input-tragos'>
                    <p class='input-tragos letras-medidas'>${nombre}</p>
                </td>
                <td class='col-4 td-botones'>
                    <button id="agregar" class="btnSuma${id_tragos} btn btn-secondary letras-medidas" data-id="${id_tragos}" type="button">+</button>
                    <button id="restar" class="btnResta${id_tragos} btn btn-danger letras-medidas" data-id="${id_tragos}" type="button">-</button>
                </td>
            `;

      tablaTragos.appendChild(rowTrago); // Agrega el trago a la minuta


      //* Se DESHABILITA el trago agregado a la minuta y SE AGREGA AL ARREGLO
      tragosDeshabilitados.push(btnAgregarTrago.dataset.id); //Guardo los tragos deshabilitados
      btnAgregarTrago.disabled = true;
      btnAgregarTrago.classList.add("disabled");
      btnAgregarTrago.classList.remove("enabled");
      pAcumuladorDinero.textContent = parseInt(pAcumuladorDinero.textContent) + parseInt(precio);

    
      // *FUNCION btnSUMA++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    
      const btnSuma = document.querySelector(`.btnSuma${id_tragos}`);
      let pContador = document.querySelector(`#contador${id_tragos}`);
      let input = document.querySelector(`#input${id_tragos}`);

      btnSuma.onclick = () => {
        if (parseInt(pContador.textContent) < 200) {
          pContador.textContent = parseInt(pContador.textContent) + 1;
          contador++;
          input.value = contador;
          pAcumuladorDinero.textContent =
            parseInt(pAcumuladorDinero.textContent) + parseInt(precio);
        } else {
          swal("Debe ingresar un trago", "Presiona el botón!", "warning");
        }
      };
      
      
      // *FUNCION btnRESTA----------------------------------------------------------------------------
      
      const btnResta = document.querySelector(`.btnResta${id_tragos}`);
      
      btnResta.onclick = () => {
        if (parseInt(pContador.textContent) > 1) {
          pContador.textContent = parseInt(pContador.textContent) - 1;
          contador--;
          input.value = contador;
          pAcumuladorDinero.textContent = parseInt(pAcumuladorDinero.textContent) - parseInt(precio);
        } else {

          if (esVentanaTipoTragos) {
            pAcumuladorDinero.textContent = parseInt(pAcumuladorDinero.textContent) - parseInt(precio);
            tablaTragos.removeChild(rowTrago);
          }else{
            pAcumuladorDinero.textContent = parseInt(pAcumuladorDinero.textContent) - parseInt(precio);
            tablaTragos.removeChild(rowTrago);
            const btn = document.querySelector(`.btn${id_tragos}`);
            if (btn) {
              btn.classList.remove("disabled");
              btn.classList.add("enabled","btnAgregarTrago",`btn${id_tragos}`);
              btn.disabled = false;
            }
            
          }

          //* NO TOCAR FILTER
          tragosDeshabilitados = tragosDeshabilitados.filter(
            (tragos) => tragos != btnAgregarTrago.dataset.id
          );
        }
      };
    });

    divTragos.appendChild(btnAgregarTrago);
  });

  divTragos.appendChild(btnRegresar);
}

btnRegresar.onclick = () => {
  divColVentas.innerHTML = "";
  divColVentas.appendChild(div_row_tragos);
  esVentanaTipoTragos = true
};


let bandera = false;

form_lista_tragos.onsubmit = (e) => {
  //Confirma la venta
  e.preventDefault();
  //La bandera esta echa porque la tabla antes del primer submit, tiene un hijo y dep del primer submit, no tiene hijos, por lo tanto me registraba las ventas luego del primer submit, entraba al else.
  if (!bandera) {
    if (tablaTragos.childNodes.length > 1) {
      const data = new FormData(form_lista_tragos);
      fetch("registrarVentas.php", {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((datos) => {
          tablaTragos.innerHTML = "";
          divColVentas.innerHTML = "";
          divColVentas.appendChild(div_row_tragos);
          pAcumuladorDinero.textContent = "0";
          tragosDeshabilitados = [];
          setTimeout(() => {
            swal("Venta registrada!", "Presiona el botón!", "success");
          }, 0500);
          bandera = true;
        });
    } else {
      swal("Debe ingresar un trago", "Presiona el botón!", "warning");
    }
  }

  if (bandera) {
    if (tablaTragos.hasChildNodes()) {
      const data = new FormData(form_lista_tragos);
      fetch("registrarVentas.php", {
        method: "POST",
        body: data,
      })
        .then((res) => res.json())
        .then((datos) => {
          tablaTragos.innerHTML = "";
          divColVentas.innerHTML = "";
          divColVentas.appendChild(div_row_tragos);
          pAcumuladorDinero.textContent = "0";
          tragosDeshabilitados = [];
          setTimeout(() => {
            swal("Venta registrada!", "Presiona el botón!", "success");
          }, 0500);
        });
    } else {
      swal("Debe ingresar un trago", "Presiona el botón!", "warning");
    }
  }
};

formFavoritos.onsubmit = (e) => {
  e.preventDefault();
  const data = formFavoritos;
  const formData = new FormData(data);
  limpiarHTML();
  fetch("ventasAPI.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((favoritos) => muestraFavoritos(favoritos));
};

function muestraFavoritos(favoritos) {
  esVentanaTipoTragos = false;
  const divTragos = document.createElement("div");
  divTragos.classList.add("divTragos");
  divNashe.appendChild(divTragos);

  favoritos.forEach((trago) => {
    const { id_tragos, nombre, precio } = trago;

    const btnAgregarTrago = document.createElement("button");
    if (tragosDeshabilitados.length) {
      const tragoADeshabilitar = tragosDeshabilitados.includes(id_tragos);  //Devuelve true o false si existe el trago en el arreglo

      if(tragoADeshabilitar) { //Si el trago esta en el arreglo 
        btnAgregarTrago.classList.remove("enabled");
          btnAgregarTrago.classList.add("disabled","btnAgregarTrago",`btn${id_tragos}`);
          btnAgregarTrago.disabled = true;
      } else { //Si no esta en el arreglo
        btnAgregarTrago.classList.remove("enabled");
        btnAgregarTrago.classList.add("enabled","btnAgregarTrago",`btn${id_tragos}`);
        btnAgregarTrago.disabled = false;
      }
  }else{ //Si el arreglo no tiene nada
      btnAgregarTrago.classList.add(
        "btnAgregarTrago",
        "enabled",
        "btn" + id_tragos
      );
  }

    btnAgregarTrago.textContent = `${nombre} - $${precio}`;
    btnAgregarTrago.dataset.id = id_tragos;

    btnAgregarTrago.addEventListener("click", () => {
      const rowTrago = document.createElement("tr");
      rowTrago.dataset.id = id_tragos;

      let contador = 1;

      rowTrago.innerHTML = `
                <td class='col-2 cantidad' >
                <input type='hidden' id='input${id_tragos}' name='cantidad_tragos[]' value='${contador}' class='w-100 input-tragos'>
                <p class='w-100 input-tragos letras-medidas' id='contador${id_tragos}'>${contador}</p>
                </td>
                <td class='col-6 cantidad'>
                    <input type='hidden' id="input_precio${id_tragos}" value='${precio}' class='w-100 input-tragos'>
                    <input type='hidden' name='id[]' value='${id_tragos}' class='w-100 input-tragos'>
                    <p class='input-tragos letras-medidas'>${nombre}</p>
                </td>
                <td class='col-4 td-botones'>
                    <button id="agregar" class="btnSuma${id_tragos} btn bg bg-secondary bg-gradient text-white letras-medidas" data-id="${id_tragos}" type="button">+</button>
                    <button id="restar" class="btnResta${id_tragos} btn bg-danger bg-gradient letras-medidas text-white" data-id="${id_tragos}" type="button">-</button>
                </td>
            `;
      pAcumuladorDinero.textContent = parseInt(pAcumuladorDinero.textContent) + parseInt(precio);
      tablaTragos.appendChild(rowTrago);
      tragosDeshabilitados.push(btnAgregarTrago.dataset.id); //Guardo los tragos deshabilitadosF
      btnAgregarTrago.disabled = true;
      btnAgregarTrago.classList.add("disabled");
      btnAgregarTrago.classList.remove("enabled");

      const btnSuma = document.querySelector(`.btnSuma${id_tragos}`);
      let pContador = document.querySelector(`#contador${id_tragos}`);
      let input = document.querySelector(`#input${id_tragos}`);

      btnSuma.onclick = () => {
        if (parseInt(pContador.textContent) < 200) {
          pContador.textContent = parseInt(pContador.textContent) + 1;
          contador++;
          input.value = contador;
          pAcumuladorDinero.textContent =
            parseInt(pAcumuladorDinero.textContent) + parseInt(precio);
        } else {
          swal("Maximo 200 tragos", "Presiona el botón!", "warning");
        }
      };

      const btnResta = document.querySelector(`.btnResta${id_tragos}`);

      btnResta.onclick = () => {
        if (parseInt(pContador.textContent) > 1) {
          pContador.textContent = parseInt(pContador.textContent) - 1;
          contador--;
          input.value = contador;
          pAcumuladorDinero.textContent =
            parseInt(pAcumuladorDinero.textContent) - parseInt(precio);
        } else {

            if (esVentanaTipoTragos) { //Bandera que comprueba si esta dentro de tipos de tragos o no, para saber si remover las clases o no

              pAcumuladorDinero.textContent = parseInt(pAcumuladorDinero.textContent) - parseInt(precio);
              tablaTragos.removeChild(rowTrago);
            }else{

              pAcumuladorDinero.textContent = parseInt(pAcumuladorDinero.textContent) - parseInt(precio);
              tablaTragos.removeChild(rowTrago);
              const btn = document.querySelector(`.btn${id_tragos}`);
              if (btn) { // Valida que exista el boton , porque si selecciono en favoritos un mojito y desp entro a caipiriña y elimio un mojito dentro de la caipi me tira error.
                btn.classList.remove("disabled");
                btn.classList.add("enabled","btnAgregarTrago",`btn${id_tragos}`);
                btn.disabled = false;
              }
            }

          tragosDeshabilitados = tragosDeshabilitados.filter(
            (tragos) => tragos != btnAgregarTrago.dataset.id
          );
        }
      };
    });

    divTragos.appendChild(btnAgregarTrago);
  });
  //Boton regresar
  divTragos.appendChild(btnRegresar);
}

function limpiarHTML() {
  while (divNashe.firstChild) {
    divNashe.removeChild(divNashe.firstChild);
  }
}
