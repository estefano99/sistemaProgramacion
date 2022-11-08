<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");

    $id = (isset($_GET["upd"])) ? $_GET["upd"] : "";
    //Trae los datos del trago.
    $consulta = $conexion -> prepare("SELECT * from tragos where id_tragos = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $listaTragos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    
    //Trae los nombres de los productos,id y la medida de la Tabla Intermedia.
    $consulta = $conexion -> prepare("SELECT id_productosFK,productos.nombre as 'nombre',cantidad_medida from prod_tragos,productos where id_tragosFK = :id and productos.id_productos = prod_tragos.id_productosFK");
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $listaProdTragos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

    //Trae los Productos , para seleccionar.
    $consulta = $conexion -> prepare("SELECT * from productos group by nombre");
    $consulta -> execute();
    $listaProductos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
?>
<section class="container">
        <div class="row d-flex flex-direction-column justify-content-center align-content-center mb-4">
            <div class="m-5 div_titulo">
                <h1>Modificar trago</h1>
            </div>
        </div>
        <!-- Puse el form aca porque sino me desarmaba los estilos o no me tomaba los inputs creados con JavasCript -->
        <form action="modificadoTragos.php" name="form" method="POST" enctype="multipart/form-data">
        <div class="row shadow-lg p-3 mb-5 bg-body rounded text-center">
            <!-- card header -->
            <div class="card-header bg-primary text-white font fs-5">
                Datos del trago
            </div>
            <!-- Article formulario con mas datos -->
            <article class="col-md-6">
                <div>
                    <!-- body card -->
                    <div class="card-body">
                        <!-- Formulario -->
                        <?php
                        foreach ($listaTragos as $tragos) {
                        ?>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre: </label>
                            <input type="hidden" name="id" value="<?php echo $tragos['id_tragos'] ?>">
                            <input type="text" class="form-control" value="<?php echo $tragos["nombre"] ?>" name="nombre" id="nombre" aria-describedby="Nombre" placeholder="Nombre producto">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion: </label>
                            <input type="text" class="form-control" value="<?php echo $tragos["descripcion"] ?>" name="descripcion" id="descripcion" aria-describedby="descripcion" placeholder="descripcion">
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio: </label>
                            <input type="number" class="form-control" value="<?php echo $tragos["precio"] ?>" name="precio" id="precio" aria-describedby="precio" placeholder="Precio">
                        </div> 
                        <div class="mb-3">
                            <label for="favorito" class="form-label">Favorito: </label>
                                <select class="form-select text-center" name="favorito" id="favorito">
                                    <option value="<?php echo $tragos['favoritos'] ?>"><?php echo $tragos["favoritos"] ?></option>
                                    <?php
                                        if ($tragos["favoritos"] == "si") {
                                            echo "<option value='no'>no</option>";
                                        }else {
                                            echo "<option value='si'>si</option>";                                            
                                        }
                                    ?>
                                </select>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen: </label> <br>
                            <?php if ($tragos["imagen"] != "") { ?>
                                    <img src="../imagenesTragos/<?php echo $tragos["imagen"] ;?>" id="img" width="200px" alt="imagen">  <br> <br>                       
                            <?php } ?>  
                            <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Ingresar imagen">
                        </div>
                        <div class="alert alert-danger mt-2" class="text-center" id="error_validacion" style="display:none"></div> 
    
                    </div>
                </article>
                <!-- article Productos y medidas -->
                <article class="col-md-6 p-3">
                <?php
                    foreach ($listaProdTragos as $prodTragos) { 
                ?>
                    <div class="row"  id="div_padre_tragos_medidas">
                        <div class="row"> 
                            <div class="col-5 contador_divs">
                                <label for="producto" class="form-label">Bebida: </label>
                                <select class="form-select text-center" name="producto[]" id="producto">
                                    <option value="<?php echo $prodTragos["id_productosFK"]?>"><?php echo $prodTragos["nombre"] ?></option>
                                    <?php  foreach ($listaProductos as $productos) { ?>
                                        <option value="<?php echo $productos["id_productos"]?>"><?php echo $productos["nombre"] ?></option>
                                    <?php  } ;?>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="medida" class="form-label">Medida o onzas: </label>
                                    <input type="text" value="<?php echo $prodTragos['cantidad_medida'] ?>" class="form-control medida" name="medida[]" id="medida" placeholder="Ingresar medida">
                                </div>
                            </div>
                        </div>
                        <?php } ;?>
                        <!-- Botones agregar producto y medida -->
                        <div class="row">
                            <div class="m-3 d-flex justify-content-center">
                                <button type="button" name="btnAgregar" id="btnAgregar" value="Agregar" class="btn btn-primary m-1">Agregar producto</button>
                                <button type="button" name="btnEliminar" id="btnEliminar" value="Eliminar" class="btn btn-danger w-25 m-1" >Eliminar</button>
                            </div>
                        </div>
                </article>
                <?php } ?>
                <!-- Botones por fuera de los dos article -->
                <div class="row">
                    <!-- div oculto -->
                  <div class="alert alert-danger mt-2 w-50 mx-auto" class="text-center" id="error_div" style="display:none"></div> 
                    <div class="d-flex justify-content-center w-100">
                        <button type="button" name="botonAccion" id="btnAltaProductos" value="insertar" class="btn btn-primary w-25">Modificar trago</button>
                        <a href="tragos.php" class="w-25"><button type="button" name="botonAccion" value="insertar" class="btn btn-danger w-100" >Cancelar</button></a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        const btnAgregar = document.querySelector("#btnAgregar");
        const btnEliminar = document.querySelector("#btnEliminar");
        const div_padre = document.querySelector("#div_padre_tragos_medidas");
        const btnAlta =  document.querySelector("#btnAltaProductos");
        const div_oculto = document.querySelector("#error_div");

        btnAgregar.addEventListener("click",() =>{
            let numDiv = document.querySelectorAll (".contador_divs");
            let div_contador = numDiv.length;
            if (div_contador < 5) {
                
                const div_creado = document.createElement("div");
                div_creado.classList.add("row");
                div_creado.innerHTML = `<div class="col-5 contador_divs">
                                <label for="producto" class="form-label">Bebida: </label>
                                <select class="form-select text-center" name="producto[]" id="producto">
                                    <?php  foreach ($listaProductos as $productos) { ?>
                                        <option value="<?php echo $productos["id_productos"]?>"><?php echo $productos["nombre"] ?></option>
                                    <?php  } ;?>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="medida" class="form-label">Medida o onzas: </label>
                                    <input type="text" value="" class="form-control medida" name="medida[]" id="medida" placeholder="Ingresar medida">
                                </div>
                            </div>
                        </div>`
                    
                    div_padre.appendChild(div_creado);
            }else{
                btnAgregar.style.disabled = "true"
            }
            
        })

        btnEliminar.addEventListener("click",() =>{
            let numDiv = document.querySelectorAll (".contador_divs");
            let div_contador = numDiv.length;
            if (div_contador < 2) {
                btnEliminar.style.disabled = "true"
            }else{
                btnEliminar.style.disabled = "false"
                div_padre.removeChild(div_padre.lastChild);
            }
        })

        btnAlta.addEventListener("click",() =>{
            const nombre = document.querySelector("#nombre").value;
            const descripcion = document.querySelector("#descripcion").value;
            const precio = document.querySelector("#precio").value;
            const medida = document.getElementsByClassName("medida");
            let bandera = false;

            for (let i = 0; i < medida.length; i++) { 
                if (medida[i].value == "") {
                    bandera = true;
            }
        }
        
            if (nombre == "") {
                div_oculto.style.display = "block";
                div_oculto.textContent = "Nombre obligatorio"
                setTimeout(() => {
                    div_oculto.style.display = 'none';
                }, 3000); 
            }else if(descripcion == ""){
                div_oculto.style.display = "block";
                div_oculto.textContent = "Descripcion obligatorio"
                setTimeout(() => {
                    div_oculto.style.display = 'none';
                }, 3000);
            }else if( precio < 0 || isNaN(precio) || precio == "" ){
                div_oculto.style.display = "block";
                div_oculto.textContent = "Precio mal ingresado"
                setTimeout(() => {
                    div_oculto.style.display = 'none';
                }, 3000);
            }else if(bandera){
                div_oculto.style.display = "block";
                div_oculto.textContent = "Medida campos obligatorios"
                setTimeout(() => {
                    div_oculto.style.display = 'none';
                }, 3000);      
            }else{
                document.form.submit();     
            }
        })
    
    </script>