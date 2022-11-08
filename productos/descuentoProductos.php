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

    //Medida
    $consulta = $conexion -> prepare("SELECT id_motivo,motivo from motivo");
    $consulta -> execute();
    $listaMotivos = $consulta -> fetchAll(PDO::FETCH_ASSOC);


    //Para poner limite en input de  la fecha y poner por default en la fecha de hoy
    $fechaActual = date('Y-m-d');
    
?>
    <section class="container">
        <div class="row d-flex flex-direction-column justify-content-center align-content-center mb-4">
            <div class="m-5 div_titulo">
                <h1>Descontar stock</h1>
            </div>
            <div class="col-md-5">
                <div class="card shadow-lg p-3 mb-5 bg-body rounded text-center">
                    <!-- cabecera card -->
                    <div class="card-header">
                        Datos
                    </div>
                    <!-- body card -->
                    <div class="card-body">
                        <!-- Formulario -->
                    <form action="" name="form" id="form" method="POST">
                        <?php
                            foreach ($listaProductos as $productos) {
                        ?>
                        <div class="mb-3">
                            <input type="hidden"  class="form-control"  name="id" id="id" value="<?php echo $productos['id_productos']?>">
                            <label for="nombre" class="form-label">Nombre: </label>
                            <input type="text" disabled class="form-control"  name="nombre" id="nombre" value="<?php echo $productos['nombre']?>">
                                <?php
                                    }
                                ?>
                        </div>
                        <div class="mb-3">
                            <label for="medida" class="form-label">Medida: </label>
                            <input type="text" disabled class="form-control"  name="medida" id="medida" value="<?php echo $medidas['medida']?>">
                        </div>
                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad: </label>
                            <input type="number" min="0"  class="form-control" name="cantidad" id="cantidad" placeholder="Ingresar cantidad">
                            
                        </div>
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha: </label>
                            <input type="date" required class="form-control" name="fecha" max="<?php echo $fechaActual ?>" value="<?php echo $fechaActual ?>" id="fecha">
                        </div>
                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo: </label>
                            <select class="form-select" name="motivo" id="motivo" aria-label="Default select example">
                                <?php 
                                    foreach ($listaMotivos as $motivos) {
                                ?>
                                <option value="<?php echo $motivos['id_motivo'] ?>"> <?php echo $motivos["motivo"] ?></option>
                                <?php } ?> 
                            </select>
                        </div>
                        <div>
                        <p id="respuesta"></p>
                            <button type="submit" name="botonAccion" value="insertar" class="btn btn-primary" >Descontar stock</button>
                            <a href="productos.php"><button type="button" name="botonAccion" value="insertar" class="btn btn-danger" >Cancelar</button></a>
                        </div>
                </form>
                </div>
                
            </div>
        </div>
            
        </div>
    </section>

<script>
    // Desabilita el campo nombre del producto al cargar el documento
    document.addEventListener("DOMContentLoaded",() =>{
        const nombre = document.querySelector("#nombre");
        const medida = document.querySelector("#medida");
        nombre.disabled = true
        medida.disabled = true
    })

    const form = document.querySelector("#form");
    const div_respuesta = document.querySelector("#respuesta");
    form.addEventListener("submit",(e) =>{
        e.preventDefault()
        const cantidad = document.querySelector("#cantidad").value;
        const motivo = document.querySelector("#motivo").value;
        const data = new FormData(form);
        if (cantidad == "" || isNaN(cantidad) ) {
                div_respuesta.innerHTML =  `<div class="alert alert-success mt-2">Cantidad mal ingresada</div>`
                div_respuesta.style.display = "block"
                setTimeout(() => {
                    div_respuesta.style.display = "none"
                }, 2000);
        }else if(motivo == ""){
                div_respuesta.innerHTML =  `<div class="alert alert-success mt-2">Debe ingresar un motivo</div>`
                div_respuesta.style.display = "block"
                setTimeout(() => {
                    div_respuesta.style.display = "none"
                }, 2000);
        }else{
            fetch("descontadoProductos.php",{
                method:"POST",
                body:data
            }).then(res => res.json())
            .then(data => {
                if (data == 'Descuento de stock registado') {
                    div_respuesta.innerHTML = "";
                    div_respuesta.innerHTML =  `<div class="alert alert-success mt-2">Desuento de stock registrado</div>`
                    div_respuesta.style.display = "block"
                    setTimeout(() => {
                        window.location.href= "productos.php";
                    }, 2000);
                }else{
                    div_respuesta.innerHTML = "";
                    div_respuesta.classList.add("alert", "alert-danger", "my-3")
                    div_respuesta.textContent = ` Stock insfucieinte: ${data}`
                    div_respuesta.style.display = "block"
                    setTimeout(() => {
                        div_respuesta.style.display = "none";
                    }, 3000);
                }
            })
        }

    })
    
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>