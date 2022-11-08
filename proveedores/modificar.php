<?php
    session_start();
    include("../config/db.php");
    if (isset($_GET["upd"])) $id = $_GET["upd"];  //Si se envia algo se guarda en la variable id
    $consulta = $conexion -> prepare("SELECT * from proveedores where id_proveedores = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $datos = $consulta ->  fetch(PDO::FETCH_LAZY);

    include("../template/cabecera.php");
?>
   
        <section class="container">
            <div class="row  d-flex flex-direction-column justify-content-center align-content-center">
                <div class="div_titulo mb-5 ">
                    <h1>Modificar Proveedor</h1>
                </div>
                <div class="col-md-5 shadow-lg p-3 mb-5 bg-body rounded text-center">
                    
                    <div class="card">
                        <!-- cabecera card -->
                        <div class="card-header">
                            Datos del Proveedor
                        </div>
                        <!-- body card -->
                        <div class="card-body">
                            <!-- Formulario -->
                            <form action="modificadoProveedor.php" name="form"  method="POST" >
                                <!-- id oculto -->
                                <input type="hidden"  name="id" id="id" value="<?php echo $datos["id_proveedores"]; ?>" class="form-control" aria-describedby="helpId">
                                <input type="hidden"  name="cuit" id="cuit" value="<?php echo $datos["cuit"]; ?>" class="form-control" aria-describedby="helpId">
                                <div class="form-group">
                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" required name="nombre" id="nombre" value="<?php echo $datos["nombre"]; ?>" class="form-control" aria-describedby="helpId">
                            </div>
                            <!-- imagen -->
                            <div class="form-group">
                                <label for="telefono" class="form-label">Teléfono:</label> <br>                  
                                <input type="text" required name="telefono" id="telefono" value="<?php echo $datos["telefono"]; ?>" class="form-control" aria-describedby="helpId">
                            </div>
                            <br>
                        </div>
                        <div class="alert alert-danger mt-2" class="text-center" id="error_validacion" style="display:none"></div>
                        <!-- botones -->
                        <div class="d-flex justify-content-center" role="group" aria-label="">
                            <button type="button" name="accion" value="modificar" id="btn-modificar" class="btn btn-success m-2">Modificar</button>
                            <a href="proveedores.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button> </a>
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
        const btnModificar = document.querySelector("#btn-modificar");
        btnModificar.addEventListener("click", () =>{
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
</html>