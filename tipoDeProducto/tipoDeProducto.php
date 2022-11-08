<?php
    session_start();
    include("../config/db.php");
    $estado = 1;
    $consulta = $conexion -> prepare("SELECT * from tipodeproducto where estado = :estado");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaTipoDeProducto = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    include("../template/cabecera.php");
?>

    <section class="container">

        <div class="d-flex justify-content-center m-4 div_titulo">
            <h1>Tipo de producto</h1>
        </div>

        <div class="d-flex justify-content-center mt-5 w-10">
            <button class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#modalTipoDeProducto">Agregar tipo de producto</button>
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
        //Update
        $nombreModificado = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
        if ($nombreModificado) {
            echo "<div class='alert alert-success mt-4 alert-dismissible text-danger d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
            Tipo de producto: $nombreModificado modificado correctamente 
            <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        //Update error ya existe
        $errorModificado = (isset($_GET["upde"])) ? $_GET["upde"] : "" ;
        if ($errorModificado) {
            echo "<div class='alert alert-danger mt-4 alert-dismissible text-danger d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
            $errorModificado
            <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        $mensajeError = (isset($_GET["msge"])) ? $_GET["msge"] : "" ;
        if ($mensajeError) {
            echo "<div class='alert alert-danger mt-4 alert-dismissible text-danger d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
             $mensajeError 
            <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>
                <thead>
                    <tr>
                    <th class="col-4">Nombre tipo de producto</th>
                    <th class="col-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($listaTipoDeProducto as $producto) {
                ?>
                    <tr>
                        <td>
                            <?php echo $producto["nombre"]; ?>
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $producto['id_tipodeproducto'];?>">
                        </td> 
                        <td>
                            <a href="modificarTipoDeProducto.php?upd=<?php echo $producto["id_tipodeproducto"]?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <a href="eliminarTipoDeProducto.php?url=<?php echo $producto["id_tipodeproducto"]?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
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
    <div class="modal fade" id="modalTipoDeProducto" tabindex="-1" aria-hidden="true" aria-labelledy="modalTitulo">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="">Crear Tipo de producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    <form action="altaTipoDeProducto.php" name="form" method="POST" >
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre: </label>
                            <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="Nombre" placeholder="Nombre tipo de producto">
                        </div>
                         <!-- Div oculto -->
                         <div class="alert alert-danger mt-2" class="text-center" id="error_val_tipo" style="display:none"></div>
                        <!-- botones -->
                        <div class="d-flex justify-content-center" role="" aria-label="">
                        <button type="button" name="botonAccion" value="insertar" id="btnTipo" class="btn btn-primary">Crear tipo de producto</button>
                        </form>
                    </div>
                    </div>
            </div>
        </div>
    </div>
        <script>
            const btnTipo = document.querySelector("#btnTipo");
            const div_error = document.querySelector("#error_val_tipo");
            btnTipo.addEventListener("click", () =>{
                const nombre = document.querySelector("#nombre").value;
                if (nombre == "") {
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
                    <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                    <thead>
                    <tr>
                    <th class="col-4">Medidas</th>
                    <th class="col-4">Acciones</th>
                    </tr>
                    <thead>
                    <tr>
                    <th class="col-4">Nombre tipo de producto</th>
                    <th class="col-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($listaTipoDeProducto as $producto) {
                ?>
                    <tr>
                        <td>
                            <?php echo $producto["nombre"]; ?>
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $producto['id_tipodeproducto'];?>">
                        </td> 
                        <td>
                            <a href="modificarTipoDeProducto.php?upd=<?php echo $producto["id_tipodeproducto"]?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <a href="eliminarTipoDeProducto.php?url=<?php echo $producto["id_tipodeproducto"]?>"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
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
             $consulta = $conexion -> prepare("SELECT * from tipodeproducto where estado = :estado2 order by nombre asc");
             $consulta -> bindParam("estado2",$estado2);
             $consulta -> execute();
             $listaTipo = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        ?>
        limpiarHTML();

        div_padre.innerHTML = `<div class="row">
            
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                    <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                        <thead >
                            <tr>
                                <th class="col-3">Nombre tipo de producto</th>
                                <th class="col-3">Acciones</th>
                            </tr>
                    </thead>
                    <tbody>
                        <!-- FOREACH -->
                    <?php  
                    foreach ($listaTipo as $tipo) {
                    ?>
                    <tr >
                        <td class="col-4"><?php echo $tipo["nombre"] ?></td>
                        <td class="col-4"> 
                        <form name='form' id='form' method='POST' action='tipoActivos.php'>
                            <input type='hidden' value='<?php echo $tipo["id_tipodeproducto"] ?>' name='id' id='id'>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>