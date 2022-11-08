<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");

    if (isset($_GET["url"])) $id = $_GET["url"];  //Si se envia algo se guarda en la variable id
    $estado = 1;

    //Muestro datos de los productos
    $consulta = $conexion -> prepare("SELECT * from productos where id_productos = :id ");
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $listaProductos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    //Medida
    $consulta = $conexion -> prepare("SELECT medida from medida,productos where productos.id_medidaFK = medida.id_medida and id_productos = :id;");
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $medidas = $consulta -> fetch(PDO::FETCH_LAZY);

    //Para el select de Proveedores
    $consultaProv = $conexion -> prepare("SELECT id_proveedores,nombre from proveedores where estado = :estado");
    $consultaProv -> bindParam("estado",$estado);
    $consultaProv -> execute();
    $listaProv = $consultaProv -> fetchAll(PDO::FETCH_ASSOC);

    //Para poner limite en input de  la fecha y poner por default en la fecha de hoy
    $fechaActual = date('Y-m-d');
    
?>
    <section class="container">
        <div class="row d-flex flex-direction-column justify-content-center align-content-center mb-4">
            <div class="m-5 div_titulo">
                <h1>Ingresar stock</h1>
            </div>
            <div class="col-md-5 shadow-lg p-3 mb-5 bg-body rounded text-center">
                <div class="card text-center">
                    <!-- cabecera card -->
                    <div class="card-header">
                        Datos de la compra
                    </div>
                    <!-- body card -->
                    <div class="card-body">
                        <!-- Formulario -->
                    <form action="registrarCompras.php" name="form" method="POST">
                        <?php
                            foreach ($listaProductos as $productos) {
                        ?>
                        <div class="mb-3">
                            <input type="hidden"  class="form-control"  name="id" id="id" value="<?php echo $productos['id_productos']?>">
                            <label for="nombre" class="form-label">Nombre: </label>
                            <input type="text"  class="form-control"  name="nombre" id="nombre" value="<?php echo $productos['nombre']?>">
                            <?php
                            }
                        ?>
                        </div>
                        <div class="mb-3">
                            <label for="medida" class="form-label">Medida: </label>
                            <input type="text"  class="form-control"  name="medida" id="medida" value="<?php echo $medidas['medida']?>">
                        </div>
                        <div class="mb-3">
                            <label for="cantidad"  class="form-label">Cantidad comprada: </label>
                            <input type="number" min="0" required class="form-control" name="cantidad" id="cantidad" placeholder="Ingresar cantidad">
                        </div>
                        <div class="mb-3">
                            <label for="precioUnidad" class="form-label">Precio actual por unidad: </label><br>
                            <small class="text-warning">¿Desea modificarlo?</small>
                            <input type="number" min="0" required class="form-control" name="precioUnidad" id="precioUnidad" value="<?php echo $productos['precio'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha: </label><br>
                            <input type="date"  required class="form-control" name="fecha" max="<?php echo $fechaActual ?>" value="<?php echo $fechaActual ?>" id="fecha">
                        </div>
                        <div class="mb-3">
                            <label for="proveedor" class="form-label">Proveedores: </label>
                            <select class="form-select" name="proveedor" id="proveedor" aria-label="Default select example">
                                <div class="alerta">
                                    <?php
                                    if ($mensaje) {
                                        echo "<div class='alert alert-danger alert-dismissible w-50  d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                                             $mensaje
                                            <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                                            </div>";
                                    }
                                    ?>
                                </div>
                                <?php 
                                    foreach ($listaProv as $prov) {
                                ?>
                                <option value="<?php echo $prov['id_proveedores'] ?>"> <?php echo $prov["nombre"] ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <div>
                            <button type="submit" name="botonAccion" value="insertar" class="btn btn-primary" >Ingresar stock</button>
                            <a href="productos.php"><button type="button" name="botonAccion" value="insertar" class="btn btn-danger" >Cancelar</button></a>
                        </div>
                        
                </form>
                </div>
                
            </div>
        </div>
            
        </div>
    </section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Desabilita el campo nombre del producto al cargar el documento
    document.addEventListener("DOMContentLoaded",() =>{
        const nombre = document.querySelector("#nombre");
        const medida = document.querySelector("#medida");
        nombre.disabled = true
        medida.disabled = true
    })

</script>
</body>
</html>