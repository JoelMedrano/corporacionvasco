<?php 
require_once "../modelos/ArticuloV.php";

$articulov=new ArticuloV();


$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$art_codigo=isset($_POST["art_codigo"])? limpiarCadena($_POST["art_codigo"]):"";
$art_modelo=isset($_POST["art_modelo"])? limpiarCadena($_POST["art_modelo"]):"";
$art_color=isset($_POST["art_color"])? limpiarCadena($_POST["art_color"]):"";
$art_talla=isset($_POST["art_talla"])? limpiarCadena($_POST["art_talla"]):"";
$art_marca=isset($_POST["art_marca"])? limpiarCadena($_POST["art_marca"]):"";
$art_nombre=isset($_POST["art_nombre"])? limpiarCadena($_POST["art_nombre"]):"";
$art_unidad=isset($_POST["art_unidad"])? limpiarCadena($_POST["art_unidad"]):"";
$art_caracteristica=isset($_POST["art_caracteristica"])? limpiarCadena($_POST["art_caracteristica"]):"";
$art_stock_min=isset($_POST["art_stock_min"])? limpiarCadena($_POST["art_stock_min"]):"";
$art_stock_max=isset($_POST["art_stock_max"])? limpiarCadena($_POST["art_stock_max"]):"";



$codigo_talla = substr($art_talla, 0, 1);   


$newart_codigo=($art_modelo . $art_color . $codigo_talla);



switch ($_GET["op"]){
    case 'guardaryeditar':

       
        if (empty($idarticulo)){
            $rspta=$articulov->insertar($newart_codigo,$art_modelo,$art_color,$art_talla,$art_marca, $art_nombre, $art_unidad, $art_caracteristica, $art_stock_min,  $art_stock_max );
            echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
        }
        else {
            $rspta=$articulov->editar($idarticulo, $art_nombre,  $art_stock_min, $art_stock_max);
            echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
        }
    break;

    case 'desactivar':
        $rspta=$articulov->desactivar($idarticulo);
        echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
    break;

    case 'activar':
        $rspta=$articulov->activar($idarticulo);
        echo $rspta ? "Artículo Activado" : "Artículo no se puede activar";
    break;

    case 'mostrar':
        $rspta=$articulov->mostrar($idarticulo);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta=$articulov->listar();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->art_estado=='ACTIVO')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->art_codigo,    
                "2"=>$reg->art_marca,
                "3"=>$reg->art_nombre,
                "4"=>$reg->col_nombre,
                "5"=>$reg->art_nom_talla,
                "6"=>$reg->art_caracteristica,
                "7"=>($reg->art_estado=='ACTIVO')?('<span class="label bg-green">ACTIVO</span>'):(($reg->art_estado=='DESCONTINUADO')?('<span class="label bg-red">DESCONTINUADO</span>'):('<span class="label bg-yellow">CAMPAÑA</span>'))
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;

    case "selectColor":
        require_once "../modelos/Consultas.php";
        $Consultas = new Consultas();
 
        $rspta = $Consultas->selectColorArticulo();
        echo '<option value=0>Seleccione...</option>'; 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->art_color . '>' . $reg->col_nombre . '</option>';
                }
    break;



case "selectTalla":
        require_once "../modelos/Consultas.php";
        $Consultas = new Consultas();
 
        $rspta = $Consultas->selectTallaArticulo();
        echo '<option value=0>Seleccione...</option>'; 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->art_talla . '>' . $reg->nombre_talla . '</option>';
                }
    break;






case "selectCaracteristica":
        require_once "../modelos/Consultas.php";
        $Consultas = new Consultas();
 
        $rspta = $Consultas->selectCaracteristicaArticulo();
        echo '<option value=0>Seleccione...</option>'; 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->art_caracteristica . '>' . $reg->carac_nombre . '</option>';
                }
    break;







}
?>