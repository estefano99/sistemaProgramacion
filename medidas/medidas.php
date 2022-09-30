<?php
    session_start();
    include("../config/db.php");
    $estado = 1;
    $consulta = $conexion -> prepare("SELECT * from medida where estado = :estado order by medida asc");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaMedidas = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    include("../template/cabecera.php");
?>

    <section class="container">

        <div class="d-flex justify-content-center m-4">
            <h1>Medidas de los productos</h1>
        </div>

        <div class="d-flex justify-content-center m-4">
            <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalMedidas">Agregar medida</button>
        </div>
        
        <div class="row d-flex justify-content-center">
            <div class="col-6 ">
            <table class="table table-responsive table-bordered table-striped my-3 text-center  mx-auto">
        <?php
        $nombreModificado = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
        if ($nombreModificado) {
            echo "<div class='alert alert-success alert-dismissible   d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
            Medida : $nombreModificado modificada correctamente 
            <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
        ?>
                <thead>
                    <tr>
                    <th class="col-4">Medidas</th>
                    <th class="col-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($listaMedidas as $medidas) {
                ?>
                    <tr>
                        <td>
                            <?php echo $medidas["medida"]; ?>
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $medidas['id_medida'];?>">
                        </td> 
                        <td>
                            <a href="modificarMedidas.php?upd=<?php echo $medidas["id_medida"]?>"><button class="btn btn-success">Editar</button></a>
                            <a href="eliminarMedidas.php?url=<?php echo $medidas["id_medida"]?>"><button class="btn btn-danger" onclick="return eliminar()">Eliminar</button></a>
                        </td> 
                        </tr>
                    <?php }  ?>
                </tbody>
            </table>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalMedidas" tabindex="-1" aria-hidden="true" aria-labelledy="modalTitulo">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 >Crear medida</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                    <form action="altaMedidas.php" name="form" method="POST" >
                        <div class="mb-3">
                            <label for="medida" class="form-label">Medida</label>
                            <input type="text" class="form-control" name="medida" id="medida" aria-describedby="Nombre" placeholder="Ingresar medida">
                        </div>
                        <button type="submit" name="botonAccion" value="insertar" class="btn btn-primary">Crear medida</button>
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