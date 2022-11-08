<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");
?>
    <section class="container">
            <div class="row  d-flex flex-direction-column justify-content-center align-content-center">
                <div class="m-5 div_titulo">
                    <h1>Crear proveedor</h1>
                </div>
                <div class="col-md-5">
                    
                    <div class="card shadow-lg p-3 mb-5 bg-body rounded text-center">
                        <!-- cabecera card -->
                        <div class="card-header bg-primary text-white fs-5">
                            Datos del Proveedor
                        </div>
                        <!-- body card -->
                        <div class="card-body">
                            <!-- Formulario -->
                    <form action="altaProveedores.php" name="form" method="POST" >
                        <div class="mb-3">
                            <?php
                             $mensaje = (isset($_GET["msg"])) ? $_GET["msg"] : "" ;
                                if ($mensaje) {
                                    echo "<div class='alert alert-danger text-danger alert-dismissible  d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                                          $mensaje  
                                        <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                                        </div>";
                                }
                            ?>
                            <label for="nombre" class="form-label">Nombre: </label>
                            <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="Nombre" placeholder="Nombre proveedor">
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Telefono: </label>
                            <input type="number" min="0" class="form-control" name="telefono" id="telefono" placeholder="Teléfono proveedor">
                        </div>
                        <div class="mb-3">
                            <label for="cuit" class="form-label">Cuit: </label> <br>
                            <div class="bg  border border-danger w-50 mb-2  m-auto">
                                <small class="text-danger ">Ingresar con guión</small>
                            </div>
                            <input type="text" class="form-control" name="cuit" id="cuit" placeholder="Cuit proveedor">
                        </div>
                        <div class="alert alert-danger mt-2" class="text-center" id="error_validacion" style="display:none"></div> 
                        <div>
                            <button type="button" name="botonAccion" value="insertar" id="btnaltaProveedor" class="btn btn-primary">Crear proveedor</button>
                            <a href="proveedores.php"><button type="button" name="botonAccion" value="insertar" class="btn btn-danger" >Cancelar</button></a>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
            
        </div>
    </section>
    <script>
        const btnProveedores = document.querySelector("#btnaltaProveedor");
        btnProveedores.addEventListener("click", () =>{
            const nombre = document.querySelector("#nombre").value;
            const telefono = document.querySelector("#telefono").value;
            const div_error = document.querySelector("#error_validacion");
            // e.preventDefault();
            if (nombre == "") {
                div_error.style.display = "block";
                div_error.textContent = "Nombre campo obligatorio";
                setTimeout(() => {
                    div_error.style.display = 'none';
                }, 3000); 
            }else if(isNaN(telefono) || telefono == ""){
                div_error.style.display = "block";
                div_error.textContent = "Telefono mal ingresado";
                setTimeout(() => {
                    div_error.style.display = 'none';
                }, 3000); 
            }else{
                document.form.submit();
            }
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>