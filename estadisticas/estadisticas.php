<?php
    session_start();
    include("../config/db.php"); 
    include("../template/cabecera.php");

    $fechaActual = date('Y-m-d');
?>
<section class="container">
    <div class="d-flex justify-content-center div_titulo">
        <h1>Calcular estadísticas productos</h1>
    </div>
    <div class="row d-flex flex-direction-column justify-content-center align-content-center mt-5">
        <div class="col-5 ">
            <!-- div oculto -->
        <div class="alert alert-danger mt-2" class="text-center" id="error_fecha" style="display:none"></div> 
            <!-- card -->
            <div class="card text-center">
                <!-- card header -->
                <div class="card-header bg-dark text-white">
                    Datos fechas
                </div>
                <!-- card body -->
                <div class="card-body">
                    <div class="form-group mb-3">
                        <form action="calcularProductos.php" name="form" id="form_dias" method="post">
                            <div class="form-group mb-3">
                                <label for="fecha_desde" class="form-label">Fecha desde:</label>
                                <input type="date" required name="fecha_desde" id="fecha_desde"  max="<?php echo $fechaActual ?>"  class="form-control" aria-describedby="helpId">
                            </div>
                            <div class="form-group mb-3">
                                <label for="fecha_hasta" class="form-label">Fecha hasta:</label>
                                <input type="date" required name="fecha_hasta" id="fecha_hasta"  max="<?php echo $fechaActual ?>" class="form-control" aria-describedby="helpId">
                            </div>
                            <div class="d-flex justify-content-center" role="group" aria-label="">
                                <button type="submit" name="accion" id="btn" value="" class="btn btn-success m-2">Calcular</button>
                                <a href="../inicio/inicio.php"><button type="button" name="accion" value="cancelar"  class="btn btn-danger m-2">Cancelar</button> </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php include("../template/footer.php") ?>

<script>
let fechaConHora = new Date();
let dia = fechaConHora.getDate();
dia = dia < 10 ? `0${dia}` : dia
const selectFechas = document.querySelector("#fechas");
const form_dias = document.querySelector("#form_dias");

    form_dias.onsubmit = (e) => {
        e.preventDefault();
        const fecha_desde = document.querySelector("#fecha_desde").value
        const fecha_hasta = document.querySelector("#fecha_hasta").value

        if (fecha_desde > fecha_hasta) {
            swal("fechas mal ingresadas", "fecha desde debe ser menor", "warning");
        }else{
            document.form.submit();
        }
    }
</script>