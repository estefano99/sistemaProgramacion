<?php
     session_start();
     include("../config/db.php");
     include("../template/cabecera.php");

     $estado = 1;
     $consulta = $conexion -> prepare("SELECT nombre,id_productos from productos where estado = :estado group by nombre order by nombre asc");
     $consulta -> bindParam("estado",$estado);
     $consulta -> execute();
     $listaProductos = $consulta -> fetchAll(PDO::FETCH_ASSOC);

     $consulta = $conexion -> prepare("SELECT * from tipodetragos where estado = :estado order by nombre asc");
     $consulta -> bindParam("estado",$estado);
     $consulta -> execute();
     $listaTipo = $consulta -> fetchAll(PDO::FETCH_ASSOC);
?>
<section class="container">
        <div class="row d-flex flex-direction-column justify-content-center align-content-center mb-4">
            <div class="m-5 div_titulo">
                <h1>Crear trago</h1>
            </div>
        </div>
        <!-- Puse el form aca porque sino me desarmaba los estilos o no me tomaba los inputs creados con JavasCript -->
        <form action="altaTragos.php" name="form" method="POST" enctype="multipart/form-data">
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
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre: </label>
                            <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="Nombre" placeholder="Nombre del trago">
                        </div>
                        <div class="mb-3">
                            <label for="favorito" class="form-label">Tipo de trago: </label>
                                <select class="form-select text-center" name="tipodetrago" id="tipodetrago">
                                    <?php
                                        foreach ($listaTipo as $tipo) {                                         
                                    ?>
                                    <option value="<?php echo $tipo['id_tipodetragos'] ?>"><?php echo $tipo['nombre'] ?></option>
                                    <?php } ;?>
                                </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion: </label>
                            <input type="text" class="form-control" name="descripcion" id="descripcion" aria-describedby="descripcion" placeholder="Descripción">
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio: </label>
                            <input type="number" class="form-control" name="precio" id="precio" aria-describedby="precio" placeholder="Precio">
                        </div> 
                        <div class="mb-3">
                            <label for="favorito" class="form-label">Favorito: </label>
                                <select class="form-select text-center" name="favorito" id="favorito">
                                    <option value="no">no</option>
                                    <option value="si">si</option>
                                </select>
                        </div>
                        <div class="mb-3">
                            <label for="bebida" class="form-label">Imagen: </label>
                            <input type="file" class="form-control" name="imagen" id="imagen" placeholder="Ingresar imagen">
                        </div>
                        <div class="alert alert-danger mt-2" class="text-center" id="error_validacion" style="display:none"></div> 
                       
                    </div>
                </article>
                <!-- article Productos y medidas -->
                <article class="col-md-6 p-3">
                    <div class="row"  id="div_padre_tragos_medidas">
                        <div class="row"> 
                            <div class="col-5 contador_divs">
                                <label for="producto" class="form-label">Productos: </label>
                                <select class="form-select text-center" name="producto[]" id="producto">
                                    <?php  foreach ($listaProductos as $productos) { ?>
                                        <option value="<?php echo $productos["id_productos"]?>"><?php echo $productos["nombre"] ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="medida" class="form-label">Medida u onzas: </label>
                                    <input type="text" class="form-control medida" name="medida[]" id="medida" placeholder="Ingresar medida">
                                </div>
                        </div>
                    </div>
                    <!-- Botones agregar producto y medida -->
                    <div class="row">
                        <div class="m-3 d-flex justify-content-center">
                            <button type="button" name="btnAgregar" id="btnAgregar" value="Agregar" class="btn btn-primary m-1">Agregar producto</button>
                            <button type="button" name="btnEliminar" id="btnEliminar" value="Eliminar" class="btn btn-danger w-25 m-1" >Eliminar</button>
                        </div>
                    </div>
                </article>
                <!-- Botones por fuera de los dos article -->
                <div class="row">
                    <!-- div oculto -->
                  <div class="alert alert-danger mt-2 w-50 mx-auto text-center" id="error_div" style="display:none"></div> 
                    <div class="d-flex justify-content-center w-100">
                        <button type="button" name="botonAccion" id="btnAltaProductos" value="insertar" class="btn btn-primary w-25">Crear trago</button>
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
                <label for="producto" class="form-label">Productos: </label>
                <select class="form-select text-center" name='producto[]' id="producto">
                <?php  foreach ($listaProductos as $productos) { ?>
                    <option value="<?php echo $productos["id_productos"] ?>"><?php echo $productos["nombre"] ?></option>
                    <?php  } ?>
                    </select>
                    </div>
                    <div class="col-5 ">
                    <label for="medida" class="form-label">Medida u onzas: </label>
                    <input type="text" class="form-control medida" name="medida[]" id="medida" placeholder="Ingresar medida">
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
            const imagen = document.querySelector("#imagen").value;
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
            }else if(imagen == ""){
                div_oculto.style.display = "block";
                div_oculto.textContent = "Imagen obligatorio"
                setTimeout(() => {
                    div_oculto.style.display = 'none';
                }, 3000);
            }
            else if(bandera){
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>