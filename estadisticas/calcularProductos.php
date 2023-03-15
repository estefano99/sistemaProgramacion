<?php
    session_start();
    include("../config/db.php"); 
    include("../template/cabecera.php");

    $fecha_desde = (isset($_POST["fecha_desde"])) ? $_POST["fecha_desde"] : ""; 
    $fecha_hasta = (isset($_POST["fecha_hasta"])) ? $_POST["fecha_hasta"] : "";


    if ($fecha_desde && $fecha_hasta) {

        $cantidadTotal = 0;  //Ingresos mercaderia
        $cantidadTotal2 = 0; //Descuento mercaderia

        //! Trae el stock ingresado ---------------------------------------
        $consulta = $conexion -> prepare("SELECT nombre, sum(cantidad) as 'cantidad', medida from productos, prod_comp, compras,medida where id_medidaFK = id_medida and id_comprasFK = id_compras and id_productosFK = id_productos and fecha BETWEEN :fecha_desde and :fecha_hasta group by nombre, medida");
        
        $consulta -> bindParam("fecha_desde",$fecha_desde);
        $consulta -> bindParam("fecha_hasta",$fecha_hasta);
        $consulta -> execute();
        $listaCompras = $consulta -> fetchAll(PDO::FETCH_ASSOC);

        //Cuenta el total de ingresos
        for ($i=0; $i < count($listaCompras); $i++) { 
            $cantidadTotal += $listaCompras[$i]["cantidad"];
        }

        //! Trae el stock vendido ---------------------------------------
        $consulta = $conexion -> prepare("SELECT nombre, sum(cantidad) as 'cantidad', medida from productos, reduccion,medida where id_medidaFK = id_medida and id_productosFK = id_productos and fecha BETWEEN :fecha_desde and :fecha_hasta group by nombre, medida");
        
        $consulta -> bindParam("fecha_desde",$fecha_desde);
        $consulta -> bindParam("fecha_hasta",$fecha_hasta);
        $consulta -> execute();
        $listaDescuento = $consulta -> fetchAll(PDO::FETCH_ASSOC);

        //Cuenta el total de ingresos
        for ($i=0; $i < count($listaDescuento); $i++) { 
            $cantidadTotal2 += $listaDescuento[$i]["cantidad"];
        }
    }
?>

<!-- //! --------------------------- HTML -------------------------------- -->

    <section class="container-fluid ">
        <article class="article-grafico" id="article-contenedor-graficos">
            <div class="div-grafico">
                <canvas id="myChart" class="canvas-llamar"></canvas>
            </div>
            <div class=" div-grafico">
                <canvas id="myChart1" class="canvas-llamar"></canvas>
            </div>
        </article>
        <div class="my-3">
            <p><strong><u>Total stock ingresado </u>: <?php echo $cantidadTotal ?></strong></p>
            <p><strong><u>Total stock vendido </u>: <?php echo $cantidadTotal2 ?></strong></p>
            <a href="estadisticas.php"><button class="btn btn-dark mt-4">Regresar</button></a>
            <br>
            <button type="button" id="btnAgrandar" class="btn btn-dark mt-2">Agrandar cuadro</button>
            <button type="button" style="display:none" id="btnAchicar" class="btn btn-dark mt-2 mb-5" >Achicar cuadro</button>
        </div>
    </section>   

<?php include("../template/footer.php") ?>

<!-- //! GENERAR GRAFICOS ---------------------------------- -->

<script>
    //Graficos
const grafico1 = document.getElementById('myChart');
    const myChart = new Chart(grafico1, {
    type: 'bar',
    data: {
        labels: [

        <?php
            foreach ($listaCompras as $compras ) {
        ?>
                '<?php echo "$compras[nombre]" . " - " . $compras["medida"] ?>',
        <?php
            }
        ?>

        ],
        datasets: [{
            label: 'Ingresos',
            data: [
                <?php
            foreach ($listaCompras as $compras ) {
        ?>
                '<?php echo "$compras[cantidad]" ?>',
        <?php
            }
        ?>

            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
    plugins: {
            title: {
                display: true,
                text: 'Ingresos stock por productos y medidas'
            }
        }
    }
});

const grafico2 = document.getElementById('myChart1');
    const myChart2 = new Chart(grafico2, {
    type: 'bar',
    data: {
        labels: [

        <?php
           foreach ($listaDescuento as $productos ) {
        ?>
                '<?php echo "$productos[nombre]" . " - " . $productos["medida"] ?>',
        <?php
            }
        ?>

        ],
        datasets: [{
            label: 'Vendidos',
            data: [
        <?php
             foreach ($listaDescuento as $productos) {
        ?>
                '<?php echo "$productos[cantidad]" ?>',
        <?php
            }
        ?>

            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
    plugins: {
            title: {
                display: true,
                text: "Productos vendidos"
            }
        }
    }
});
</script>

<script>
    btnAgrandar = document.querySelector("#btnAgrandar");
    contenedor = document.querySelector("#article-contenedor-graficos");
    divGrafico = document.querySelectorAll(".div-grafico");
    canvas = document.querySelectorAll(".canvas-llamar");
    btnAchicar = document.querySelector("#btnAchicar");

    btnAgrandar.onclick = () => {
        contenedor.classList.remove("article-grafico");
        contenedor.classList.add("article-grafico-2");
        for (let i = 0; i < divGrafico.length; i++) {
            canvas[i].classList.add("canvas");
            canvas[i].classList.remove("canvas-2");
            divGrafico[i].classList.remove("div-grafico")
            divGrafico[i].classList.add("div-grafico-2")
        }
        btnAgrandar.style.display = "none";
        btnAchicar.style.display = "block";
    }

    btnAchicar.onclick = () => {
        contenedor.classList.remove("article-grafico-2");
        contenedor.classList.add("article-grafico");
        for (let i = 0; i < divGrafico.length; i++) {
            canvas[i].classList.remove("canvas");
            canvas[i].classList.add("canvas-2");
            divGrafico[i].classList.remove("div-grafico-2")
            divGrafico[i].classList.add("div-grafico")
        }
        btnAgrandar.style.display = "block";
        btnAchicar.style.display = "none";
    }
</script>