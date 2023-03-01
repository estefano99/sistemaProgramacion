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
            <div class="m-5 div_titulo">
                <h1>Crear producto</h1>
            </div>
            <div class="col-md-5">
                    
                <div class="card shadow-lg p-3 mb-5 bg-body rounded text-center">
                    <!-- cabecera card -->
                    <div class="card-header bg-primary text-white font fs-5">
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
                        <div class="alert alert-danger mt-2" class="text-center" id="error_validacion" style="display:none"></div> 
                        <div>
                            <button type="button" name="botonAccion" id="btnAltaProductos" value="insertar" class="btn btn-primary">Crear producto</button>
                            <a href="productos.php"><button type="button" name="botonAccion" value="insertar" class="btn btn-danger" >Cancelar</button></a>
                        </div>
                </form>
                </div>
                
            </div>
        </div>
            
        </div>
    </section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
<script>
    const btn = document.querySelector("#btnAltaProductos");
    btn.addEventListener("click", () =>{
        const nombre = document.querySelector("#nombre").value;
        const imagen = document.querySelector("#imagen").value;
        const precio = document.querySelector("#precio").value;
        const tipo = document.querySelector("#tipoProducto").value;
        const medida = document.querySelector("#medida").value;
        const div_error = document.querySelector("#error_validacion");
        // e.preventDefault();
        if (nombre == "") {
            div_error.style.display = "block";
            div_error.textContent = "Nombre campo obligatorio";
            setTimeout(() => {
                div_error.style.display = 'none';
            }, 3000); 
        }else if(isNaN(precio) || precio == "" || precio < 0){
            div_error.style.display = "block";
            div_error.textContent = "Precio mal ingresado";
            setTimeout(() => {
                div_error.style.display = 'none';
            }, 3000); 
        }else if(tipo == "Elegir tipo de producto"){
            div_error.style.display = "block";
            div_error.textContent = "Tipo de producto campo obligatorio";
            setTimeout(() => {
                div_error.style.display = 'none';
            }, 3000); 
        }else if(medida == "Elegir medida"){
            div_error.style.display = "block";
            div_error.textContent = "Medida campo obligatorio";
            setTimeout(() => {
                div_error.style.display = 'none';
            }, 3000); 
        }else if(imagen == ""){
            div_error.style.display = "block";
            div_error.textContent = "Imagen campo obligatorio";
            setTimeout(() => {
                div_error.style.display = 'none';
            }, 3000); 
        }else{
            document.form.submit();
        }
    })
</script>
</html>