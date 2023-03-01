<?php
    session_start();
    include("../config/db.php");
    $estado = 1;
    $consulta = $conexion -> prepare("SELECT * from medida where estado = :estado order by medida asc");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaMedidas = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    include("../template/cabecera.php");
?>

    <section class="container">

        <div class="d-flex justify-content-center m-4 div_titulo">
            <h1>Medidas de los productos</h1>
        </div>

        <div class="d-flex justify-content-center mt-5 w-10">
            <button class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#modalMedidas">Agregar medida</button>
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="d-flex w-25">
                   <input type="button" id="activos" class="btn btn-success mx-2 w-75" value="Activos">
                   <input type="button" id="inactivos" class="btn btn-secondary mx-2 w-75" value="Inactivos">
                </div>
            </div>
        </div>
        
        <div class="row d-flex justify-content-center">
            <div class="col-6" id="div_contenedor_tabla">
            <table class="table table-responsive table-bordered table-striped my-3 text-center  mx-auto">
        <?php
        // Mensaje editar medida correcto
            $nombreModificado = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
            if ($nombreModificado) {
                echo "<div class='alert alert-success alert-dismissible mt-4 d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                Medida : $nombreModificado modificada correctamente 
                <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
            // Mensaje editar medida error
            $errorModificado = (isset($_GET["upde"])) ? $_GET["upde"] : "" ;
            if ($errorModificado) {
                echo "<div class='alert alert-danger text-danger alert-dismissible mt-4 d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                 $errorModificado 
                <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
            ?>
            <!-- Mensaje error alta -->
         <?php
            $mensajeError = (isset($_GET["msge"])) ? $_GET["msge"] : "" ;
            if ($mensajeError) {
                echo "<div class='alert alert-danger text-danger alert-dismissible d-flex justify-content-center mt-4' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                    $mensajeError  
                    <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            }
        ?>
                <thead>
                    <tr>
                    <th class="col-4">Medidas</th>
                    <th class="col-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($listaMedidas as $medidas) {
                ?>
                    <tr>
                        <td>
                            <?php echo $medidas["medida"]; ?>
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $medidas['id_medida'];?>">
                        </td> 
                        <td>
                            <a href="modificarMedidas.php?upd=<?php echo $medidas["id_medida"]?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <a href="eliminarMedidas.php?url=<?php echo $medidas["id_medida"]?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>
                        </td> 
                        </tr>
                    <?php }  ?>
                </tbody>
            </table>
            </div>
        </div>
    </section>

    <!-- MODAL -->
    <div class="modal fade" id="modalMedidas" tabindex="-1" aria-hidden="true" aria-labelledy="modalTitulo">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 >Crear medida</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    <form action="altaMedidas.php" name="form" method="POST">
                        <div class="mb-3">
                            <label for="medida" class="form-label">Medida</label>
                            <input type="text" class="form-control" name="medida" id="medida" aria-describedby="Nombre" placeholder="Ingresar medida">
                        </div>
                        <div class="border border-danger w-75 mb-2 mx-auto text-center">
                                <small class="text-danger ">Formas de ingresar: 1,5 lt - 2 lt - 250 mlt 2,250 lt</small>
                        </div>
                                <!-- Div oculto -->
                            <div class="alert alert-danger mt-2 text-danger" class="text-center" id="error_validacion_medidas" style="display:none"></div>
                        <button type="button" name="botonAccion" value="insertar" id="btn-alta" class="btn btn-primary">Crear medida</button>
                        </form>
                    </div>
                    </div>
            </div>
        </div>
    </div>
    <?php include("../template/footer.php") ?>
    <script>
        const btnAlta = document.querySelector("#btn-alta");
        const div_error = document.querySelector("#error_validacion_medidas");
        btnAlta.addEventListener("click", () =>{

            const medida = document.querySelector("#medida").value;

            if (!medida == "") { //Si no es vacio medida
                    
                if (medida.length == 4) { //1 lt
                    
                    if(isNaN(medida[0])){
                        div_error.style.display = "block";
                        div_error.textContent = "El primer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);

                    }else if(medida[1] != " "){
                        div_error.style.display = "block";
                        div_error.textContent = "El segundo caracter debe ser un espacio";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(!isNaN(medida[2]) || !isNaN(medida[3])){
                        div_error.style.display = "block";
                        div_error.textContent = "Los dos últimos caracteres deben ser letras";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else{
                        document.form.submit();
                    }
                
            }else if(medida.length == 6){ //1,5 lt

                if(isNaN(medida[0])){
                        div_error.style.display = "block";
                        div_error.textContent = "El primer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);

                    }else if(medida[1] != ","){
                        div_error.style.display = "block";
                        div_error.textContent = "El segundo caracter debe ser una coma";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(isNaN(medida[2])){
                        div_error.style.display = "block";
                        div_error.textContent = "El tercer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(medida[3] != " "){
                        div_error.style.display = "block";
                        div_error.textContent = "El cuarto caracter debe ser un espacio";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(!isNaN(medida[4]) || !isNaN(medida[5])){
                        div_error.style.display = "block";
                        div_error.textContent = "Los dos últimos caracteres deben ser letras";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else{
                        document.form.submit();
                    }
            } else if(medida.length == 7){ //250 mlt

                if(isNaN(medida[0])){
                        div_error.style.display = "block";
                        div_error.textContent = "El primer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);

                    }else if(isNaN(medida[1])){
                        div_error.style.display = "block";
                        div_error.textContent = "El segundo caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(isNaN(medida[2])){
                        div_error.style.display = "block";
                        div_error.textContent = "El tercer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(medida[3] != " "){
                        div_error.style.display = "block";
                        div_error.textContent = "El cuarto caracter debe ser un espacio";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(!isNaN(medida[4]) || !isNaN(medida[5]) || !isNaN(medida[6])){
                        div_error.style.display = "block";
                        div_error.textContent = "Los tres últimos caracteres deben ser letras";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else{
                        document.form.submit();
                    }
            }else{ //Si el length de medida esta mal
                div_error.style.display = "block";
                div_error.textContent = "Datos incorrectos";
                setTimeout(() => {
                    div_error.style.display = 'none';
                }, 3000);
            }
        }else{ //Vacio medida
            div_error.style.display = "block";
            div_error.textContent = "Nombre campo obligatorio";
            setTimeout(() => {
                div_error.style.display = 'none';
            }, 3000);
            }
        })

        const btnActivo= document.querySelector("#activos");
        const btnInactivo= document.querySelector("#inactivos");
        const div_padre = document.querySelector("#div_contenedor_tabla");
        btnActivo.addEventListener("click",() =>{

        limpiarHTML();

        div_padre.innerHTML = `<div class="row">
            
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                    <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                    <thead>
                    <tr>
                    <th class="col-4">Medidas</th>
                    <th class="col-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($listaMedidas as $medidas) {
                ?>
                    <tr>
                        <td>
                            <?php echo $medidas["medida"]; ?>
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $medidas['id_medida'];?>">
                        </td> 
                        <td>
                            <a href="modificarMedidas.php?upd=<?php echo $medidas["id_medida"]?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <a href="eliminarMedidas.php?url=<?php echo $medidas["id_medida"]?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>
                        </td> 
                        </tr>
                    <?php }  ?>
            </tbody>
        </table>
    </div>
    </div>`
    
    })

    btnInactivo.addEventListener("click",() =>{
        <?php 
             $estado2 = 0;
             $consulta = $conexion -> prepare("SELECT * from medida where estado = :estado2 order by medida asc");
             $consulta -> bindParam("estado2",$estado2);
             $consulta -> execute();
             $listaMedidas = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        ?>
        limpiarHTML();

        div_padre.innerHTML = `<div class="row">
            
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                    <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                        <thead >
                            <tr>
                                <th class="col-3">Medidas</th>
                                <th class="col-3">Acciones</th>
                            </tr>
                    </thead>
                    <tbody>
                        <!-- FOREACH -->
                    <?php  
                    foreach ($listaMedidas as $medidas) {
                    ?>
                    <tr >
                        <td class="col-4"><?php echo $medidas["medida"] ?></td>
                        <td class="col-4"> 
                        <form name='form' id='form' method='POST' action='medidasActivos.php'>
                            <input type='hidden' value='<?php echo $medidas["id_medida"] ?>' name='id' id='id'>
                            <button type='submit' class='btn btn-primary'> Activar</button>
                        </form>
                        </td>
                    </tr>

                    <?php }; ?>  <!-- Cierre PHP -->
                </tbody>
            </table>
        </div>
    </div>`
    
    })


    function limpiarHTML() {
        while(div_padre.firstChild){
            div_padre.removeChild(div_padre.firstChild) 
        }
    }
    </script>