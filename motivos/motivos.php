<?php
        session_start();
        include("../config/db.php");
         
        //MOSTRAR LISTA DE PROVEEDORES
        $estado = 1;
        $consulta = $conexion -> prepare("SELECT * from motivo where estado = :estado order by motivo asc ");
        $consulta -> bindParam("estado",$estado);
        $consulta -> execute();
        $listaMotivos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        
         include("../template/cabecera.php");
?>

    <!-- Cierre navbar -->

    <section class="container-fluid">
        <div class="div_titulo my-3">
            <h1>Motivos descuento de stock</h1>
        </div>
        <div class="d-flex justify-content-center mt-5 w-10">
             <button class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#modalMotivos">Agregar motivo</button>
        </div>

        <div class="mt-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="d-flex w-25">
                   <input type="button" id="activos" class="btn btn-success mx-2 w-75" value="Activos">
                   <input type="button" id="inactivos" class="btn btn-secondary mx-2 w-75" value="Inactivos">
                </div>
            </div>
        </div>
       
        <!-- ROW TABLA -->
        <div class="row tabla">
            <div class="col" id="div_contenedor_tabla">
                <table class="table table-responsive table-bordered table-striped my-3 text-center  mx-auto" style="width:60%"  id="tablaProveedores">  <!--Tiene margen-->
                <!-- div mensaje de confirmacion de update -->
                <div class="container d-flex justify-content-center mt-3">  
                    <?php
                    $nombreModificado = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
                    
                    if ($nombreModificado) {                       
                        echo "<div class='alert alert-success alert-dismissible w-50 mt-4 d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                        Motivo $nombreModificado modificado correctamente 
                        <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    }
                    //Error editar mensaje
                    $errorModificacion = (isset($_GET["upde"])) ? $_GET["upde"] : "" ;
                    
                    if ($errorModificacion) {                       
                        echo "<div class='alert alert-danger alert-dismissible w-50 mt-4 d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                        $errorModificacion  
                        <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    }
                        //alta
                    $mensajeError = (isset($_GET["msge"])) ? $_GET["msge"] : "" ;
                    
                    if ($mensajeError) {                       
                        echo "<div class='alert alert-danger alert-dismissible w-50 mt-4 d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                         $mensajeError 
                        <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    }
                    ?>
                </div>
                    <thead >
                    <tr>
                        <th class="col-3">Motivo</th>
                        <th class="col-3">Tipo</th>
                        <th class="col-3">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- FOREACH -->
                    <?php  
                    foreach ($listaMotivos as $motivos) {
                    ?>
                    <tr >
                        <td class="col-3"><?php echo $motivos["motivo"] ?></td>
                        <td class="col-3"><?php echo $motivos["tipo"] ?></td>
                        <td class="col-3"> 
      
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $motivos['id_motivo'];?>">

                            <a href="modificarMotivos.php?upd=<?php echo $motivos["id_motivo"] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                                <!-- Boton que ejecute funcion js  para eliminar -->
                            <a href="eliminarMotivos.php?usr=<?php echo $motivos['id_motivo'] ?>"">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>
                        </td>
                    </tr>

                    <?php }; ?>  <!-- Cierre PHP -->
                
                </tbody>
            </table>
        </div>

    </section>

    <!-- MODAL -->
    <div class="modal fade" id="modalMotivos" tabindex="-1" aria-hidden="true" aria-labelledy="modalTitulo">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 >Crear motivo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    <form action="altaMotivos.php" name="form" method="POST" >
                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo</label>
                            <input type="text" class="form-control" name="motivo" id="motivo" aria-describedby="motivo" placeholder="Ingresar motivo">
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo: </label>
                            <select class="form-select" name="tipo" id="tipo" aria-label="Default select example">
                                <option value="positivo"> positivo </option>
                                <option value="negativo"> negativo </option>
                            </select>
                        </div>
                        <div class="alert alert-danger mt-2" class="text-center" id="error_validacion_motivos" style="display:none"></div>
                        <button type="button" name="botonAccion" value="insertar" id="btn-motivos" class="btn btn-primary">Crear motivo</button>
                        </form>
                    </div>
                    <div class="modal-footer"></div>
                    </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<script>
        const btnMotivos = document.querySelector("#btn-motivos");
        btnMotivos.addEventListener("click", () =>{
            const motivo = document.querySelector("#motivo").value;
            const div_error = document.querySelector("#error_validacion_motivos");
            // e.preventDefault();
            if (motivo == "") {
                div_error.style.display = "block";
                div_error.textContent = "Nombre campo obligatorio";
                setTimeout(() => {
                    div_error.style.display = 'none';
                }, 3000); 
            }else{
                document.form.submit();
            }
        })

        const btnActivo= document.querySelector("#activos");
        const btnInactivo= document.querySelector("#inactivos");
        const div_padre = document.querySelector("#div_contenedor_tabla");
        btnActivo.addEventListener("click",() =>{
        limpiarHTML();

        div_padre.innerHTML = `<div class="row">
            
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto"> 
                    <thead >
                        <tr>
                            <th class="col-3">Motivo</th>
                            <th class="col-3">Tipo</th>
                            <th class="col-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  
                    foreach ($listaMotivos as $motivos) {
                    ?>
                    <tr >
                        <td class="col-3"><?php echo $motivos["motivo"] ?></td>
                        <td class="col-3"><?php echo $motivos["tipo"] ?></td>
                        <td class="col-3"> 
      
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $motivos['id_motivo'];?>">

                            <a href="modificarMotivos.php?upd=<?php echo $motivos["id_motivo"] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                                <!-- Boton que ejecute funcion js  para eliminar -->
                            <a href="eliminarMotivos.php?usr=<?php echo $motivos['id_motivo'] ?>"">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>
                        </td>
                    </tr>

                    <?php }; ?>  <!-- Cierre PHP -->
                
                </tbody>
        </table>
    </div>
    </div>`
    
    })

    btnInactivo.addEventListener("click",() =>{
     
        <?php 
             $estado2 = 0;
             $consulta = $conexion -> prepare("SELECT * from motivo where estado = :estado2 order by motivo asc");
             $consulta -> bindParam("estado2",$estado2);
             $consulta -> execute();
             $listaMotivos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        ?>
        limpiarHTML();

        div_padre.innerHTML = `<div class="row">
            
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                    <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                        <thead >
                            <tr>
                                <th class="col-3">Nombre</th>
                                <th class="col-3">Acciones</th>
                            </tr>
                    </thead>
                    <tbody>
                        <!-- FOREACH -->
                    <?php  
                    foreach ($listaMotivos as $motivos) {
                    ?>
                    <tr >
                        <td class="col-4"><?php echo $motivos["motivo"] ?></td>
                        <td class="col-4"><?php echo $motivos["tipo"] ?></td>
                        <td class="col-4"> 
                        <form name='form' id='form' method='POST' action='motivosActivos.php'>
                            <input type='hidden' value='<?php echo $motivos["id_motivo"] ?>' name='id' id='id'>
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
</html>