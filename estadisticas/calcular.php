<?php
    session_start();
    include("../config/db.php"); 
    include("../template/cabecera.php");

    $fecha_desde_dia = (isset($_POST["fecha_desde_dia"])) ? $_POST["fecha_desde_dia"] : "";
    $fecha_hasta_dia = (isset($_POST["fecha_hasta_dia"])) ? $_POST["fecha_hasta_dia"] : "";

    $fecha_desde_semana = (isset($_POST["fecha_desde_semana"])) ? $_POST["fecha_desde_semana"] : "";
    $fecha_desde_semana = $fecha_desde_semana ? date("Y-m-d",strtotime($fecha_desde_semana)) : "";
    if ($fecha_desde_semana) {
        $fecha_hasta_semana = strtotime($fecha_desde_semana."+ 6 days");
        $fecha_hasta_semana = date("Y-m-d",$fecha_hasta_semana);
    }
    
    $fecha_desde_mes = (isset($_POST["fecha_desde_mes"])) ? $_POST["fecha_desde_mes"] : "";
    if ($fecha_desde_mes) {
        $date = new DateTime($fecha_desde_mes);  //Creo esto para extraer el mes con format
        $fecha_hasta_mes = $date -> format("m"); //Extraigo el numero del mes

        $fechaActual = date('d-m-Y'); 
        $bisiesto = date("L",strtotime($fechaActual));  //Si es bisiesto
       
        $mesArreglo = ["01" => 30,"02" => $febrero = ($bisiesto == 0) ? 27 : 28,"03" => 30,"04" => 29,"05" => 30,"06" => 29,"07" => 30,"08" => 30,"09" => 29,"10" => 30,"11" => 29,"12" => 30];
        
        foreach ($mesArreglo as $key => $value) { //Busco el indice y extraigo el valor
            if ($key == $fecha_hasta_mes) {
                $diaMes =  $value;
            }
        }
        $fecha_hasta_mes = strtotime($fecha_desde_mes."+ $diaMes days"); //Le sumo los dias
        $fecha_hasta_mes = date("Y-m-d",$fecha_hasta_mes);  //Lo paso a formato de fecha sql
        
       
    }
    
    //Por dia
    if ($fecha_desde_dia && $fecha_hasta_dia) { 

        //En esta consulta traigo agrupado por positivo o negativo , y le faso la fecha desde hasta
        $consulta = $conexion -> prepare("SELECT motivo.motivo,sum(cantidad) as 'cantidad',tipo from reduccion,motivo where reduccion.id_motivosFK = motivo.id_motivo and fecha BETWEEN :fecha_desde_dia and :fecha_hasta_dia and estado = 1 group by motivo order by motivo asc;");
        $consulta -> bindParam("fecha_desde_dia",$fecha_desde_dia);
        $consulta -> bindParam("fecha_hasta_dia",$fecha_hasta_dia);
        $consulta -> execute();
        $listaMotivos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
         $cantidadPositivo = 0;  
         $cantidadNegativo = 0;
         $cantidadGeneral = 0; //Para sacar porcentaje  
        //Calculo la cantidad de positivos y negativos
        foreach ($listaMotivos as $motivos) {
            if ($motivos["tipo"] == "positivo") {
                $cantidadPositivo += $motivos["cantidad"];
            }else {
                $cantidadNegativo += $motivos["cantidad"];
            }
            $cantidadGeneral += $motivos["cantidad"];
        }

        if ($cantidadPositivo > $cantidadNegativo) {
            $resto = $cantidadPositivo - $cantidadNegativo;  //Muestra la diferencia
            $total = $cantidadPositivo + $cantidadNegativo;  //Muestra el total
            $porcentaje = round(($resto / $total) * 100) ;          //Porcentaje
            $fechaOrdenada = date("d-m-Y",strtotime($fecha_desde_dia));  //Cambio el formato de las fechas para que se muestre por dia-mes-año
            $fechaOrdenada2 = date("d-m-Y",strtotime($fecha_hasta_dia));

?>
            <section class="container mt-5">
            <h1 class="d-flex justify-content-center my-3">Han tenido ganancias en las fechas seleccionadas</h1>
            <ul class="my-5">
                <li>
                    <p>Desde: <?php echo $fechaOrdenada ?></p>
                </li>
                <li>
                    <p>hasta: <?php echo $fechaOrdenada2 ?></p>
                </li>
            </ul>

            <table class="table text-center table-responsive table-striped">
                <thead class="table-dark">
                        <tr>
                        <th>Motivos</th>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Total</th>
                        <th>Diferencia</th>
                        <th>Porcentaje</th>
                        </tr>
                </thead>
                <tbody>
                    <?php  foreach ($listaMotivos as $positivos) { ?>
                        <tr>
                        <td><?php echo $positivos['motivo']; ?></td>
                        <td><?php echo $positivos['cantidad']; ?></td>
                        <?php  ($positivos['tipo'] == "positivo") ? $tipo = "<td class='bg-success'>". $positivos["tipo"] ."</td>": $tipo = "<td class='bg-danger'>". $positivos["tipo"] ."</td>"  ?>
                        <?php echo $tipo ?>
                        <?php  } ?>
                        <td class="bg-info"> <?php echo $total ?></td>
                        <td class="bg-primary"> <?php echo $resto ?></td>
                        <td class="bg-warning"> <?php echo $porcentaje . "%" ?></td>
                    </tr>
                    </tbody>
                </table>
                <div class="row w-50 mt-5 m-auto">
                    <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
                </div>
                </a>
            </section>
                
<?php 
        }elseif ($cantidadNegativo > $cantidadPositivo) {
            $resto = $cantidadNegativo - $cantidadPositivo;  //Muestra el resto
            $total = $cantidadPositivo + $cantidadNegativo;  //Muestra el total
            $porcentaje = round(($resto / $total) * 100) ;   //Porcentaje
            $fechaOrdenada = date("d-m-Y",strtotime($fecha_desde_dia)); 
            $fechaOrdenada2 = date("d-m-Y",strtotime($fecha_hasta_dia));

            ?>
            <section class="container">

                <h1 class="d-flex justify-content-center mt-5">Han tenido perdidas en las fechas seleccionadas</h1>
                <ul class="my-5">
                    <li>
                        <p>Desde: <?php echo $fechaOrdenada ?></p>
                    </li>
                    <li>
                        <p>hasta: <?php echo $fechaOrdenada2 ?></p>
                    </li>
                </ul>
            <table class="table table-responsive table-striped text-center">
                <thead class="table-dark">
                        <tr>
                        <th>Motivos</th>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Total</th>
                        <th>Diferencia</th>
                        <th>Porcentaje</th>
                        </tr>
                </thead>
                <tbody>
                    <?php  foreach ($listaMotivos as $negativos) { ?>
                        <tr>
                        <td><?php echo $negativos['motivo']; ?></td>
                        <td><?php echo $negativos['cantidad']; ?></td>
                        <?php ($negativos['tipo'] == "positivo") ? $tipo = "<td class='bg-success'>". $negativos["tipo"] ."</td>" : $tipo ="<td class='bg-danger'>". $negativos["tipo"] ."</td>"  ?>
                        <?php echo $tipo ;?>
                        <?php } ?>
                        <td class="bg-info"> <?php echo $total ?></td>
                        <td class="bg-primary"> <?php echo $resto ?></td>
                        <td class="bg-warning"> <?php echo $porcentaje . "%" ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="row w-50 mt-5 mx-auto">
                    <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
                </div>
        </section>

         <?php  
            
        }else if($cantidadNegativo == 0 && $cantidadPositivo == 0){
            ?>
                <div class="d-block container ">
                    <div class="flex-row justify-content-center">
                        <h1>No hay datos registrados en las fechas seleccionadas.</h1>
                        <div class="row w-50 mt-5 mx-auto">
                            <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
                        </div>
                </div>
        </div>
            <?php
            //Sino quiere decir que las dos cantidadades son iguales y no son cero
        }else {
            $resto = $cantidadNegativo - $cantidadPositivo;  //Muestra el resto
            $total = $cantidadPositivo + $cantidadNegativo;  //Muestra el total
            $porcentaje = round(($resto / $total) * 100) ;   //Porcentaje
            $fechaOrdenada = date("d-m-Y",strtotime($fecha_desde_dia)); 
            $fechaOrdenada2 = date("d-m-Y",strtotime($fecha_hasta_dia));
    ?>
        <section class="container">
            <h1 class="d-flex justify-content-center mt-5">No ha tenido perdidas ni ganancias.</h1>
            <ul class="my-5">
                <li>
                    <p>Desde: <?php echo $fechaOrdenada ?></p>
                </li>
                <li>
                    <p>hasta: <?php echo $fechaOrdenada2 ?></p>
                </li>
            </ul>
        <table class="table table-responsive table-striped text-center">
            <thead class="table-dark">
                    <tr>
                    <th>Motivos</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                    <th>Total</th>
                    <th>Diferencia</th>
                    </tr>
            </thead>
            <tbody>
                <?php  foreach ($listaMotivos as $negativos) { ?>
                    <tr>
                    <td><?php echo $negativos['motivo']; ?></td>
                    <td><?php echo $negativos['cantidad']; ?></td>
                    <?php ($negativos['tipo'] == "positivo") ? $tipo = "<td class='bg-success'>". $negativos["tipo"] ."</td>" : $tipo ="<td class='bg-danger'>". $negativos["tipo"] ."</td>"  ?>
                    <?php echo $tipo ;?>
                    <?php } ?>
                    <td class="bg-info"> <?php echo $total ?></td>
                    <td class="bg-primary"> <?php echo $resto ?></td>
                </tr>
            </tbody>
        </table>
        <div class="row w-50 mt-5 mx-auto">
                <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
            </div>
    </section>

    <?php  
        }

        //por SEMANA
    }elseif ($fecha_desde_semana) {
        //En esta consulta traigo agrupado por positivo o negativo , y le faso la fecha desde hasta
        $consulta = $conexion -> prepare("SELECT motivo.motivo,sum(cantidad) as 'cantidad',tipo from reduccion,motivo where reduccion.id_motivosFK = motivo.id_motivo and (motivo.tipo = 'positivo' or motivo.tipo = 'negativo')and fecha between :fecha_desde_semana and :fecha_hasta_semana and estado = 1 group by motivo order by motivo asc;");
        $consulta -> bindParam("fecha_desde_semana",$fecha_desde_semana);
        $consulta -> bindParam("fecha_hasta_semana",$fecha_hasta_semana);
        $consulta -> execute();
        $listaMotivos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
         $cantidadPositivo = 0;  
         $cantidadNegativo = 0;  
        //Calculo la cantidad de positivos y negativos
        foreach ($listaMotivos as $motivos) {
            if ($motivos["tipo"] == "positivo") {
                $cantidadPositivo += $motivos["cantidad"];
            }else {
                $cantidadNegativo += $motivos["cantidad"];
            }
        }

        if ($cantidadPositivo > $cantidadNegativo) {
            $resto = $cantidadPositivo - $cantidadNegativo;  //Muestra la diferencia
            $total = $cantidadPositivo + $cantidadNegativo;  //Muestra el total
            $porcentaje = round(($resto / $total) * 100) ;   //Porcentaje
            $fechaOrdenada = date("d-m-Y",strtotime($fecha_desde_semana));  //Cambio el formato de las fechas para que se muestre por dia-mes-año
            $fechaOrdenada2 = date("d-m-Y",strtotime($fecha_hasta_semana));
            
  
            ?>
        <section class="container">          
            <h1 class="m-5 d-flex justify-content-center">Han tenido ganancias en las fechas seleccionadas</h1>
            <ul class="my-5">
                <li>
                    <p>Desde: <?php echo $fechaOrdenada ?></p>
                </li>
                <li>
                    <p>hasta: <?php echo $fechaOrdenada2 ?></p>
                </li>
            </ul>
            <table class="table text-center table-striped table-responsive">
                <thead class="table-dark">
                        <tr>
                        <th class="col-2">Motivos</th>
                        <th class="col-2">Cantidad</th>
                        <th class="col-2">Tipo</th>
                        <th class="col-2">Total</th>
                        <th class="col-2">Diferencia</th>
                        <th class="col-2">Porcentaje</th>
                        </tr>
                </thead>
                <tbody>
                    <?php  foreach ($listaMotivos as $positivos) { ?>
                        <tr>
                        <td><?php echo $positivos['motivo']; ?></td>
                        <td><?php echo $positivos['cantidad']; ?></td>
                        <?php  ($positivos['tipo'] == "positivo") ? $tipo = "<td class='bg-success'>". $positivos["tipo"] ."</td>": $tipo = "<td class='bg-danger'>". $positivos["tipo"] ."</td>"  ?>
                        <?php echo $tipo ?>
                        <?php  } ?>
                        <td class="bg-info"> <?php echo $total ?></td>
                        <td class="bg-primary"> <?php echo $resto ?></td>
                        <td class="bg-warning"> <?php echo $porcentaje . "%" ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="row w-50 mt-5 mx-auto">
                    <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
            </div>
        </section>

<?php 
    }elseif ($cantidadNegativo > $cantidadPositivo) {
        $resto = $cantidadNegativo - $cantidadPositivo;  //Muestra el resto
        $total = $cantidadPositivo + $cantidadNegativo;  //Muestra el total
        $porcentaje = round(($resto / $total) * 100) ;   //Porcentaje
        $fechaOrdenada = date("d-m-Y",strtotime($fecha_desde_semana));  //Cambio el formato de las fechas para que se muestre por dia-mes-año
        $fechaOrdenada2 = date("d-m-Y",strtotime($fecha_hasta_semana));
        
        ?>
        <section class="container">
            <h1 class="m-5 d-flex justify-content-center">Han tenido perdidas en la fechas seleccionadas</h1>
            <ul class="my-5">
                <li>
                    <p>Desde: <?php echo $fechaOrdenada ?></p>
                </li>
                <li>
                    <p>hasta: <?php echo $fechaOrdenada2 ?></p>
                </li>
            </ul>
                <table class="table text-center table-striped table-responsive">
                    <thead class="table-dark">
                    <tr>
                    <th class="col-2">Motivos</th>
                    <th class="col-2">Cantidad</th>
                    <th class="col-2">Tipo</th>
                    <th class="col-2">Total</th>
                    <th class="col-2">Diferencia</th>
                    <th class="col-2">Porcentaje</th>
                    </tr>
            </thead>
            <tbody>
                <?php  foreach ($listaMotivos as $negativos) { ?>
                    <tr>
                    <td><?php echo $negativos['motivo']; ?></td>
                    <td><?php echo $negativos['cantidad']; ?></td>
                    <?php  ($negativos['tipo'] == "positivo") ? $tipo = "<td class='bg-success'>". $negativos["tipo"] ."</td>": $tipo ="<td class='bg-danger'>". $negativos["tipo"] ."</td>"  ?>
                        <?php echo $tipo ?>
                    <?php  } ?>
                    <td class="bg-info"> <?php echo $total ?></td>
                    <td class="bg-primary"> <?php echo $resto ?></td>
                    <td class="bg-warning"> <?php echo $porcentaje . "%" ?></td>
                </tr>
            </tbody>
        </table>
        <div class="row w-50 mt-5 mx-auto">
            <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
        </div>
    </section>

     <?php  
        
    }else if($cantidadNegativo == 0 && $cantidadPositivo == 0){
        ?>
             <div class="d-block container ">
                <div class="flex-row justify-content-center">
                    <h1>No hay datos registrados en las fechas seleccionadas.</h1>
                    <div class="row w-50 mt-5 mx-auto">
                        <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
                    </div>
            </div>
        </div>
        <?php
    }else{
        
        $resto = $cantidadNegativo - $cantidadPositivo;  //Muestra el resto
        $total = $cantidadPositivo + $cantidadNegativo;  //Muestra el total
        $fechaOrdenada = date("d-m-Y",strtotime($fecha_desde_dia)); 
        $fechaOrdenada2 = date("d-m-Y",strtotime($fecha_hasta_dia));

        ?>
        <section class="container">

            <h1 class="d-flex justify-content-center mt-5">No ha tenido perdidas ni ganancias.</h1>
            <ul class="my-5">
                <li>
                    <p>Desde: <?php echo $fechaOrdenada ?></p>
                </li>
                <li>
                    <p>hasta: <?php echo $fechaOrdenada2 ?></p>
                </li>
            </ul>
        <table class="table table-responsive table-striped text-center">
            <thead class="table-dark">
                    <tr>
                    <th>Motivos</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                    <th>Total</th>
                    <th>Diferencia</th>
                    </tr>
            </thead>
            <tbody>
                <?php  foreach ($listaMotivos as $negativos) { ?>
                    <tr>
                    <td><?php echo $negativos['motivo']; ?></td>
                    <td><?php echo $negativos['cantidad']; ?></td>
                    <?php ($negativos['tipo'] == "positivo") ? $tipo = "<td class='bg-success'>". $negativos["tipo"] ."</td>" : $tipo ="<td class='bg-danger'>". $negativos["tipo"] ."</td>"  ?>
                    <?php echo $tipo ;?>
                    <?php } ?>
                    <td class="bg-info"> <?php echo $total ?></td>
                    <td class="bg-primary"> <?php echo $resto ?></td>
                </tr>
            </tbody>
        </table>
        <div class="row w-50 mt-5 mx-auto">
                <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
            </div>
    </section>
     <?php  
    }
    //por MES
}elseif ($fecha_desde_mes){
    //En esta consulta traigo agrupado por positivo o negativo , y le faso la fecha desde hasta
    $consulta = $conexion -> prepare("SELECT motivo.motivo,sum(cantidad) as 'cantidad',tipo from reduccion,motivo where reduccion.id_motivosFK = motivo.id_motivo and fecha BETWEEN :fecha_desde_mes and :fecha_hasta_mes and estado = 1 group by motivo order by motivo asc;");
    $consulta -> bindParam("fecha_desde_mes",$fecha_desde_mes);
    $consulta -> bindParam("fecha_hasta_mes",$fecha_hasta_mes);
    $consulta -> execute();
    $listaMotivos = $consulta -> fetchAll(PDO::FETCH_ASSOC);
    $cantidadPositivo = 0;  
    $cantidadNegativo = 0;  
    //Calculo la cantidad de positivos y negativos
    foreach ($listaMotivos as $motivos) {
        if ($motivos["tipo"] == "positivo") {
            $cantidadPositivo += $motivos["cantidad"];
        }else {
            $cantidadNegativo += $motivos["cantidad"];
        }
    }

    if ($cantidadPositivo > $cantidadNegativo) {
        $resto = $cantidadPositivo - $cantidadNegativo;  //Muestra la diferencia
        $total = $cantidadPositivo + $cantidadNegativo;  //Muestra el total
        $porcentaje = round(($resto / $total) * 100) ;   //Porcentaje
        $fechaOrdenada = date("d-m-Y",strtotime($fecha_desde_mes));  //Cambio el formato de las fechas para que se muestre por dia-mes-año
        $fechaOrdenada2 = date("d-m-Y",strtotime($fecha_hasta_mes));

    ?>
        <section class="container">
            <h1 class="m-5 d-flex justify-content-center">Han tenido ganancias en la fechas seleccionadas</h1>
            <ul class="my-5">
                <li>
                    <p>Desde: <?php echo $fechaOrdenada ?></p>
                </li>
                <li>
                    <p>hasta: <?php echo $fechaOrdenada2 ?></p>
                </li>
            </ul>
        <table  class="table text-center table-striped table-responsive">
            <thead class="table-dark">
                    <tr>
                    <th class="col-2">Motivos</th>
                    <th class="col-2">Cantidad</th>
                    <th class="col-2">Tipo</th>
                    <th class="col-2">Total</th>
                    <th class="col-2">Diferencia</th>
                    <th class="col-2">Porcentaje</th>
                    </tr>
            </thead>
            <tbody>
                <?php  foreach ($listaMotivos as $positivos) { ?>
                    <tr>
                    <td><?php echo $positivos['motivo']; ?></td>
                    <td><?php echo $positivos['cantidad']; ?></td>
                    <?php  ($positivos['tipo'] == "positivo") ? $tipo = "<td class='bg-success'>". $positivos["tipo"] ."</td>": $tipo = "<td class='bg-danger'>". $positivos["tipo"] ."</td>"  ?>
                    <?php echo $tipo ?>
                    <?php  } ?>
                    <td class="bg-info"> <?php echo $total ?></td>
                    <td class="bg-primary"> <?php echo $resto ?></td>
                    <td class="bg-warning"> <?php echo $porcentaje . "%" ?></td>
                </tr>
                </tbody>
            </table>
            <div class="row w-50 mt-5 mx-auto">
                <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
            </div>
        </section>

    <?php 
    }elseif ($cantidadNegativo > $cantidadPositivo) {
        $resto = $cantidadNegativo - $cantidadPositivo;  //Muestra el resto
        $total = $cantidadPositivo + $cantidadNegativo;  //Muestra el total
        $porcentaje = round(($resto / $total) * 100) ;   //Porcentaje
        $fechaOrdenada = date("d-m-Y",strtotime($fecha_desde_mes));  //Cambio el formato de las fechas para que se muestre por dia-mes-año
        $fechaOrdenada2 = date("d-m-Y",strtotime($fecha_hasta_mes));

        ?>
            <section class="container">
            <h1 class="m-5 d-flex justify-content-center">Han tenido perdidas en la fechas seleccionadas</h1>
            <ul class="my-5">
                <li>
                    <p>Desde: <?php echo $fechaOrdenada ?></p>
                </li>
                <li>
                    <p>hasta: <?php echo $fechaOrdenada2 ?></p>
                </li>
            </ul>
                <table class="table text-center table-striped table-responsive">
                    <thead class="table-dark">
                        <tr>
                            <th class="col-2">Motivos</th>
                            <th class="col-2">Cantidad</th>
                            <th class="col-2">Tipo</th>
                            <th class="col-2">Total</th>
                            <th class="col-2">Diferencia</th>
                            <th class="col-2">Porcentaje</th>
                    </tr>
            </thead>
            <tbody>
                <?php  foreach ($listaMotivos as $negativos) { ?>
                    <tr>
                        <td><?php echo $negativos['motivo']; ?></td>
                        <td><?php echo $negativos['cantidad']; ?></td>
                        <?php ($negativos['tipo'] == "positivo") ? $tipo = "<td class='bg-success'>". $negativos["tipo"] ."</td>" :$tipo ="<td class='bg-danger'>". $negativos["tipo"] ."</td>"  ?>
                        <?php echo $tipo ;?>
                        <?php } ?>
                        <td class="bg-info"> <?php echo $total ?></td>
                        <td class="bg-primary"> <?php echo $resto ?></td>
                        <td class="bg-warning"> <?php echo $porcentaje . "%" ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="row w-50 mt-5 mx-auto">
                <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
            </div>
        </section>

    <?php  
        
    }else if($cantidadNegativo == 0 && $cantidadPositivo == 0){
        ?>
        <div class="d-block container ">
            <div class="flex-row justify-content-center">
                <h1>No hay datos registrados en las fechas seleccionadas.</h1>
                <div class="row w-50 mt-5 mx-auto">
                    <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
                </div>
            </div>
        </div>
    <?php
    }else {
       
        $resto = $cantidadNegativo - $cantidadPositivo;  //Muestra el resto
        $total = $cantidadPositivo + $cantidadNegativo;  //Muestra el total
        $fechaOrdenada = date("d-m-Y",strtotime($fecha_desde_dia)); 
        $fechaOrdenada2 = date("d-m-Y",strtotime($fecha_hasta_dia));

        ?>
        <section class="container">

            <h1 class="d-flex justify-content-center mt-5">No ha tenido perdidas ni ganancias.</h1>
            <ul class="my-5">
                <li>
                    <p>Desde: <?php echo $fechaOrdenada ?></p>
                </li>
                <li>
                    <p>hasta: <?php echo $fechaOrdenada2 ?></p>
                </li>
            </ul>
        <table class="table table-responsive table-striped text-center">
            <thead class="table-dark">
                    <tr>
                    <th>Motivos</th>
                    <th>Cantidad</th>
                    <th>Tipo</th>
                    <th>Total</th>
                    <th>Diferencia</th>
                    </tr>
            </thead>
            <tbody>
                <?php  foreach ($listaMotivos as $negativos) { ?>
                    <tr>
                    <td><?php echo $negativos['motivo']; ?></td>
                    <td><?php echo $negativos['cantidad']; ?></td>
                    <?php ($negativos['tipo'] == "positivo") ? $tipo = "<td class='bg-success'>". $negativos["tipo"] ."</td>" : $tipo ="<td class='bg-danger'>". $negativos["tipo"] ."</td>"  ?>
                    <?php echo $tipo ;?>
                    <?php } ?>
                    <td class="bg-info"> <?php echo $total ?></td>
                    <td class="bg-primary"> <?php echo $resto ?></td>
                </tr>
            </tbody>
        </table>
        <div class="row w-50 mt-5 mx-auto">
                <a href="estadisticas.php"> <button class="btn btn-primary w-100" type="button">Regresar</button>
            </div>
    </section>
    <?php  
    }
    }
?>