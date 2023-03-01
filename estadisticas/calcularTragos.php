<?php
    session_start();
    include("../config/db.php"); 
    include("../template/cabecera.php");
    $fecha_desde = (isset($_POST["fecha_desde"])) ? $_POST["fecha_desde"] : ""; 
    $fecha_hasta = (isset($_POST["fecha_hasta"])) ? $_POST["fecha_hasta"] : "";

    if ($fecha_desde && $fecha_hasta) { //Trae el nombre y la cantidad de los tragos vendidos
        
        $precios = []; //Guardo el precio multiplicado por cantidad de cada trago.
        
        $consulta = $conexion -> prepare("SELECT (tragos.nombre) as 'nombre',sum((precio_venta_tragos * cantidad))  as 'total',sum(cantidad) as 'cantidad' from tragos,tragos_ventas,ventas WHERE ventas.id_ventas = tragos_ventas.id_ventasFK AND tragos.id_tragos = tragos_ventas.id_tragosFK AND ventas.fecha BETWEEN :fecha_desde and :fecha_hasta GROUP BY tragos.nombre;");
        
        $consulta -> bindParam("fecha_desde",$fecha_desde);
        $consulta -> bindParam("fecha_hasta",$fecha_hasta);
        $consulta -> execute();
        $listaTotal = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    
        for ($i=0; $i < count($listaTotal) ; $i++) { 
            $precios[$i] = $listaTotal[$i]["total"];
        }

        $dineroAcumulado = 0; //Contiene el dinero total acumulado;

        for ($i=0; $i < count($precios); $i++) { 
            $dineroAcumulado += $precios[$i];
        }
        ?>

    <section class="container-fluid section-grafico">
        <article class="article-grafico" id="article-contenedor-graficos">
            <div class="div-grafico">
                <canvas id="myChart" class="canvas-llamar"></canvas>
            </div>
            <div class=" div-grafico">
                <canvas id="myChart1" class="canvas-llamar"></canvas>
            </div>
        </article>
        <div class="my-3">
            <p><strong><u>Total ganancias: $<?php echo $dineroAcumulado ?></u></strong></p>
            <a href="estadisticasTragos.php"><button class="btn btn-dark mt-4">Regresar</button></a>
            <br>
            <button type="button" id="btnAgrandar" class="btn btn-dark mt-2">Agrandar cuadro</button>
            <button type="button" style="display:none" id="btnAchicar" class="btn btn-dark mt-2">Achicar cuadro</button>
        </div>
    </section>   

<?php include("../template/footer.php") ?>
<script>

    //Graficos
const grafico1 = document.getElementById('myChart');
    const myChart = new Chart(grafico1, {
    type: 'bar',
    data: {
        labels: [

        <?php
            foreach ($listaTotal as $total ) {
        ?>
                '<?php echo "$total[nombre]" ?>',
        <?php
            }
        ?>

        ],
        datasets: [{
            label: 'Vendidos',
            data: [
                <?php
            foreach ($listaTotal as $total ) {
        ?>
                '<?php echo "$total[cantidad]" ?>',
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
                text: 'Cantidad por trago'
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
           foreach ($listaTotal as $total ) {
        ?>
                '<?php echo "$total[nombre]" ?>',
        <?php
            }
        ?>

        ],
        datasets: [{
            label: '$',
            data: [
        <?php
             for ($i=0; $i < count($precios); $i++) {
        ?>
                "<?php echo $precios[$i] ?>",
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
                text: "Ingresos por trago"
            }
        }
    }
});
</script>
<?php
}
?>

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
    