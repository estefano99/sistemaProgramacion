<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");

    $estado = 1;
    $consulta = $conexion -> prepare("SELECT id_tragos,tragos.nombre as 'nombre',descripcion,precio,imagen,favoritos,tipodetragos.nombre as 'tipo' from tragos,tipodetragos where tragos.estado = :estado and tragos.id_tipodetragosFK = tipodetragos.id_tipodetragos");
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

        <div id="mensaje-de-error"></div>
        
        <div class="row">  
            <div class="col-md-12 flex-wrap " id="div_contenedor_tabla">

                    <!-- FILTERS -->
                <div class="d-flex justify-content-center align-items-center mt-4 bg-light">
                    <div class="form-group">
                        <label for="nombre_filter" class="form-label">Nombre:</label> <br>                  
                        <input type="text" id="nombre_filter" class="form-control" aria-describedby="helpId" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="tipo_filter" class="form-label">Tipo:</label> <br>                  
                        <input type="text" id="tipo_filter" class="form-control" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <label for="precio_filter" class="form-label">Precio:</label> <br>                  
                        <input type="text" id="precio_filter" class="form-control" aria-describedby="helpId">
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
                        <th class="col-1">tipo</th>
                        <th class="col-1">Precio</th>
                        <th class="col-2">Descripción</th>
                        <th class="col-1">Favoritos</th> 
                        <th class="col-1">Imagen</th> 
                        <th class="col-1">Acciones</th>
                    </tr>
                </thead>
                <tbody class="tbody_tragos">
                    
                </tbody>
            </table>
        </div>
    </div>
</section>
<script src="./tragos.js"></script>
<?php include("../template/footer.php") ?>