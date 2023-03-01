<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");
?>

    <section class="container">

        <div class="d-flex justify-content-center m-4 div_titulo">
            <h1>Tipo de Trago</h1>
        </div>

        <div class="d-flex justify-content-center mt-5 w-10">
            <button class="btn btn-primary w-25" data-bs-toggle="modal" data-bs-target="#modalTipoDeTrago">Agregar tipo de trago</button>
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

            <div class="d-flex justify-content-center align-items-center mt-4">
                <div>
                    <input type="text" id="input_filter" autofocus>
                </div>
                <div class="mx-2  btn-group">
                    <button class="btn btn-dark" type="button" id="btn_filter">Buscar</button>
                    <button class="btn btn-dark" type="button" id="btn_filter_regresar">Regresar</button>
                </div>
            </div>

            <table class="table table-responsive table-bordered table-striped my-3 text-center  mx-auto">
        <?php
        //Update
        $nombreModificado = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
        if ($nombreModificado) {
            echo "<div class='alert alert-success mt-4 alert-dismissible d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
            Tipo de trago: $nombreModificado modificado correctamente 
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
                    <th class="col-4">Nombre tipo de trago</th>
                    <th class="col-4">Acciones</th>
                    </tr>
                </thead>
                <tbody class="tbody_tipoDeTragos">
                    
                </tbody>
            </table>
            </div>
        </div>
    </section>
    <!-- MODAL -->
    <div class="modal fade" id="modalTipoDeTrago" tabindex="-1" aria-hidden="true" aria-labelledy="modalTitulo">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="">Crear Tipo de tragos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    <form action="altaTipoDeTragos.php" name="form" method="POST" >
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre: </label>
                            <input autofocus type="text" class="form-control" name="nombre" id="nombre" aria-describedby="Nombre" placeholder="Nombre tipo de trago">
                        </div>
                         <!-- Div oculto -->
                         <div class="alert alert-danger mt-2" class="text-center" id="error_val_tipo" style="display:none"></div>
                        <!-- botones -->
                        <div class="d-flex justify-content-center" role="" aria-label="">
                        <button type="button" name="botonAccion" value="insertar" id="btnTipo" class="btn btn-primary">Crear tipo de trago</button>
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

            const btnInactivo= document.querySelector("#inactivos");
        
    btnInactivo.addEventListener("click",() =>{
        <?php 
             $estado2 = 0;
             $consulta = $conexion -> prepare("SELECT * from tipodetragos where estado = :estado2 order by nombre asc");
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
                                <th class="col-3">Nombre tipo de trago</th>
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
                            <input type='hidden' value='<?php echo $tipo["id_tipodetragos"] ?>' name='id' id='id'>
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
<script src="tipoDeTragos.js"></script>
<?php include("../template/footer.php") ?>
