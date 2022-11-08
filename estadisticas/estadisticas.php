<?php
    session_start();
    include("../config/db.php"); 
    include("../template/cabecera.php");

    $fechaActual = date('Y-m-d');
?>
<section class="container">
    <div class="d-flex justify-content-center div_titulo">
        <h1>Calcular estadísticas</h1>
    </div>
    <div class="row d-flex flex-direction-column justify-content-center align-content-center mt-5">
        <div class="col-5 ">
            <!-- div oculto -->
        <div class="alert alert-danger mt-2" class="text-center" id="error_fecha" style="display:none"></div> 
            <!-- card -->
            <div class="card text-center">
                <!-- card header -->
                <div class="card-header bg-primary text-white">
                    Datos fechas
                </div>
                <!-- card body -->
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="fechas" class="form-label">Formato de fecha: </label>
                        <select name="fechas" id="fechas" class="form-select text-center">
                        <option value="elegir">Elegir opción</option>
                        <option value="dia">dia</option>
                        <option value="semana">semana</option>
                        <option value="mes">mes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const fechas = document.querySelector("#fechas");
    const divPadre = document.createElement("div");
    const card_body = document.querySelector(".card-body");
    //Traigo la fecha actual
    const fechaActual = moment().format()
    //Obtengo año
    const año = moment().get('year');
    //Obtengo la semana actual
    const weeknumber = moment(fechaActual,"DD").week();
    //Concateno con el formato del input type Week
    const fechaConcat = `${año}-W${weeknumber}`
    //Para input Month
    let mes = moment().month();
    mes ++   //Incremeneto el mes en uno porque sino no puedo seleccionar el mes actual
    mes < 10 ? mes = `0${mes}` : mes //Me trae el mes sin cero adelante, y si no se lo agrego, no me lo toma el input month
    mesConcat = `${año}-${mes}`;

    fechas.addEventListener("change",() =>{

        switch (fechas.value) {
            case "dia":

                limpiarHTML();
                
                divPadre.innerHTML = ` <form action="calcular.php" name="form" method="post">
                        <div class="form-grou.months(Number|String);p mb-3">
                            <label for="fecha_desde" class="form-label">Fecha desde:</label>
                            <input type="date" required name="fecha_desde_dia" id="fecha_desde" value="" max="<?php echo $fechaActual ?>"  class="form-control" aria-describedby="helpId">
                        </div>
                        <div class="form-group mb-3">
                            <label for="fecha_hasta" class="form-label">Fecha hasta:</label>
                            <input type="date" required name="fecha_hasta_dia" id="fecha_hasta" value="" max="<?php echo $fechaActual ?>" class="form-control" aria-describedby="helpId">
                        </div>
                        <div class="d-flex justify-content-center" role="group" aria-label="">
                            <button type="button" name="accion" id="btn" value="modificar" class="btn btn-success m-2">Calcular</button>
                            <a href="../inicio/inicio.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button> </a>
                        </div>
                    </form>`
                card_body.appendChild(divPadre)

                const fecha_desde = document.querySelector("#fecha_desde")
                const fecha_hasta = document.querySelector("#fecha_hasta")
                const btnEnviar = document.querySelector("#btn")
                const divOculto = document.querySelector("#error_fecha")
                let fecha_desde_act = ""
                let fecha_hasta_act = ""

                fecha_desde.addEventListener("change", () =>{  //Capta el cambio de fechas
                    fecha_desde_act = fecha_desde.value
                })

                fecha_hasta.addEventListener("change", () =>{ //Capta el cambio de fechas
                    fecha_hasta_act = fecha_hasta.value
                })

                btn.addEventListener("click", () =>{        //Cuando haces click
                    if (fecha_desde_act && fecha_hasta_act) {  //Si ingreso algo, sino muestra en el else
                        
                        if (fecha_desde_act <= fecha_hasta_act) { //Si esta bien envio el form
                            document.form.submit();
                        }else{                                   //Sino muestro mensaje
                            divOculto.style.display = "block";
                            divOculto.textContent = "Fechas mal ingresadas"
                            setTimeout(() => {
                                divOculto.style.display = 'none';
                            }, 4000); 
                        }
                    }else{
                            divOculto.style.display = "block";
                            divOculto.textContent = "Debe ingresar fechas"
                            setTimeout(() => {
                                divOculto.style.display = 'none';
                            }, 4000); 
                    }
                })
                
            break;
            case "semana":
                
                limpiarHTML();
                
    
                divPadre.innerHTML = ` <form action="calcular.php" name="form" method="post">
                        <div class="form-group mb-3">
                            <label for="fecha_desde" class="form-label">Fecha semana:</label>
                            <input type="week" required name="fecha_desde_semana" id="fecha_desde" value="" max="${fechaConcat}"  class="form-control" aria-describedby="helpId">
                        </div>
                        <div class="d-flex justify-content-center" role="group" aria-label="">
                            <button type="button" name="accion" id="btn" value="modificar" class="btn btn-success m-2">Calcular</button>
                            <a href="../inicio/inicio.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button> </a>
                        </div>
                    </form>`
                card_body.appendChild(divPadre)

                const fecha_desde1 = document.querySelector("#fecha_desde")
                const btnEnviar1 = document.querySelector("#btn")
                const divOculto1 = document.querySelector("#error_fecha")
                let fecha_desde_act1 = "";
            
                fecha_desde1.addEventListener("change", () =>{  //Capta el cambio de fechas
                    fecha_desde_act1 = fecha_desde1.value
                })


                btnEnviar1.addEventListener("click", () =>{
                    if (fecha_desde_act1) {
                            document.form.submit();
                    }else{
                        divOculto1.style.display = "block";
                        divOculto1.textContent = "Debe ingresar fechas"
                        setTimeout(() => {
                            divOculto1.style.display = 'none';
                        }, 4000); 
                    }
                })
                
                break;
            case "mes":
                limpiarHTML();
    
                divPadre.innerHTML = ` <form action="calcular.php" name="form" method="post">
                        <div class="form-group mb-3">
                            <label for="fecha_desde" class="form-label">Fecha mes:</label>
                            <input type="month" required name="fecha_desde_mes" id="fecha_desde" value="" max="${mesConcat}"  class="form-control" aria-describedby="helpId">
                        </div>
                        <div class="d-flex justify-content-center" role="group" aria-label="">
                            <button type="button" name="accion" id="btn" value="modificar" class="btn btn-success m-2">Calcular</button>
                            <a href="../inicio/inicio.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button> </a>
                        </div>
                    </form>`

                card_body.appendChild(divPadre)

                const fecha_desde2 = document.querySelector("#fecha_desde")
                const btnEnviar2 = document.querySelector("#btn")
                const divOculto2 = document.querySelector("#error_fecha")
                let fecha_desde_act2 = "";

                fecha_desde2.addEventListener("change", () =>{  //Capta el cambio de fechas
                    fecha_desde_act2 = fecha_desde2.value
                })

                btnEnviar2.addEventListener("click", () =>{
                    if (fecha_desde_act2) {
                            document.form.submit();
                    }else{
                        divOculto2.style.display = "block";
                        divOculto2.textContent = "Debe ingresar fecha"
                        setTimeout(() => {
                            divOculto2.style.display = 'none';
                        }, 4000); 
                    }
                })
                
            break;
            case "elegir":
                limpiarHTML();
            break;
        
            default:
                break;
        }
        
    })
    
    //Limpia el html para que no se muestren muchos form
    function limpiarHTML() {
    while(divPadre.firstChild){
        divPadre.removeChild(divPadre.firstChild) 
    }
}

    
</script>
<?php include("../template/footer.php") ?>