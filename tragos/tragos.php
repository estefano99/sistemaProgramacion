<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");

    $estado = 1;
    $consulta = $conexion -> prepare("SELECT id_tragos,nombre,descripcion,precio,imagen,favoritos from tragos where estado = :estado");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaTragos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    $palabras = "";
?>
<section class="container-fluid">
    <div class="div_titulo">
            <h1>Tragos</h1>
        </div>
       <div class="d-flex justify-content-center mt-5 w-10">
            <a href="darDeAltaTragos.php" class="mx-2 w-25 d-flex justify-content-center"><button class="btn btn-primary w-100">Agregar Trago</button></a>
        </div>
            
        <div class="m-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="d-flex w-25">
                   <input type="button" id="activos" class="btn btn-success mx-2 w-75" value="Activos">
                   <input type="button" id="inactivos" class="btn btn-secondary mx-2 w-75" value="Inactivos">
                </div>
            </div>
        </div>
        <div class="container d-flex justify-content-center ">  
            <?php
                $mensajeAltaError = (isset($_GET["alt"])) ? $_GET["alt"] : "" ;
                if ($mensajeAltaError) {
                    echo "<div class='alert alert-danger text-danger alert-dismissible w-50 mt-3  d-flex justify-content-center' rol='alert' id='compraMensaje' alert-dismissible fade show >
                     $mensajeAltaError 
                    <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                 }
                $mensajeAltaConfirmacion = (isset($_GET["altc"])) ? $_GET["altc"] : "" ;
                if ($mensajeAltaConfirmacion) {
                    echo "<div class='alert alert-success alert-dismissible w-50 mt-3  d-flex justify-content-center' rol='alert' id='compraMensaje' alert-dismissible fade show >
                     $mensajeAltaConfirmacion 
                    <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                 }
            ?>
        </div>
        
        <div class="row">
            
        <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                <thead>
                    <tr>
                        <th class="col-2">Nombre</th>
                        <th class="col-1">Precio</th>
                        <th class="col-2">Descripción</th>
                        <th class="col-2">Medidas</th> 
                        <th class="col-1">Favoritos</th> 
                        <th class="col-2">Imagen</th> 
                        <th class="col-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($listaTragos as $tragos) {
                    ?>
                    <tr>
                        <td ><?php echo $tragos["nombre"] ?></td>
                        <td><?php echo $tragos["precio"] ?></td>
                        <td><?php echo $tragos["descripcion"] ?></td>
                        <?php
                            //Esta consulta trae el producto que lleva el trago y las medidas
                            $consulta = $conexion -> prepare("SELECT productos.nombre as 'producto',cantidad_medida from productos,prod_tragos where  prod_tragos.id_tragosFK = :id_tragos and productos.id_productos = prod_tragos.id_productosFK");
                            $consulta -> bindParam("id_tragos",$tragos["id_tragos"]);
                            $consulta -> execute();
                            $listaMedidasProductos = $consulta ->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($listaMedidasProductos as $medidaProductos) {
                                //Concateno los productos y las medidas del trago y lo muestro debajo. Si no es el ultimo caracter muestro guion
                            $palabras .= $medidaProductos["cantidad_medida"] . " " . $medidaProductos["producto"] . $lastChar = substr($palabras, -1) ? "" : " - ";
                        ?>
                        <?php } ?>
                        <td><?php echo $palabras ?></td>
                        <!-- Reinicio la variable  -->
                        <?php $palabras = ""; ?> 
                        <td><?php echo $tragos["favoritos"] ?></td>
                        <td><img src="../imagenesTragos/<?php echo $tragos["imagen"];?>" width="100px" alt="imagen"></td>
                        <td >
                            <a href="modificarTragos.php?upd=<?php echo $tragos["id_tragos"] ?>" ><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                            </a>
                            <a href="eliminarTragos.php?usr=<?php echo $tragos["id_tragos"] ?>"class="w-100 h-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>
                            </div>
                        </td>
                       
                    </tr>   
                    <?php  } ?>
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
                            <th class="col-1">Precio</th>
                            <th class="col-2">Descripción</th>
                            <th class="col-2">Medidas</th> 
                            <th class="col-1">Favoritos</th> 
                            <th class="col-2">Imagen</th> 
                            <th class="col-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($listaTragos as $tragos) {
                        ?>
                        <tr>
                            <td ><?php echo $tragos["nombre"] ?></td>
                            <td><?php echo $tragos["precio"] ?></td>
                            <td><?php echo $tragos["descripcion"] ?></td>
                            <?php
                                //Esta consulta trae el producto que lleva el trago y las medidas
                                $consulta = $conexion -> prepare("SELECT productos.nombre as 'producto',cantidad_medida from productos,prod_tragos where  prod_tragos.id_tragosFK = :id_tragos and productos.id_productos = prod_tragos.id_productosFK");
                                $consulta -> bindParam("id_tragos",$tragos["id_tragos"]);
                                $consulta -> execute();
                                $listaMedidasProductos = $consulta ->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($listaMedidasProductos as $medidaProductos) {
                                    //Concateno los productos y las medidas del trago y lo muestro debajo. Si no es el ultimo caracter muestro guion
                                $palabras .= $medidaProductos["cantidad_medida"] . " " . $medidaProductos["producto"] . $lastChar = substr($palabras, -1) ? "" : " - ";
                            ?>
                            <?php } ?>
                            <td><?php echo $palabras ?></td>
                            <!-- Reinicio la variable  -->
                            <?php $palabras = ""; ?> 
                            <td><?php echo $tragos["favoritos"] ?></td>
                            <td><img src="../imagenesTragos/<?php echo $tragos["imagen"];?>" width="100px" alt="imagen"></td>
                            <td >
                                <a href="modificarTragos.php?upd=<?php echo $tragos["id_tragos"] ?>" ><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <a href="eliminarTragos.php?usr=<?php echo $tragos["id_tragos"] ?>"class="w-100 h-100"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 iconos">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </a>
                                </div>
                            </td>
                           
                        </tr>   
                        <?php  } ?>
                </table>
            </div>
        </div>`
    
    })

    btnInactivo.addEventListener("click",() =>{
        <?php 
             $estado = 0;
             $consulta = $conexion -> prepare("SELECT id_tragos,nombre,descripcion,precio,imagen,favoritos from tragos where estado = :estado");
             $consulta -> bindParam("estado",$estado);
             $consulta -> execute();
             $listaTragos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
         
             $palabras = "";
        ?>
        limpiarHTML();

        div_padre.innerHTML = `<div class="row">
            
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">
                    <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                    <thead>
                        <tr>
                            <th class="col-2">Nombre</th>
                            <th class="col-1">Precio</th>
                            <th class="col-2">Descripción</th>
                            <th class="col-2">Medidas</th> 
                            <th class="col-1">Favoritos</th> 
                            <th class="col-2">Imagen</th> 
                            <th class="col-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($listaTragos as $tragos) {
                        ?>
                        <tr>
                            <td ><?php echo $tragos["nombre"] ?></td>
                            <td><?php echo $tragos["precio"] ?></td>
                            <td><?php echo $tragos["descripcion"] ?></td>
                            <?php
                                //Esta consulta trae el producto que lleva el trago y las medidas
                                $consulta = $conexion -> prepare("SELECT productos.nombre as 'producto',cantidad_medida from productos,prod_tragos where  prod_tragos.id_tragosFK = :id_tragos and productos.id_productos = prod_tragos.id_productosFK");
                                $consulta -> bindParam("id_tragos",$tragos["id_tragos"]);
                                $consulta -> execute();
                                $listaMedidasProductos = $consulta ->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($listaMedidasProductos as $medidaProductos) {
                                    //Concateno los productos y las medidas del trago y lo muestro debajo. Si no es el ultimo caracter muestro guion
                                $palabras .= $medidaProductos["cantidad_medida"] . " " . $medidaProductos["producto"] . $lastChar = substr($palabras, -1) ? "" : " - ";
                            ?>
                            <?php } ?>
                            <td><?php echo $palabras ?></td>
                            <!-- Reinicio la variable  -->
                            <?php $palabras = ""; ?> 
                            <td><?php echo $tragos["favoritos"] ?></td>
                            <td><img src="../imagenesTragos/<?php echo $tragos["imagen"];?>" width="100px" alt="imagen"></td>
                            <td>
                            <form name='form' id='form' method='POST' action='tragosActivos.php'>
                            <input type='hidden' value='<?php echo $tragos["id_tragos"] ?>' name='id' id='id'>
                            <button type='submit' class='btn btn-primary'> Activar</button>
                            </form>
                            </td>
                           
                        </tr>   
                        <?php  } ?>
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