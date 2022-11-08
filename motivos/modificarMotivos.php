<?php
    session_start();
    include("../config/db.php");
    if (isset($_GET["upd"])) $id = $_GET["upd"];  //Si se envia algo se guarda en la variable id
    $consulta = $conexion -> prepare("SELECT * from motivo where id_motivo = :id");
    $consulta -> bindParam("id",$id);
    $consulta -> execute();
    $datos = $consulta -> fetch(PDO::FETCH_LAZY);

    include("../template/cabecera.php");
?>
   
        <section class="container">
            <div class="row  d-flex flex-direction-column justify-content-center align-content-center">
                <div class="div_titulo mb-5">
                    <h1>Modificar Motivo</h1>
                </div>
                <div class="col-md-5 text-center shadow-lg p-3 mb-5 bg-body rounded">
                    
                    <div class="card">
                        <!-- cabecera card -->
                        <div class="card-header bg-primary bg-primary text-white fs-5 ">
                            Datos del motivo
                        </div>
                        <!-- body card -->
                        <div class="card-body">
                            <!-- Formulario -->
                            <form action="modificadoMotivos.php" name="form"  method="POST" >
                                <!-- id oculto -->
                                <input type="hidden"  name="id" id="id" value="<?php echo $datos["id_motivo"]; ?>" class="form-control" aria-describedby="helpId">
                                <div class="form-group">
                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="motivo" class="form-label">Motivo:</label>
                                <input type="text" required name="motivo" id="motivo" value="<?php echo $datos["motivo"]; ?>" class="form-control" aria-describedby="helpId">
                            </div>
                            <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <input type="text" class="form-control" value="<?php echo $datos["tipo"] ?>" name="tipo" id="tipo" aria-describedby="tipo" placeholder="Ingresar tipo">
                        </div>
                        <!-- Div oculto -->
                        <div class="alert alert-danger mt-2" class="text-center" id="error_val_motivos_mod" style="display:none"></div>
                        <!-- botones -->
                        <div class="d-flex justify-content-center" role="group" aria-label="">
                            <button type="button" name="accion" value="modificar" id="btn-medidas-modificar" class="btn btn-success m-2">Modificar</button>
                            <a href="motivos.php"><button type="button" name="accion" value="cancelar" class="btn btn-danger m-2">Cancelar</button></a> 
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
        const btnModificarMedidas = document.querySelector("#btn-medidas-modificar");
        btnModificarMedidas.addEventListener("click", () =>{
            const motivo = document.querySelector("#motivo").value;
            const tipo = document.querySelector("#tipo").value;
            const div_error = document.querySelector("#error_val_motivos_mod");
            // e.preventDefault();
            if (motivo == "") {
                div_error.style.display = "block";
                div_error.textContent = "Nombre campo obligatorio";
                setTimeout(() => {
                    div_error.style.display = 'none';
                }, 3000); 
            }else if(tipo == "" || (tipo != "negativo" && tipo != "positivo")){
                div_error.style.display = "block";
                div_error.textContent = "tipo debe ser positivo o negativo";
                setTimeout(() => {
                    div_error.style.display = 'none';
                }, 3000); 
            }else{
                document.form.submit();
            }
        })
    </script>
</html>