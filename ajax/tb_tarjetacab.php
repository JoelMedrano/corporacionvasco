<?php 
if (strlen(session_id()) < 1) 
  session_start();
require_once "../modelos/Tb_TarjetaCab.php";

$tb_tarjetacab=new Tb_TarjetaCab();

$idtarjeta=isset($_POST["idtarjeta"])? limpiarCadena($_POST["idtarjeta"]):"";
$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$art_codigo=isset($_POST["art_codigo"])? limpiarCadena($_POST["art_codigo"]):"";
$art_modelo=isset($_POST["art_modelo"])? limpiarCadena($_POST["art_modelo"]):"";
$art_nombre=isset($_POST["art_nombre"])? limpiarCadena($_POST["art_nombre"]):"";
$col_nombre=isset($_POST["col_nombre"])? limpiarCadena($_POST["col_nombre"]):"";
$art_nom_talla=isset($_POST["art_nom_talla"])? limpiarCadena($_POST["art_nom_talla"]):"";
$art_marca=isset($_POST["art_marca"])? limpiarCadena($_POST["art_marca"]):"";
$art_estado=isset($_POST["art_estado"])? limpiarCadena($_POST["art_estado"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$estado=isset($_POST["estado"])? limpiarCadena($_POST["estado"]):"";
$total=isset($_POST["total"])? limpiarCadena($_POST["total"]):"";
$fecha_creacion=isset($_POST["fecha_creacion"])? limpiarCadena($_POST["fecha_creacion"]):"";

$idusuario=$_SESSION["idusuario"];


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idtarjeta)){
			$rspta=$tb_tarjetacab->insertar($idarticulo,$idusuario,$fecha_creacion,$_POST["codpro"],$_POST["cantidad"]);
			echo $rspta ? "Tarjeta registrada" : "No se pudieron registrar todos los datos de la Tarjeta";
		}
		else {
		}
	break;

    case 'mostrar':
        $rspta=$tb_tarjetacab->mostrar($idtarjeta);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta=$tb_tarjetacab->listar();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(

                "0"=>$reg->art_codigo,
                "1"=>$reg->art_marca,
                "2"=>$reg->art_nombre,
                "3"=>$reg->col_nombre,
                "4"=>$reg->art_nom_talla,
                "5"=>($reg->art_estado=='ACTIVO')?('<span class="label bg-blue">A</span>'):(($reg->art_estado=='DESCONTINUADO')?('<span class="label bg-red">D</span>'):('<span class="label bg-yellow">C</span>')),              

                "6"=>($reg->estado=='APROBADA')?'<span class="label bg-blue">APROBADA</span>':'<span class="label bg-green">REVISAR</span>',                
               
                "7"=>($reg->estado=='REVISAR')?'<button class="btn btn-info" onclick="mostrar('.$reg->idtarjeta.')"><i class="fa fa-search"></i></button>'.
                    ' <button class="btn btn-primary" onclick="aprobar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>':
                    '<button class="btn btn-info" onclick="mostrar('.$reg->idtarjeta.')"><i class="fa fa-search"></i></button>'.
                    ' <button class="btn btn-success" onclick="revisar('.$reg->idarticulo.')"><i class="fa fa-mail-reply"></i></button>',
                "8"=>($reg->art_est_tarjeta)?'<span class="label bg-green">OK</span>':
                '<span class="label bg-red">NO</span>',
                "9"=>(($reg->art_est_tarjeta=='1')?' <button class="btn btn-danger" onclick="desactivarTarjeta('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':' <button class="btn btn-primary" onclick="editarTarjeta('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>')                 

               );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;


    case 'listarFaltantes':
        $rspta=$tb_tarjetacab->listarFaltantes();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(

                "0"=>$reg->art_codigo,
				"1"=>$reg->art_modelo,                 
                "2"=>$reg->art_marca,
                "3"=>$reg->art_nombre,
                "4"=>$reg->col_nombre,
                "5"=>$reg->art_nom_talla,
				"6"=>($reg->estado)?'<span class="label bg-red">FALTA</span>':
                '<span class="label bg-red">---</span>',
                "7"=>' <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i></button>'


               );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;

    case 'selectArticuloFaltante':
        require_once "../modelos/ArticuloV.php";
        $articulov = new ArticuloV();

        $rspta = $articulov->selectArticuloFaltante();

        echo '<option value=0>Seleccione...</option>'; 
        
        while ($reg = $rspta->fetch_object())
                {
                echo '<option value=' . $reg->idarticulo . '>' . $reg->articulo . '</option>';
                }
    break;


    case 'listarDetalle':
        //Recibimos el idingreso
        $id=$_GET['id'];

        $rspta = $tb_tarjetacab->listarDetalle($id);
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

	case 'listarMPTarjeta':
		require_once "../modelos/MateriaPrima.php";
		$materiaprima=new MateriaPrima();

		$rspta=$materiaprima->listarMPTarjeta();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>'<button class="btn btn-warning" onclick="agregarDetalle('.'\''.$reg->codpro.'\''.',\''.$reg->mp.'\',\''.$reg->prepro.'\',\''.$reg->presol.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>$reg->codpro,
 				"2"=>$reg->codfab,
 				"3"=>$reg->despro,
 				"4"=>$reg->des_larga,
 				"5"=>$reg->medida,
 				"6"=>$reg->moneda,
 				"7"=>$reg->prepro,
 				"8"=>$reg->presol
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

    case 'revisar':
        $rspta=$tb_tarjetacab->revisar($idtarjeta);
        echo $rspta ? "Tarjeta Para Revisar" : "Tarjeta no se puedo Cambiar";
    break;

    case 'aprobar':
        $rspta=$tb_tarjetacab->aprobar($idtarjeta);
        echo $rspta ? "Tarjeta Aprobada" : "Tarjeta no se pudo aprobar";
    break;

    case 'editarTarjeta':
        $rspta=$tb_tarjetacab->editarTarjeta($idarticulo);
        echo $rspta ? "Tarjeta Habilitada" : "Tarjeta Deshabilitada";
    break;

    case 'desactivarTarjeta':
        $rspta=$tb_tarjetacab->desactivarTarjeta($idarticulo);
        echo $rspta ? "Tarjeta Desactivada" : "Tarjeta no se pudo desactivar";
    break;

}
?>