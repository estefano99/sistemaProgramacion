<?php
    session_start();
    include("../config/db.php");
    include("../template/cabecera.php");

    $estado = 1;
    $consulta = $conexion -> prepare("SELECT * from tipodetragos where estado = :estado");
    $consulta -> bindParam("estado",$estado);
    $consulta -> execute();
    $listaTtipo = $consulta -> fetchAll(PDO::FETCH_ASSOC);
?>
<section class="container-fluid">
    <article class="row">
        <!-- Div izquierdo que contiene la lista de tragos seleccionados -->
        <div class="col-4 div-col-ventas">
            <div class="row">
                <div class="col-12">
                    <table class="table table-responsive table-striped">
                        <tbody>
                            <tr>
                                <td class="col-10">hola </td>
                                <td class="col-2"><button>+</button> </td>
                                <td class="col-2"><button>-</button> </td>
                            </tr>
                            <tr>
                                <td>hola </td>
                            </tr>
                            <tr>
                                <td>hola </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Esta dentro del row -->
                <div class="">
                    <button> Confirmar venta</button>
                    <button> Eliminar Trago</button>
                </div>
            </div>
        </div>

<!-- Div a la derecha que contiene el grupo de tragos -->
        <div class="col-8 div-col-ventas2">
            <div class="row">
                <?php
                    foreach ($listaTtipo as $tipo) {
                ?>
                <div class="col-4 div-grupo-tragos">
                    <p class="p-grupo-tragos" id="<?php echo $tipo["id_tipodetragos"] ?>"><?php echo $tipo["nombre"] ?></p>
                </div>
                <?php } ?>
            </div>
        </div>
    </article>
</section>

<?php include("../template/footer.php") ?>