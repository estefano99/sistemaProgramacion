<?php
        session_start();
        include("../config/db.php");
        $txtID = (isset($_POST["txtID"])) ? $_POST["txtID"] : "" ;   //El id lo tengo para usarlo en las modificaciones, cuando presiono el boton seleccionar
         
        //MOSTRAR LISTA DE PROVEEDORES
        $estado = 1;
        $consultaMostrar = $conexion -> prepare("SELECT * from proveedores where estado = :estado order by nombre asc");
        $consultaMostrar -> bindParam("estado",$estado);
        $consultaMostrar -> execute();
        $listaProveedores = $consultaMostrar -> fetchAll(PDO::FETCH_ASSOC);
        
         include("../template/cabecera.php");
?>

    <!-- Cierre navbar -->

    <section class="container-fluid">
        <div class="div_titulo my-3">
            <h1>Proveedores</h1>
        </div>
        <div class="d-flex justify-content-center mt-5 w-10">
           <a href="darDeAlta.php" class="mx-2 w-25 d-flex justify-content-center"><button class="btn btn-primary w-100">Agregar Proveedor</button></a>
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
              
                <!-- Mensaje proveedor existente alta -->
                <div class="container d-flex justify-content-center mt-3">  
                    <?php
                    $mensajeError = (isset($_GET["msge"])) ? $_GET["msge"] : "" ;
                    if ($mensajeError) {
                        echo "<div class='alert alert-danger text-danger alert-dismissible w-50  d-flex justify-content-center' rol='alert' id='mensajeDescuento' alert-dismissible fade show >
                        $mensajeError   
                        <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    }
                    ?>
                </div>
                <!-- Mensaje proveedor existente Edicion -->
                <div class="container d-flex justify-content-center mt-3">  
                    <?php
                    $mensajeError = (isset($_GET["upde"])) ? $_GET["upde"] : "" ;
                    if ($mensajeError) {
                        echo "<div class='alert alert-danger text-danger alert-dismissible w-50  d-flex justify-content-center' rol='alert' id='mensajeDescuento' alert-dismissible fade show >
                        $mensajeError   
                        <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    }
                    ?>
                </div>
                <!-- Mensaje proveedor Edicion correct -->
                <div class="container d-flex justify-content-center mt-3">  
                    <?php
                    $mensajeEdicion = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
                    if ($mensajeEdicion) {
                        echo "<div class='alert alert-success  alert-dismissible w-50  d-flex justify-content-center' rol='alert' id='mensajeDescuento' alert-dismissible fade show >
                        $mensajeEdicion   
                        <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
                    }
                    ?>
                </div>
                
                    <thead >
                    <tr>
                        <th class="col-3">Nombre</th>
                        <th class="col-3">Teléfono</th>
                        <th class="col-3">Cuit</th>
                        <th class="col-3">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- FOREACH -->
                    <?php  
                    foreach ($listaProveedores as $proveedor) {
                    ?>
                    <tr >
                        <td class="col-3"><?php echo $proveedor["nombre"] ?></td>
                        <td class="col-3"> <?php echo $proveedor["telefono"] ?> </td>
                        <td class="col-3"> <?php echo $proveedor["cuit"] ?> </td>
                        <td class="col-3"> 
                            <a href="modificar.php?upd=<?php echo $proveedor["id_proveedores"] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <a href="eliminarProveedor.php?usr=<?php echo $proveedor['id_proveedores'] ?>"">
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
    <script>
    const btnActivo= document.querySelector("#activos");
    const btnInactivo= document.querySelector("#inactivos");
    const div_padre = document.querySelector("#div_contenedor_tabla");
    btnActivo.addEventListener("click",() =>{
        limpiarHTML();

        div_padre.innerHTML = `<div class="row">
            
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                    <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                    <thead >
                    <tr>
                        <th class="col-3">Nombre</th>
                        <th class="col-3">Teléfono</th>
                        <th class="col-3">Cuit</th>
                        <th class="col-3">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- FOREACH -->
                    <?php  
                    foreach ($listaProveedores as $proveedor) {
                    ?>
                    <tr >
                        <td class="col-3"><?php echo $proveedor["nombre"] ?></td>
                        <td class="col-3"> <?php echo $proveedor["telefono"] ?> </td>
                        <td class="col-3"> <?php echo $proveedor["cuit"] ?> </td>
                        <td class="col-3"> 
                            <a href="modificar.php?upd=<?php echo $proveedor["id_proveedores"] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <a href="eliminarProveedor.php?usr=<?php echo $proveedor['id_proveedores'] ?>"">
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
             $consultaMostrar = $conexion -> prepare("SELECT * from proveedores where estado = :estado2 order by nombre asc");
             $consultaMostrar -> bindParam("estado2",$estado2);
             $consultaMostrar -> execute();
             $listaProveedores = $consultaMostrar -> fetchAll(PDO::FETCH_ASSOC);
        ?>
        limpiarHTML();

        div_padre.innerHTML = `<div class="row">
            
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                    <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                        <thead >
                            <tr>
                                <th class="col-3">Nombre</th>
                                <th class="col-3">Teléfono</th>
                                <th class="col-3">Cuit</th>
                                <th class="col-3">Acciones</th>
                            </tr>
                    </thead>
                    <tbody>
                        <!-- FOREACH -->
                    <?php  
                    foreach ($listaProveedores as $proveedor) {
                    ?>
                    <tr >
                        <td class="col-3"><?php echo $proveedor["nombre"] ?></td>
                        <td class="col-3"> <?php echo $proveedor["telefono"] ?> </td>
                        <td class="col-3"> <?php echo $proveedor["cuit"] ?> </td>
                        <td class="col-3"> 
                        <form name='form' id='form' method='POST' action='proveedoresActivos.php'>
                            <input type='hidden' value='<?php echo $proveedor["id_proveedores"] ?>' name='id' id='id'>
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
    </script>
    <?php include("../template/footer.php") ?>