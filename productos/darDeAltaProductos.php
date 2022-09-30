<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");
    $estado = 1;
    $consulta = $conexion -> prepare("SELECT id_medida,medida from medida where estado = :estado order by medida asc");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaMedidas = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    $consulta = $conexion -> prepare("SELECT id_tipodeproducto,nombre from tipodeproducto where estado = :estado order by nombre asc");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaTipo = $consulta -> fetchAll(PDO::FETCH_ASSOC);
?>
    <section class="container">
        <div class="row d-flex flex-direction-column justify-content-center align-content-center mb-4">
            <div class="col-md-5">
                <div class="m-5">
                    <h1>Crear producto</h1>
                </div>
                    
                <div class="card text-center">
                    <!-- cabecera card -->
                    <div class="card-header">
                        Datos del producto
                    </div>
                    <!-- body card -->
                    <div class="card-body">
                        <!-- Formulario -->
                    <form action="altaProductos.php" name="form" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre: </label>
                            <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="Nombre" placeholder="Nombre producto">
                        </div>
                        <div class="mb-3">
                            <label for="tipoProducto" class="form-label">Tipo de producto: </label>
                            <select class="form-select" name="tipoProducto" id="tipoProducto" aria-label="Default select example">
                                <option selected>Elegir tipo de producto</option>
                                <?php 
                                    foreach ($listaTipo as $tipo) {
                                ?>
                                <option value=<?php echo $tipo["id_tipodeproducto"] ?>> <?php echo $tipo["nombre"] ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="medida" class="form-label">Medida: </label>
                            <select class="form-select" name="medida" id="medida" aria-label="Default select example">
                                <option selected>Elegir medida</option>
                                <?php 
                                    foreach ($listaMedidas as $medidas) {
                                ?>
                                <option value=<?php echo $medidas["id_medida"] ?>> <?php echo $medidas["medida"] ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio: </label>
                            <input type="text" class="form-control" name="precio" id="precio" placeholder="Ingresar precio">
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen: </label>
                            <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Ingresar imagen">
                        </div>
                        <button type="submit" name="botonAccion" value="insertar" class="btn btn-primary">Crear producto</button>
                </form>
                </div>
                
            </div>
        </div>
            
        </div>
    </section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>