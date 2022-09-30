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

        <div class="d-flex justify-content-center m-4">
            <h1>Tipo de producto</h1>
        </div>

        <div class="d-flex justify-content-center m-4">
            <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalTipoDeProducto">Agregar tipo de producto</button>
        </div>
        
        
        <div class="row d-flex justify-content-center">
            <div class="col-6 ">
            <table class="table table-responsive table-bordered table-striped my-3 text-center  mx-auto">
        <?php
        $nombreModificado = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
        if ($nombreModificado) {
            echo "<div class='alert alert-success alert-dismissible   d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
            Tipo de producto: $nombreModificado modificado correctamente 
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
                            <a href="modificarTipoDeProducto.php?upd=<?php echo $producto["id_tipodeproducto"]?>"><button class="btn btn-success">Editar</button></a>
                            <a href="eliminarTipoDeProducto.php?url=<?php echo $producto["id_tipodeproducto"]?>"><button class="btn btn-danger" onclick="return eliminar()">Eliminar</button></a>
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
                        <button type="submit" name="botonAccion" value="insertar" class="btn btn-primary">Crear tipo de producto</button>
                        </form>
                    </div>
                    <div class="modal-footer"></div>
                    </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function eliminar(){
            const respuesta = confirm("Estás seguro que deseas eliminarlo?");
            if (respuesta == true) {
                return true
            }else{
                return false;
            }
        }
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>