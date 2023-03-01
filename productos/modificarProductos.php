<?php
    session_start();
    include("../config/db.php");
    $estado = 1;
    if (isset($_GET["upd"])) $id = $_GET["upd"];  //Si se envia algo se guarda en la variable id

    $consulta = $conexion -> prepare("SELECT id_productos,productos.nombre as 'nombre',precio,imagen,medida.medida as 'medida',id_medidaFK,tipodeproducto.nombre as 'tipo',id_tipoBebidaFK
    from productos,medida,tipodeproducto
    where id_medidaFK = id_medida and id_tipoBebidaFK = id_tipodeproducto and id_productos = :id_productos
    order by productos.nombre asc");

    $consulta -> bindParam("id_productos",$id);
    $consulta -> execute();
    $datos = $consulta -> fetch(PDO::FETCH_LAZY);

    $consultaMedida = $conexion -> prepare("SELECT * from medida where estado = :estado");
    $consultaMedida -> bindParam(":estado",$estado);
    $consultaMedida -> execute();
    $listaMedida = $consultaMedida -> fetchAll(PDO::FETCH_ASSOC);

    $consultaTipo = $conexion -> prepare("SELECT * from tipodeproducto where estado = :estado");
    $consultaTipo -> bindParam(":estado",$estado);
    $consultaTipo -> execute();
    $listaTipo = $consultaTipo -> fetchAll(PDO::FETCH_ASSOC);

    include("../template/cabecera.php");
?>
   
        <section class="container">
            <div class="row d-flex flex-direction-column justify-content-center align-content-center">

                <div class="div_titulo mb-4">
                    <h1>Modificar producto</h1>
                </div>
                <div class="col-md-5 m-4 shadow-lg p-3 mb-5 bg-body rounded text-center">
                    
                    <div class="card">
                        <!-- cabecera card -->
                        <div class="card-header">
                            Datos del producto
                        </div>
                        <!-- body card -->
                        <div class="card-body">
                            <!-- Formulario -->
                            <form action="modificadoProducto.php" name="formM" method="POST" enctype="multipart/form-data" >
                                <!-- id oculto -->
                                <input type="hidden" name="id" id="id" value="<?php echo $datos["id_productos"]; ?>" class="form-control" aria-describedby="helpId">
                                <div class="form-group">
                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text"  name="nombre" id="nombre" value="<?php echo $datos["nombre"]; ?>" class="form-control" aria-describedby="helpId">
                            </div>
                            <!-- imagen -->
                            <div class="form-group">
                                <label for="medida" class="form-label">Medida:</label> <br>
                                 <!-- Foreach de Medida que tiene en el selected el id que ya tenia y su nombre -->                  
                                <select class="form-select" name="medida" id="medida" aria-label="Default select example">
                                <option selected value="<?php echo $datos["id_medidaFK"] ?>"><?php echo $datos["medida"] ?></option>
                                <?php 
                                    foreach ($listaMedida as $medida) {
                                ?>
                                <option value=<?php echo $medida["id_medida"] ?>> <?php echo $medida["medida"] ?></option>
                                <?php } ?> 
                            </select>
                            </div>
                            <div class="form-group">
                                <label for="precio" class="form-label">Precio:</label> <br>                  
                                <input type="text"  name="precio" id="precio" value="<?php echo $datos["precio"]; ?>" class="form-control" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <label for="tipo" class="form-label">Tipo:</label> <br>                  
                                <select class="form-select" name="tipoProducto" id="tipoProducto" aria-label="Default select example">
                                    <!-- Foreach de tipo de bebida que tiene en el selected el id que ya tenia y su nombre -->
                                <option selected value="<?php echo $datos["id_tipoBebidaFK"] ?>"><?php echo $datos["tipo"] ?></option>
                                <?php 
                                    foreach ($listaTipo as $tipo) {
                                ?>
                                <option value=<?php echo $tipo["id_tipodeproducto"] ?>> <?php echo $tipo["nombre"] ?></option>
                                <?php } ?> 
                            </select>
                            </div>
                            <div class="form-group">
                            <label for="imagen" class="form-label">Imagen:</label> <br>

                                <?php if ($datos["imagen"] != "") { ?>
                                    <img src="../imagenesProductos/<?php echo $datos["imagen"] ;?>" id="img" width="100px" alt="imagen">  <br> <br>                       
                                <?php } ?>   

                                <input type="file" name="imagen" id="imagen" class="form-control" placeholder="Ingresar Imagen" aria-describedby="helpId">
                            </div>
                            <br>
                        </div>
                        <div class="alert alert-danger mt-2" class="text-center" id="error_validacion" style="display:none"></div> 
                        <!-- botones -->
                        <div class="d-flex justify-content-center" role="group" aria-label="">
                            <button type="button" name="accion" value="modificar" id="btnModificarProductos" class="btn btn-success m-2">Modificar</button>
                            <a href="productos.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button> </a>
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
        const btnM = document.querySelector("#btnModificarProductos");
        btnM.addEventListener("click", () =>{
            const nombreM = document.querySelector("#nombre").value;
            const imagenM = document.querySelector("#img").value;
            const precioM = document.querySelector("#precio").value;
            const tipoM = document.querySelector("#tipoProducto").value;
            const medidaM = document.querySelector("#medida").value;
            const div_errorM = document.querySelector("#error_validacion");
            // e.preventDefault();
            if (nombreM == "") {
                div_errorM.style.display = "block";
                div_errorM.textContent = "Nombre campo obligatorio";
                setTimeout(() => {
                    div_errorM.style.display = 'none';
                }, 3000); 
            }else if(isNaN(precioM) || precioM == "" || precioM < 0){
                div_errorM.style.display = "block";
                div_errorM.textContent = "Precio mal ingresado";
                setTimeout(() => {
                    div_errorM.style.display = 'none';
                }, 3000); 
            }else if(tipoM == "Elegir tipo de producto"){
                div_errorM.style.display = "block";
                div_errorM.textContent = "Tipo de producto campo obligatorio";
                setTimeout(() => {
                    div_errorM.style.display = 'none';
                }, 3000); 
            }else if(medidaM == "Elegir medida"){
                div_errorM.style.display = "block";
                div_errorM.textContent = "Medida campo obligatorio";
                setTimeout(() => {
                    div_error.style.display = 'none';
                }, 3000); 
            }else if(imagenM == ""){
                div_errorM.style.display = "block";
                div_errorM.textContent = "Imagen campo obligatorio";
                setTimeout(() => {
                    div_errorM.style.display = 'none';
                }, 3000); 
            }else{
                document.formM.submit();
            }
    })
    </script>
</html>