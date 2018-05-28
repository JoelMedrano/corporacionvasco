<?php 
if (strlen(session_id()) < 1) 
  session_start();
require_once "../modelos/TarjetaV2.php";

$tarjetav=new TarjetaV2();

$idtarjeta=isset($_POST["idtarjeta"])? limpiarCadena($_POST["idtarjeta"]):"";
$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idusuario=$_SESSION["idusuario"];
$fecha_creacion=isset($_POST["fecha_creacion"])? limpiarCadena($_POST["fecha_creacion"]):"";

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

    case 'revisar':
        $rspta=$tarjetav->revisar($idtarjeta);
        echo $rspta ? "Tarjeta Para Revisar" : "Tarjeta no se puedo Cambiar";
    break;

    case 'aprobar':
        $rspta=$tarjetav->aprobar($idtarjeta);
        echo $rspta ? "Tarjeta Aprobada" : "Tarjeta no se pudo aprobar";
    break;


    case 'editarTarjeta':
        $rspta=$tarjetav->editarTarjeta($idarticulo);
        echo $rspta ? "Tarjeta Habilitada" : "Tarjeta Deshabilitada";
    break;

    case 'desactivarTarjeta':
        $rspta=$tarjetav->desactivarTarjeta($idarticulo);
        echo $rspta ? "Tarjeta Desactivada" : "Tarjeta no se pudo desactivar";
    break;    


    case 'mostrar':
        $rspta=$tarjetav->mostrar($idtarjeta);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta=$tarjetav->listar();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(

                "0"=>$reg->art_modelo,
                "1"=>$reg->art_codigo, 
                "2"=>$reg->art_marca,
                "3"=>$reg->art_nombre,
                "4"=>$reg->col_nombre,
                "5"=>$reg->art_nom_talla,
                "6"=>$reg->usuario,
                "7"=>$reg->fecha,
                /*"4"=>$reg->estado,*/
                "8"=>($reg->estado=='APROBADA')?('<span class="label bg-blue">APROBADA</span>'):(($reg->estado=='REVISAR')?('<span class="label bg-green">REVISAR</span>'):(($reg->estado=='FALTA')?('<span class="label bg-red">FALTA</span>'):('<span class="label bg-yellow">NO ES NECESARIO</span>'))),

                "9"=>(($reg->estado=='APROBADA')?'<button class="btn btn-warning" onclick="mostrar('.$reg->idtarjeta.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-success" onclick="revisar('.$reg->idtarjeta.')"><i class=" fa fa-exclamation-circle"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->idtarjeta.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="aprobar('.$reg->idtarjeta.')"><i class="fa fa-check"></i></button>'),

                "10"=>($reg->art_est_tarjeta)?'<span class="label bg-green">EDITABLE</span>':
                '<span class="label bg-red">Desactivado</span>',



                "11"=>(($reg->art_est_tarjeta=='1')?' <button class="btn btn-danger" onclick="desactivarTarjeta('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':' <button class="btn btn-primary" onclick="editarTarjeta('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>')


               );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;

    case 'selectArticulo':
        require_once "../modelos/ArticuloV.php";
        $articulov = new ArticuloV();

        $rspta = $articulov->selectArticulo();

        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idarticulo . '>' . $reg->articulo . '</option>';
                }
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
                                    <th>Und. Medida</th>
                                    <th>Consumo</th>
                                    <th>Moneda</th>
                                    <th>Precio</th>
                                    <th>Precio S/</th>
                                    <th>Subtotal</th>
                                </thead>';

        while ($reg = $rspta->fetch_object())
                {
                    echo '<tr class="filas"><td></td><td>'.$reg->codpro.'</td><td>'.$reg->codfab.'</td><td>'.$reg->despro.'</td><td>'.$reg->des_larga.'</td><td>'.$reg->medida.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->moneda.'</td><td>'.$reg->prepro.'</td><td>'.$reg->presol.'</td><td>'.$reg->subtotal.'</td></tr>';
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