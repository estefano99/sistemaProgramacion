<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");

    if (isset($_GET["url"])) $id = $_GET["url"];  //Si se envia algo se guarda en la variable id
    $estado = 1;

    //Muestro datos de los productos
    $consulta = $conexion -> prepare("SELECT nombre from productos where estado = :estado group by nombre");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaProductos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    
    //Medida
    $consulta = $conexion -> prepare("SELECT * from medida where estado = :estado");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listamedidas = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    
    //Para el select de Proveedores
    $consultaProv = $conexion -> prepare("SELECT id_proveedores,nombre from proveedores where estado = :estado");
    $consultaProv -> bindParam("estado",$estado);
    $consultaProv -> execute();
    $listaProv = $consultaProv -> fetchAll(PDO::FETCH_ASSOC);

    //Para poner limite en input de  la fecha y poner por default en la fecha de hoy
    $fechaActual = date('Y-m-d');
    
?>
    <section class="container bg-success"> 
        <div class="row filaContenedor m-2 bg-warning">

            <!-- FORMULARIO -->
            <form action="registrarDinamico.php" class="contenedor-formulario d-flex flex-column justify-content-center" name="form" id="form_compras" method="POST">

                <!-- TITULO DEL FORM -->
                <legend class="text-center">AGREGAR PRODUCTOS A LA COMPRA</legend>
                <div class="botones d-flex flex-row justify-content-around w-50 mx-auto mb-5">
                    <button type="button" name="" id="btnAgregar" value="insertar" class="btn btn-primary" >Agregar + </button>
                    <button type="button" name="" id="btnEliminar" value="insertar" class="btn btn-danger" >Eliminar + </button>
                    <button type="submit" name="botonAccion" value="insertar" class="btn btn-primary" >Ingresar stock</button>
                </div>

                <!-- CONTENEDOR DE PRODUCTOS A INGRESAR -->
                <div class="contenedor-productos">

                    <!-- PRODUCTO ITEM -->
                    <div class="producto-item d-flex flex-row justify-content-between align-content-center border-dark border-bottom">
                        <!-- PRODUCTO -->
                        <div class="elemento_input mb-3">
                            <label for="producto" class="form-label">Producto: </label>
                            <select class="form-select" name="producto[]" id="producto" aria-label="Default select example">
                                <?php 
                                foreach ($listaProductos as $productos) {
                                ?>
                                <option value="<?php echo $productos['nombre'] ?>"> <?php echo $productos["nombre"] ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        
                        <!-- MEDIDA -->
                        <div class="elemento_input mb-3">
                            <label for="medida" class="form-label">Medida: </label>
                            <select class="form-select" name="medida[]" id="medida" aria-label="Default select example">
                                <?php 
                                foreach ($listamedidas as $medidas) {
                                ?>
                                <option value="<?php echo $medidas['id_medida'] ?>"> <?php echo $medidas["medida"] ?></option>
                                <?php } ?> 
                            </select>
                        </div>

                        <!-- PROVEEDOR -->
                        <div class="elemento_input mb-3">
                            <label for="proveedor" class="form-label">Proveedor: </label>
                            <select class="form-select" name="proveedor[]" id="proveedor" aria-label="Default select example">
                                <?php 
                                    foreach ($listaProv as $prov) {
                                        ?>
                                <option value="<?php echo $prov['id_proveedores'] ?>"> <?php echo $prov["nombre"] ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <!-- FECHA -->
                        <div class="elemento_input mb-3">
                            <label for="fecha" class="form-label">Fecha: </label><br>
                            <input type="date"  required class="form-control" name="fecha[]" max="<?php echo $fechaActual ?>" value="<?php echo $fechaActual ?>" id="fecha">
                        </div>

                        
                        <!-- CANTIDAD -->
                        <div class="elemento_input mb-3">
                            <label for="cantidad"  class="form-label">Cantidad: </label>
                            <input type="number" min="0" required class="form-control" name="cantidad[]" id="cantidad" placeholder="Ingresar cantidad">
                        </div>
                    </div>
                </div>
            </form>
                    
        </div>


    </section>


<script>
const btnAgregar = document.querySelector("#btnAgregar");
const contenedorProductos = document.querySelector(".contenedor-productos");
const form = document.querySelector(".contenedor-formulario");
const btnEliminar = document.querySelector("#btnEliminar");
const producto_item = document.querySelector(".producto-item");

btnAgregar.addEventListener("click", () => {
    const producto_item = document.createElement('div');
    producto_item.classList.add('producto-item', 'd-flex', 'flex-row', 'justify-content-between', 'align-content-center', 'border-dark' ,'border-bottom')
    producto_item.innerHTML = `
    <!-- PRODUCTO -->
    <div class="elemento_input mb-3">
        <label for="producto" class="form-label">Producto: </label>
        <select class="form-select" name="producto[]" id="producto" aria-label="Default select example">
            <?php 
            foreach ($listaProductos as $productos) {
            ?>
            <option value="<?php echo $productos['nombre'] ?>"> <?php echo $productos["nombre"] ?></option>
            <?php } ?> 
        </select>
    </div>

    <!-- MEDIDA -->
    <div class="elemento_input mb-3">
        <label for="medida" class="form-label">Medida: </label>
        <select class="form-select" name="medida[]" id="medida" aria-label="Default select example">
            <?php 
            foreach ($listamedidas as $medidas) {
            ?>
            <option value="<?php echo $medidas['id_medida'] ?>"> <?php echo $medidas["medida"] ?></option>
            <?php } ?> 
        </select>
    </div>
    
    <!-- PROVEEDOR -->
    <div class="elemento_input mb-3">
        <label for="proveedor" class="form-label">Proveedores: </label>
        <select class="form-select" name="proveedor[]" id="proveedor" aria-label="Default select example">
            <?php 
                foreach ($listaProv as $prov) {
                    ?>
            <option value="<?php echo $prov['id_proveedores'] ?>"> <?php echo $prov["nombre"] ?></option>
            <?php } ?> 
        </select>
    </div>
    <!-- FECHA -->
    <div class="elemento_input mb-3">
        <label for="fecha" class="form-label">Fecha: </label><br>
        <input type="date"  required class="form-control" name="fecha[]" max="<?php echo $fechaActual ?>" value="<?php echo $fechaActual ?>" id="fecha">
    </div>

    <!-- CANTIDAD -->
    <div class="elemento_input mb-3">
        <label for="cantidad"  class="form-label">Cantidad comprada: </label>
        <input type="number" min="0" required class="form-control" name="cantidad[]" id="cantidad" placeholder="Ingresar cantidad">
    </div>

    `;

    contenedorProductos.appendChild(producto_item);
})
//Elimina el ultimo nodo hijo de contenedor de productos
btnEliminar.addEventListener("click", () => {
    contenedorProductos.removeChild(contenedorProductos.lastChild);
})
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>