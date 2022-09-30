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
        <div class="container d-flex justify-content-center mt-3">  
            <?php
                $compraMensaje = (isset($_GET["cmp"])) ? $_GET["cmp"] : "" ;
                if ($compraMensaje) {
                    echo "<div class='alert alert-success alert-dismissible w-50  d-flex justify-content-center' rol='alert' id='compraMensaje' alert-dismissible fade show >
                     $compraMensaje 
                    <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                 }
            ?>
        </div>
        <div class="container d-flex justify-content-center mt-3">  
            <?php
            $mensajeNombre = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
            if ($mensajeNombre) {
                
                echo "<div class='alert alert-success alert-dismissible w-50  d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                producto $mensajeNombre modificado correctamente 
                <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";

            }
            ?>
        </div>
        <div class="container d-flex justify-content-center mt-3">  
            <?php
            $mensajeConfirmacion = (isset($_GET["msg"])) ? $_GET["msg"] : "" ;
            if ($mensajeConfirmacion) {
                echo "<div class='alert alert-success alert-dismissible w-50  d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                producto $mensajeConfirmacion creado correctamente 
                <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";

            }
            ?>
        </div>

        <!-- DIV CON TABLA -->
        <div class="d-flex justify-content-center m-4">
            <a href="darDeAltaProductos.php" class="mx-2"><button class="btn btn-primary ">Agregar producto</button></a>
        </div>
        
        <div class="row">
            
        <div class="col-md-12 flex-wrap ">
                <table class="table table-responsive table-bordered table-striped my-3 text-center mx-auto">  <!--Tiene margen-->
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Medida</th>
                        <th>Stock</th>
                        <th>Precio</th> 
                        <th>Tipo</th> 
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($listaProductos as $productos) {
                    ?>
                    <tr>
                        <td><?php echo $productos["nombre"] ?></td>
                        <td><?php echo $productos["medida"] ?></td>
                        <td><?php echo $productos["stock"] ?></td>
                        <td><?php echo $productos["precio"] ?></td>
                        <td><?php echo $productos["tipo"] ?></td>
                        <td><img src="../imagenesProductos/<?php echo $productos["imagen"];?>" width="150px" alt="imagen"></td>
                        <td>
                            <a href="comprasProductos.php?url=<?php echo $productos["id_productos"] ?>med=2"><button class="btn btn-dark">Compra stock</button></a>
                            <a href="descuentoProductos.php?url=<?php echo $productos["id_productos"] ?>"><button class="btn btn-secondary">Descuento stock</button></a>
                            <a href="modificarProductos.php?upd=<?php echo $productos["id_productos"] ?>"><button class="btn btn-success">Editar</button></a>
                            <a href="eliminarProductos.php?usr=<?php echo $productos["id_productos"] ?>"><button class="btn btn-danger">Eliminar</button></a>
                        </td>
                       
                    </tr>   
                    <?php } ?>
        </tbody>
    </table>
</div>
</div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>