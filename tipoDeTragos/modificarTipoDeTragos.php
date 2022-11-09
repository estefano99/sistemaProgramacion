<?php
    session_start();
    include("../config/db.php");
    if (isset($_GET["upd"])) $id = $_GET["upd"];  //Si se envia algo se guarda en la variable id
    $consulta = $conexion -> prepare("SELECT * from tipodetragos where id_tipodetragos = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $datos = $consulta ->  fetch(PDO::FETCH_LAZY);

    include("../template/cabecera.php");
?>
   
        <section class="container">
            <div class="row d-flex flex-direction-column justify-content-center align-content-center">

                <div class="div_titulo mb-5 ">
                    <h1>Modificar tipo de trago</h1>
                </div>
                <div class="col-md-5 shadow-lg p-3 mb-5 bg-body rounded text-center">
                    
                    <div class="card">
                        <!-- cabecera card -->
                        <div class="card-header">
                            Datos del tipo de trago
                        </div>
                        <!-- body card -->
                        <div class="card-body">
                            <!-- Formulario -->
                            <form action="modificadoTipoDeTragos.php" name="form"  method="POST" >
                                <!-- id oculto -->
                                <input type="hidden"  name="id" id="id" value="<?php echo $datos["id_tipodetragos"]; ?>" class="form-control" aria-describedby="helpId">
                                <div class="form-group">
                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" required name="nombre" id="nombre" value="<?php echo $datos["nombre"]; ?>" class="form-control" aria-describedby="helpId">
                            </div>
                            <!-- imagen -->
                            <br>
                             <!-- Div oculto -->
                         <div class="alert alert-danger mt-2" class="text-center" id="error_val_tipo_mod" style="display:none"></div>
                        </div>
                        <!-- botones -->
                        <div class="d-flex justify-content-center" role="group" aria-label="">
                            <button type="button" name="accion" value="modificar" id="btn-mod-tipo" class="btn btn-success m-2">Modificar</button>
                            <a href="tipoDeTragos.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button></a>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
            
        </div>
    </section>
    <script>
        const btnModTipo = document.querySelector("#btn-mod-tipo");
        const div_oculto = document.querySelector("#error_val_tipo_mod");
        btnModTipo.addEventListener("click", () =>{
            const nombre = document.querySelector("#nombre").value;
            if (nombre == "") {
                div_oculto.style.display = "block";
                div_oculto.textContent = "Nombre campo obligatorio"
                setTimeout(() => {
                    div_oculto.style.display = "none";
                }, 3000);
            }else{
                document.form.submit();
            }
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
    </html>