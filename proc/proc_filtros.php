<?php
include_once 'conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = $_POST['datos'];
    $filtros = json_decode($datos, true);

    $local = $filtros['local'];
    $cocina = $filtros['cocina'];
    $precio = $filtros['precio'];
    $id = 0;
    $sql ='SELECT r.rest_img AS img, r.id_restaurante, r.rest_nom AS nombre_restaurante, c.id_cocina, c.cocina_nom AS tipo_cocina, ROUND(AVG(p.plato_precio), 2) AS precio_medio_platos, ROUND(AVG(v.valoracion), 2) AS media_valoraciones FROM tbl_restaurante r INNER JOIN tbl_restu_cocina rc ON r.id_restaurante = rc.id_restaurante INNER JOIN tbl_cocinas c ON rc.tipo_cocina = c.id_cocina LEFT JOIN tbl_platos p ON r.id_restaurante = p.id_restaurante LEFT JOIN tbl_valoracion v ON r.id_restaurante = v.id_rest ';

    $myfil = "";
    if(!$filtros['local'] == "" && !$filtros['local'] == 0){
        $myfil .= 'WHERE r.rest_nom LIKE Concat("%",:local,"%") ';
    }

    if(!$filtros['cocina']== "" && !$filtros['cocina'] == 0){
        if ($myfil == "") {
            $myfil .= 'WHERE c.id_cocina = :cocina ' ;
        }else{
            $myfil .= 'AND c.id_cocina = :cocina ';
        }
    }

    $myfil .= 'GROUP BY r.id_restaurante, r.rest_nom, c.id_cocina, c.cocina_nom ';

    if(!$filtros['precio']== "" && !$filtros['precio'] == 0){
        if ($filtros['precio'] == 1) {
            $myfil .= 'HAVING precio_medio_platos >= 12 ';
        }elseif ($filtros['precio'] == 2) {
            $myfil .= 'HAVING precio_medio_platos <= 19 ';
        }else{
            $myfil .= 'HAVING precio_medio_platos <= 35 ';
        }
    }

    if ($myfil == "") {
        $sql = "ORDER BY r.id_restaurante ASC;";
    }else{
        $myfil .= "ORDER BY r.id_restaurante ASC;";
        $sql .= $myfil;
    }
    try {
        $stmt = $conn->prepare($sql);
        if (!$filtros['local']== "") {
            $stmt -> bindParam(':local',$local);
        }
        if (!$filtros['cocina']== "") {
            $stmt -> bindParam(':cocina',$cocina);
        }   
        $stmt -> execute();
        $result = $stmt ->fetchAll();

        foreach ($result as $restaurantes) {
            $color = random_int(1,3);
            echo '
            <div class="column-4 flex">
                <div class="card">
                <a href="./view.php?id='.$restaurantes['id_restaurante'].'">
                    <div class="icon flex">
                        <img src='.$restaurantes['img'].' class="card-img-top" alt="...">
                    </div>
                </a>
                    <div class="card-body">
                        <h3 class="card-title">'.$restaurantes['nombre_restaurante'].'</h3>
                        <div class="label clr-'.$color.'">
                            <span class="label-name flex"><box-icon name="restaurant"></box-icon></box-icon>'.$restaurantes['tipo_cocina'].'</span>
                        </div>';
            if ($restaurantes['precio_medio_platos'] >= 20) {
                $a = 3;
            }elseif ($restaurantes['precio_medio_platos'] >= 15) {
                $a = 2;
            }else {
                $a = 1;
            }
            echo '<div class="label clr-price">
            <span class="label-price flex">';
            for ($i=0; $i < $a; $i++) { 
                echo "<box-icon name='dollar'></box-icon>";
            }
            echo '</span></div>
            <p>valoracion: '.$restaurantes['media_valoraciones'].'/5</p>
            <p class="card-text">La Farga, Hospitalet de Llobregat</p></div></div></div>';

        }
    } catch (PDOException $e){
        echo "Error: ". $e->getMessage() ."";
        echo "<br>";
        echo $sql;
        echo "<br>";    
    }

}else{

}

