<?php
        session_start();
        include("../config/db.php");
        $txtID = (isset($_POST["txtID"])) ? $_POST["txtID"] : "" ;   //El id lo tengo para usarlo en las modificaciones, cuando presiono el boton seleccionar
         
        //MOSTRAR LISTA DE PROVEEDORES
        $estado = 1;
        $consultaMostrar = $conexion -> prepare("SELECT * from proveedores where estado = :estado order by nombre asc");
        $consultaMostrar -> bindParam("estado",$estado);
        $consultaMostrar -> execute();
        $listaProveedores = $consultaMostrar -> fetchAll(PDO::FETCH_ASSOC);
        
         include("../template/cabecera.php");
?>

    <!-- Cierre navbar -->

    <section class="container-fluid">
        <div class="div_titulo my-3">
            <h1>Proveedores</h1>
        </div>
        <div class="d-flex justify-content-center">
           <a href="darDeAlta.php"><button class="btn btn-primary">Agregar Proveedor</button></a>
        </div>
       
        <!-- ROW TABLA -->
        <div class="row tabla">
            <div class="col">
                <table class="table table-responsive table-bordered table-striped my-3 text-center  mx-auto" style="width:60%"  id="tablaProveedores">  <!--Tiene margen-->
                <!-- div mensaje de confirmacion de update -->
                <div class="container d-flex justify-content-center mt-3">  
                    <?php
                    $nombreModificado = (isset($_GET["upd"])) ? $_GET["upd"] : "" ;
                    
                    if ($nombreModificado) {
                        
                        echo "<div class='alert alert-success alert-dismissible w-50  d-flex justify-content-center' rol='alert' id='mensajeConfirmacion' alert-dismissible fade show >
                        Proveedor $nombreModificado modificado correctamente 
                        <button type='button' class='btn-close d-flex flex-direction-column justify-content-end' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";

                    }
                    ?>
                </div>
                <!-- Cierre div mensaje de confirmacion -->
                    <thead >
                    <tr>
                        <th class="col-3">Nombre</th>
                        <th class="col-3">Teléfono</th>
                        <th class="col-3">Cuit</th>
                        <th class="col-3">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- FOREACH -->
                    <?php  
                    foreach ($listaProveedores as $proveedor) {
                    ?>
                    <tr >
                        <td class="col-3"><?php echo $proveedor["nombre"] ?></td>
                        <td class="col-3"> <?php echo $proveedor["telefono"] ?> </td>
                        <td class="col-3"> <?php echo $proveedor["cuit"] ?> </td>
                        <td class="col-3"> 
                               
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $proveedor['id_proveedores'];?>">

                            <a href="modificar.php?upd=<?php echo $proveedor["id_proveedores"] ?>">
                                <button class="btn btn-primary">
                                    Editar
                                </button>
                            </a>
                                <!-- Boton que ejecute funcion js  para eliminar -->
                            <a href="eliminarProveedor.php?usr=<?php echo $proveedor['id_proveedores'] ?>"">
                                <button type="button" class="btn btn-danger" onclick="return eliminar()">
                                    Eliminar
                                </button>
                            </a>
                        </td>
                    </tr>

                    <?php }; ?>  <!-- Cierre PHP -->
                
                </tbody>
            </table>
        </div>
        
    </section>
    <script type="text/javascript">
        function eliminar(){
            const respuesta = confirm("Estás seguro que deseas eliminarlo?");
            if (respuesta == true) {
                return true
            }else{
                return false;
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>