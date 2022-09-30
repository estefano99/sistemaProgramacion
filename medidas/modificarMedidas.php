<?php
    session_start();
    include("../config/db.php");
    if (isset($_GET["upd"])) $id = $_GET["upd"];  //Si se envia algo se guarda en la variable id
    $consulta = $conexion -> prepare("SELECT * from medida where id_medida = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $datos = $consulta ->  fetch(PDO::FETCH_LAZY);

    include("../template/cabecera.php");
?>
   
        <section class="container">
            <div class="row  d-flex flex-direction-column justify-content-center align-content-center">

                <div class="col-md-5">
                    <h1>Modificar Medida</h1>
                    
                    <div class="card">
                        <!-- cabecera card -->
                        <div class="card-header">
                            Datos medida
                        </div>
                        <!-- body card -->
                        <div class="card-body">
                            <!-- Formulario -->
                            <form action="modificadoMedidas.php"  method="POST" >
                                <!-- id oculto -->
                                <input type="hidden" name="id" id="id" value="<?php echo $datos["id_medida"]; ?>" class="form-control" aria-describedby="helpId">
                                <div class="form-group">
                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="medida" class="form-label">Medida:</label>
                                <input type="text" required name="medida" id="medida" value="<?php echo $datos["medida"]; ?>" class="form-control" aria-describedby="helpId">
                            </div>
                            <!-- imagen -->
                            <br>
                            <div class="mensajeConfirmacion"></div>
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