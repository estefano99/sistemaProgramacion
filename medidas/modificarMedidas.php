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
            <div class="row  d-flex flex-direction-column justify-content-center align-content-center ">

                <div class="div_titulo mb-5">
                    <h1>Modificar Medida</h1>
                </div>
                <div class="col-md-5 shadow-lg p-3 mb-5 bg-body rounded text-center">
                    
                    <div class="card">
                        <!-- cabecera card -->
                        <div class="card-header">
                            Datos medida
                        </div>
                        <!-- body card -->
                        <div class="card-body">
                            <!-- Formulario -->
                            <form action="modificadoMedidas.php" name="form"  method="POST" >
                                <!-- id oculto -->
                                <input type="hidden" name="id" id="id" value="<?php echo $datos["id_medida"]; ?>" class="form-control" aria-describedby="helpId">
                                <div class="form-group">
                            <!-- Nombre -->
                            <div class="form-group">
                                <label for="medida" class="form-label">Medida:</label>
                                <input type="text" required name="medida" id="medida" value="<?php echo $datos["medida"]; ?>" class="form-control" aria-describedby="helpId">
                            </div>
                            <div class="border border-danger w-75 my-4 mx-auto text-center">
                                <small class="text-danger ">Formas de ingresar: 1,5 lt - 2 lt - 250 mlt 2,250 lt</small>
                        </div>
                        </div>
                         <!-- Div oculto -->
                         <div class="alert alert-danger mt-2" class="text-center" id="error_val_medidas_mod" style="display:none"></div>
                        <!-- botones -->
                        <div class="d-flex justify-content-center" role="group" aria-label="">
                            <button type="button" name="accion" value="modificar" id="btn-medidas-modificar" class="btn btn-success m-2">Modificar</button>
                            <a href="medidas.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button></a>
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
        const btnM = document.querySelector("#btn-medidas-modificar");
        const div_error = document.querySelector("#error_val_medidas_mod");
        btnM.addEventListener("click", () =>{
            const medida = document.querySelector("#medida").value;

            if (!medida == "") { //Si no es vacio medida
                    
                if (medida.length == 4) { //1 lt
                    
                    if(isNaN(medida[0])){
                        div_error.style.display = "block";
                        div_error.textContent = "El primer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);

                    }else if(medida[1] != " "){
                        div_error.style.display = "block";
                        div_error.textContent = "El segundo caracter debe ser un espacio";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(!isNaN(medida[2]) || !isNaN(medida[3])){
                        div_error.style.display = "block";
                        div_error.textContent = "Los dos últimos caracteres deben ser letras";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else{
                        document.form.submit();
                    }
                
            }else if(medida.length == 6){ //1,5 lt

                if(isNaN(medida[0])){
                        div_error.style.display = "block";
                        div_error.textContent = "El primer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);

                    }else if(medida[1] != ","){
                        div_error.style.display = "block";
                        div_error.textContent = "El segundo caracter debe ser una coma";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(isNaN(medida[2])){
                        div_error.style.display = "block";
                        div_error.textContent = "El tercer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(medida[3] != " "){
                        div_error.style.display = "block";
                        div_error.textContent = "El cuarto caracter debe ser un espacio";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(!isNaN(medida[4]) || !isNaN(medida[5])){
                        div_error.style.display = "block";
                        div_error.textContent = "Los dos últimos caracteres deben ser letras";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else{
                        document.form.submit();
                    }
            } else if(medida.length == 7){ //250 mlt

                if(isNaN(medida[0])){
                        div_error.style.display = "block";
                        div_error.textContent = "El primer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);

                    }else if(isNaN(medida[1])){
                        div_error.style.display = "block";
                        div_error.textContent = "El segundo caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(isNaN(medida[2])){
                        div_error.style.display = "block";
                        div_error.textContent = "El tercer caracter debe ser numérico";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(medida[3] != " "){
                        div_error.style.display = "block";
                        div_error.textContent = "El cuarto caracter debe ser un espacio";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else if(!isNaN(medida[4]) || !isNaN(medida[5]) || !isNaN(medida[6])){
                        div_error.style.display = "block";
                        div_error.textContent = "Los tres últimos caracteres deben ser letras";
                        setTimeout(() => {
                            div_error.style.display = 'none';
                        }, 3000);
                    }else{
                        document.form.submit();
                    }
            }else{ //Si el length de medida esta mal
                div_error.style.display = "block";
                div_error.textContent = "Datos incorrectos";
                setTimeout(() => {
                    div_error.style.display = 'none';
                }, 3000);
            }
        }else{ //Vacio medida
            div_error.style.display = "block";
            div_error.textContent = "Nombre campo obligatorio";
            setTimeout(() => {
                div_error.style.display = 'none';
            }, 3000);
            }
        })
    </script>
</html>