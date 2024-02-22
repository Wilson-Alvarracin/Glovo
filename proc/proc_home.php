<?php
include_once 'conexion.php';



$sql_tipo = "SELECT * FROM tbl_cocinas";
$sql_res = "
SELECT r.id_restaurante, r.rest_nom AS nom, r.rest_img AS portada, c.cocina_nom AS tipo_cocina, ROUND(AVG(v.valoracion), 2) AS media
    FROM tbl_restaurante r
    INNER JOIN
        tbl_valoracion v ON r.id_restaurante = v.id_rest
    INNER JOIN
        tbl_restu_cocina rc ON r.id_restaurante = rc.id_restaurante
    INNER JOIN
        tbl_cocinas c ON rc.tipo_cocina = c.id_cocina
    GROUP BY
        r.id_restaurante, r.rest_nom, c.cocina_nom;";
try {
    
    echo '
    <div class="slt column-1 flex">
    <div id="buscador">
            <div class="column-2">
                <div class="input-group input-group-sm">
                    <input id="comida" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>';
    echo '
    <div class="column-4">
    <select id="cocina" class="form-select form-select-sm" aria-label="Default select example">
        <option selected disabel hidden>Tipo de Cocina</option>';

    $stmt = $conn->prepare($sql_tipo);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $cocina) {
        echo '<option value="'.$cocina['id_cocina'].'">'.$cocina['cocina_nom'].'</option>';
    }
    echo '
    </select>
    </div>';
    echo '
    <div class="column-4">
        <select id="precio" class="form-select form-select-sm" aria-label="Default select example">
            <option hidden disabel selected>Precio medio</option>
            <option value="1">€€€ Mas de 20€</option>
            <option value="2">€€ Entre 10€ a 20€</option>
            <option value="3">€ Menos de 10€</option>
        </select>
        </div>
    </div>
    </div>
    <div id="restaurantes" class="slt">';

    $stmt = $conn->prepare($sql_res);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach ($result as $restaurantes) {
        $color = random_int(1,3);
        echo '
        <div class="column-4 flex">
            <div class="card">
                <a href="./view.php?id='.$restaurantes['id_restaurante'].'">
                    <img src='.$restaurantes['portada'].' class="card-img-top" alt="...">
                </a>
                <div class="card-body">
                    <h3 class="card-title">'.$restaurantes['nom'].'</h3>
                    <div class="label clr-'.$color.'">
                        <span class="label-name flex"><box-icon name="restaurant"></box-icon></box-icon>'.$restaurantes['tipo_cocina'].'</span>
                    </div>
                    <div class="label clr-price">
                        <span class="label-name flex"><box-icon name="leaf" rotate="270" color="#00d40f"></box-icon>bug</span>
                    </div>
                    <P>valoracion: '.$restaurantes['media'].'/5</P>
                    <p class="card-text">La Farga, Hospitalet de Llobregat</p>
                </div>
            </div>
        </div>';
    }


}catch (PDOException $e){
    echo "Error: ". $e->getMessage() ."";
}

