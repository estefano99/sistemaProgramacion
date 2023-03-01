let fechaConHora = new Date();
const anio = fechaConHora.getFullYear();
let mes = fechaConHora.getMonth() + 1;
let dia = fechaConHora.getDate();
dia = dia < 10 ? `0${dia}` : dia
mes = mes < 10 ? `0${mes}` : mes
const fecha = `${anio}-${mes}-${dia}`  //Para ponerle limite al input
const selectFechas = document.querySelector("#fechas");
const mesConcat = `${anio}-${mes}`; //Para input Month
const divGenerador = document.createElement("div");
const card_body = document.querySelector(".card-body");

selectFechas.onchange = () => {
    switch (selectFechas.value) {
        case "dia":
            limpiarHTML();
            divGenerador.innerHTML = `
            <form action="calcularTragos.php" name="form" id="form_dias" method="post">
                <div class="form-group mb-3">
                    <label for="fecha_desde" class="form-label">Fecha desde:</label>
                    <input type="date" required name="fecha_desde" id="fecha_desde"  max="${fecha}"  class="form-control" aria-describedby="helpId">
                </div>
                <div class="form-group mb-3">
                    <label for="fecha_hasta" class="form-label">Fecha hasta:</label>
                    <input type="date" required name="fecha_hasta" id="fecha_hasta"  max="${fecha}" class="form-control" aria-describedby="helpId">
                </div>
                <div class="d-flex justify-content-center" role="group" aria-label="">
                    <button type="submit" name="accion" id="btn" value="" class="btn btn-success m-2">Calcular</button>
                    <a href="../inicio/inicio.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button> </a>
                </div>
            </form>
            `
            card_body.appendChild(divGenerador)

            enviar_data_dias()
            
            break;
            case "mes":
                limpiarHTML()
                divGenerador.innerHTML =`
                <form action="calcularTragos.php" name="form" method="post">
                    <div class="form-group mb-3">
                        <label for="fecha_mes" class="form-label">Fecha mes:</label>
                        <input type="month" required name="fecha_mes" id="fecha_desde" value="" max="${mesConcat}"  class="form-control" aria-describedby="helpId">
                    </div>
                    <div class="d-flex justify-content-center" role="group" aria-label="">
                        <button type="submit" name="accion" id="btn" value="" class="btn btn-success m-2">Calcular</button>
                        <a href="../inicio/inicio.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button> </a>
                    </div>
                </form>
                `
                card_body.appendChild(divGenerador);
                break;
            case "elegir":
                limpiarHTML()
                break;
        default:
            break;
    }
}

function enviar_data_dias(){
    const form_dias = document.querySelector("#form_dias");
    form_dias.onsubmit = (e) => {
        e.preventDefault();
        const fecha_desde = document.querySelector("#fecha_desde").value
        const fecha_hasta = document.querySelector("#fecha_hasta").value

        if (fecha_desde > fecha_hasta) {
            swal("fechas mal ingresadas", "fecha desde debe ser menor", "warning");
        }else{
            const data = e.target
            const formData = new FormData(data);
            fetch("calcularTragos.php",{
                method:"POST",
                body:formData
            }).then(res => res.json())
            .then(datos => obtenerNombreTragos(datos))
        }
    }
}

function obtenerNombreTragos(datos){
    

    const sectionCalcularTragos = document.querySelector(".borrar");
        sectionCalcularTragos.innerHTML = "";
        //Creo el div y elemento canvas
        // const div = document.createElement("div");
        // div.style.background = "#24292e"
        // const canvas = document.createElement("canvas");
        // canvas.classList.add("canvas")
        // canvas.setAttribute("id","myChart")
        // div.appendChild(canvas); 
        // sectionCalcularTragos.appendChild(div)

        const chart = document.getElementById('myChart').getContext('2d');
         const grafico = new Chart(chart, {
          type: 'bar',
          data: {
              datasets: [{
                  label: 'Tragos vendidos',
                  backgroundColor:['#05EEF9','#05F974','#D4F905','#F9AF05','#F96105','#CD05F9','#F905DF','#F90574','#F90505'],
                  borderColor:'white',
                  borderWith:'1'
                }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
        for (let i = 0; i < datos.length; i++) {
            grafico.data.labels.push(datos[i].nombre)
            grafico.data["datasets"][0].data.push(datos[i].cantidad)
        }  
}

function limpiarHTML() {
    while(divGenerador.firstChild){
        divGenerador.removeChild(divGenerador.firstChild) 
    }    
}