<?php 
require_once "../modelos/TarjetaV.php";

$tarjetav=new TarjetaV();

$art_codigo=isset($_POST["art_codigo"])? limpiarCadena($_POST["art_codigo"]):"";
$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";


switch ($_GET["op"]){
    case 'guardaryeditar':

        
        if (empty($idtarjetav)){
            $rspta=$tarjetav->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo $rspta ? "Artículo registrado" : "Artículo no se pudo registrar";
        }
        else {
            $rspta=$tarjetav->editar($idtarjetav,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
            echo $rspta ? "Artículo actualizado" : "Artículo no se pudo actualizar";
        }
    break;

    case 'desactivar':
        $rspta=$tarjetav->desactivar($art_codigo);
        echo $rspta ? "Detalle Desactivado" : "Detalle no se puede desactivar";
    break;

    case 'activar':
        $rspta=$tarjetav->activar($art_codigo);
        echo $rspta ? "Detalle activado" : "Detalle no se puedo activar";
    break;

    case 'mostrar':
        $rspta=$tarjetav->mostrar($idarticulo);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta=$tarjetav->listar();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(

                
                "0"=>$reg->art_codigo,    
                "1"=>$reg->art_marca,
                "2"=>$reg->art_nombre,
                "3"=>$reg->col_nombre,
                "4"=>$reg->art_nom_talla,
                "5"=>($reg->art_estado=='ACTIVO')?('<span class="label bg-blue">ACTIVO</span>'):(($reg->art_estado=='DESCONTINUADO')?('<span class="label bg-red">DESCONTINUADO</span>'):('<span class="label bg-yellow">CAMPAÑA</span>')),             
                "6"=>$reg->art_caracteristica,
                "7"=>($reg->art_est_tarjeta)?'<span class="label bg-green">EDITABLE</span>':
                '<span class="label bg-red">Desactivado</span>',
                "8"=>($reg->art_est_tarjeta)?'<button type="button" class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-success" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>',                



               );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;

    case 'listarDetalle':
        //Recibimos el idingreso
        $id=$_GET['id'];

        $rspta = $tarjetav->listarDetalle($id);
        $total=0;
        echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Cod. Producto</th>
                                    <th>Cod. Fabrica</th>
                                    <th>Descripcion</th>
                                    <th>Detalle</th>
                                    <th>Consumo</th>
                                    <th>Unidad</th>
                                    <th>Moneda</th>
                                    <th>Precio Proveedor</th>
                                    <th>Precio S/</th>
                                    <th>Subtotal S/</th>
                                </thead>';

        while ($reg = $rspta->fetch_object())
                {
                    echo '<tr class="filas"><td></td><td>'.$reg->codpro.'</td><td>'.$reg->codfab.'</td><td>'.$reg->despro.'</td><td>'.$reg->des_larga.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->undpro.'</td><td>'.$reg->mo.'</td><td>'.$reg->prepro.'</td><td>'.$reg->presol.'</td><td>'.$reg->pretot.'</td></tr>';
                    $total=$total+($reg->presol*$reg->cantidad);
                }
        echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><b><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="pretot" id="pretot"></b></th> 
                                </tfoot>';
    break;



}
?>