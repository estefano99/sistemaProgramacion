<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");
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
                <!-- FILTERS -->
                <div class="d-flex justify-content-center align-items-center mt-4 bg-light">
                    <div class="form-group">
                        <label for="nombre_filter" class="form-label">Nombre:</label> <br>                  
                        <input type="text" id="nombre_filter" class="form-control" aria-describedby="helpId" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="precio_filter" class="form-label">Precio:</label> <br>                  
                        <input type="text" id="precio_filter" class="form-control" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="medida_filter" class="form-label">Medida:</label> <br>                  
                        <input type="text" id="medida_filter" class="form-control" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="tipo_filter" class="form-label">Tipo:</label> <br>                  
                        <input type="text" id="tipo_filter" class="form-control" aria-describedby="helpId">
                    </div>
                    <div class="mx-2 btn btn-group mt-4">
                            <button class="btn btn-dark" type="button" id="btn_filter">Buscar</button>
                            <button class="btn btn-dark" type="button" id="btn_filter_regresar">Regresar</button>
                    </div>
                </div>
                
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
                    <tbody class="tbody_tipoDeTragos">
                    <div id="mensaje-de-error"></div> <!--Mensaje de error del fetch !-->
                    </tbody>
            </table>
        </div>
</div>
</section>

<script src="./productos.js"></script>
<?php include("../template/footer.php") ?>
