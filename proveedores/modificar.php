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

                <div class="col-md-5">
                    <h1>Modificar Proveedor</h1>
                    
                    <div class="card">
                        <!-- cabecera card -->
                        <div class="card-header">
                            Datos del Proveedor
                        </div>
                        <!-- body card -->
                        <div class="card-body">
                            <!-- Formulario -->
                            <form action="modificadoProveedor.php"  method="POST" >
                                <!-- id oculto -->
                                <input type="hidden"  name="id" id="id" value="<?php echo $datos["id_proveedores"]; ?>" class="form-control" aria-describedby="helpId">
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
                        <!-- botones -->
                        <div class="d-flex justify-content-center" role="group" aria-label="">
                            <button type="submit" name="accion" value="modificar" class="btn btn-success m-2">Modificar</button>
                            <button type="" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button> 
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
            
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>