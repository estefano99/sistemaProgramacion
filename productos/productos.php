<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");

    $estado = 1;
    $consulta = $conexion -> prepare("SELECT id_productos,productos.nombre as 'nombre',stock,precio,imagen,medida.medida as 'medida',tipodeproducto. nombre as 'tipo'
    from productos,medida,tipodeproducto
    where id_medidaFK = id_medida and id_tipoBebidaFK = id_tipodeproducto and productos.estado = :estado
    order by productos.nombre asc");

    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaProductos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    
?>

    <!-- Cierre NAV -->

    <section class="container-fluid">
        <div class="div_titulo">
            <h1>Productos</h1>
        </div>
        <!-- DIVS DE MENSAJES DE CONFIRMACION -->
        <!-- Mensaje Compra -->
        <div class="container d-flex justify-content-center ">  
            <?php
                $compraMensaje = (isset($_GET["cmp"])) ? $_GET["cmp"] : "" ;
                if ($compraMensaje) {
                    echo "<div class='alert alert-success alert-dismissible w-50 mt-3  d-flex justify-content-center' rol='alert' id='compraMensaje' alert-dismissible fade show >
                     $compraMensaje 
                    <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                 }
                //   Mensaje Modificado correctamente 
                 $mensajeNombre = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
                 if ($mensajeNombre) {
                     
                     echo "<div class='alert alert-success alert-dismissible w-50 mt-3 d-flex justify-content-center' rol='alert' id='mensajeNombre' alert-dismissible fade show >
                     producto $mensajeNombre modificado correctamente 
                     <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                     </div>";
                 }
                 //Mensaje Alta 
                 $mensajeConfirmacion = (isset($_GET["msg"])) ? $_GET["msg"] : "" ;
                 if ($mensajeConfirmacion) {
                     echo "<div class='alert alert-success alert-dismissible w-50 mt-3  d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                     producto $mensajeConfirmacion creado correctamente 
                     <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                     </div>";
                 }

                 // Mensaje Reduccion stock 
                $mensajeDescuento = (isset($_GET["desc"])) ? $_GET["desc"] : "" ;
                if ($mensajeDescuento) {
                    echo "<div class='alert alert-success alert-dismissible w-50 mt-3 d-flex justify-content-center' rol='alert' id='mensajeDescuento' alert-dismissible fade show >
                    $mensajeDescuento   
                    <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }

               // Mensaje Producto existente 
                $mensajeError = (isset($_GET["msge"])) ? $_GET["msge"] : "" ;
                if ($mensajeError) {
                    echo "<div class='alert alert-danger text-danger alert-dismissible w-50 mt-3 d-flex justify-content-center' rol='alert' id='mensajeDescuento' alert-dismissible fade show >
                     $mensajeError   
                    <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }

                //Mensaje Edicion existente 
                $errorEdicion = (isset($_GET["upde"])) ? $_GET["upde"] : "" ;
                if ($errorEdicion) {
                    echo "<div class='alert alert-danger text-danger alert-dismissible w-50 mt-3 d-flex justify-content-center' rol='alert' id='mensajeDescuento' alert-dismissible fade show >
                     $errorEdicion   
                    <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
            ?>
        </div>

        <!-- DIV CON TABLA -->
        <div class="d-flex justify-content-center mt-5 w-10">
            <a href="darDeAltaProductos.php" class="mx-2 w-25 d-flex justify-content-center"><button class="btn btn-primary w-100">Agregar producto</button></a>
        </div>
            
        <div class="m-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="d-flex w-25">
                   <input type="button" id="activos" class="btn btn-success mx-2 w-75" value="Activos">
                   <input type="button" id="inactivos" class="btn btn-secondary mx-2 w-75" value="Inactivos">
                </div>
            </div>
        </div>
        
        <div class="row">
            
        <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                <thead>
                    <tr>
                        <th class="col-2">Nombre</th>
                        <th class="col-1">Medida</th>
                        <th class="col-2">Stock</th>
                        <th class="col-2">Precio</th> 
                        <th class="col-1">Tipo</th> 
                        <th class="col-2">Imagen</th>
                        <th class="col-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($listaProductos as $productos) {
                    ?>
                    <tr class="my-auto">
                        <td ><?php echo $productos["nombre"] ?></td>
                        <td><?php echo $productos["medida"] ?></td>
                        <td><?php echo $productos["stock"] ?></td>
                        <td><?php echo $productos["precio"] ?></td>
                        <td><?php echo $productos["tipo"] ?></td>
                        <?php (isset($productos)) ?> 
                        <td><img src="../imagenesProductos/<?php echo $productos["imagen"];?>" width="50px" alt="imagen"></td>
                        <td >
                            <a href="comprasProductos.php?url=<?php echo $productos["id_productos"] ?>" class="a-iconos"><img src="../imagenes/añadir-carrito.png" alt="eliminar" class="iconos"></a>
                            <a href="descuentoProductos.php?url=<?php echo $productos["id_productos"] ?>" class="w-100 h-100"><img src="../imagenes/eliminar-carrito.png" alt="hola" class="iconos"></a>
                            <a href="modificarProductos.php?upd=<?php echo $productos["id_productos"] ?>" ><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <a href="eliminarProductos.php?usr=<?php echo $productos["id_productos"] ?>"class="w-100 h-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>
                            </div>
                        </td>
                       
                    </tr>   
                    <?php } ?>
        </tbody>
    </table>
</div>
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
                    <thead>
                        <tr>
                            <th class="col-2">Nombre</th>
                            <th class="col-1">Medida</th>
                            <th class="col-2">Stock</th>
                            <th class="col-2">Precio</th> 
                            <th class="col-1">Tipo</th> 
                            <th class="col-2">Imagen</th>
                            <th class="col-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($listaProductos as $productos) {
                        ?>
                        <tr>
                            <td ><?php echo $productos["nombre"] ?></td>
                            <td><?php echo $productos["medida"] ?></td>
                            <td><?php echo $productos["stock"] ?></td>
                            <td><?php echo $productos["precio"] ?></td>
                            <td><?php echo $productos["tipo"] ?></td>
                            <?php (isset($productos)) ?> 
                            <td><img src="../imagenesProductos/<?php echo $productos["imagen"];?>" width="100px" alt="imagen"></td>
                            <td >
                                <a href="comprasProductos.php?url=<?php echo $productos["id_productos"] ?>" class="a-iconos"><img src="../imagenes/añadir-carrito.png" alt="eliminar" class="iconos"></a>
                                <a href="descuentoProductos.php?url=<?php echo $productos["id_productos"] ?>" class="w-100 h-100"><img src="../imagenes/eliminar-carrito.png" alt="hola" class="iconos"></a>
                                <a href="modificarProductos.php?upd=<?php echo $productos["id_productos"] ?>" ><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <a href="eliminarProductos.php?usr=<?php echo $productos["id_productos"] ?>"class="w-100 h-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </a>
                                </div>
                            </td>
                           
                        </tr>   
                        <?php } ?>
            </tbody>
        </table>
    </div>
    </div>`
    
    })

    btnInactivo.addEventListener("click",() =>{
        <?php 
             $estado2 = 0;
             $consulta = $conexion -> prepare("SELECT id_productos,productos.nombre as 'nombre',stock,precio,imagen,medida.medida as 'medida',tipodeproducto.nombre as 'tipo'
             from productos,medida,tipodeproducto
             where id_medidaFK = id_medida and id_tipoBebidaFK = id_tipodeproducto and productos.estado = :estado2
             order by productos.nombre asc");
         
             $consulta -> bindParam("estado2",$estado2);
             $consulta -> execute();
             $listaProductos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
        ?>
        limpiarHTML();

        div_padre.innerHTML = `<div class="row">
            
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                    <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                    <thead>
                        <tr>
                            <th class="col-2">Nombre</th>
                            <th class="col-1">Medida</th>
                            <th class="col-2">Stock</th>
                            <th class="col-2">Precio</th> 
                            <th class="col-1">Tipo</th> 
                            <th class="col-2">Imagen</th>
                            <th class="col-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($listaProductos as $productos) {
                        ?>
                        <tr>
                            <td ><?php echo $productos["nombre"] ?></td>
                            <td><?php echo $productos["medida"] ?></td>
                            <td><?php echo $productos["stock"] ?></td>
                            <td><?php echo $productos["precio"] ?></td>
                            <td><?php echo $productos["tipo"] ?></td>
                            <td><img src="../imagenesProductos/<?php echo $productos["imagen"];?>" width="100px" alt="imagen"></td>
                            <td>
                            <form name='form' id='form' method='POST' action='productosActivos.php'>
                            <input type='hidden' value='<?php echo $productos["id_productos"] ?>' name='id' id='id'>
                            <button type='submit' class='btn btn-primary'> Activar</button>
                            </form>
                            </td>
                           
                        </tr>   
                        <?php } ?>
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
    
<?php include("../template/footer.php") ?>
