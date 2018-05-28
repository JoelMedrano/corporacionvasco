<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/detalle_tarjeta.php";

$detalle_tarjeta=new detalle_tarjeta();

$idtarjeta=isset($_POST["idtarjeta"])? limpiarCadena($_POST["idtarjeta"]):"";
$art_codigo=isset($_POST["art_codigo"])? limpiarCadena($_POST["art_codigo"]):"";
$codpro=isset($_POST["codpro"])? limpiarCadena($_POST["codpro"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idtarjeta)){
			$rspta=$detalle_tarjeta->insertar($art_codigo,$codpro,$cantidad);
			echo $rspta ? "Item registrada" : "No se pudieron registrar todos los datos del Item";
		}
		else {
			$rspta=$detalle_tarjeta->editar($idtarjeta,$art_codigo,$codpro,$cantidad);
			echo $rspta ? "MP actualizada" : "MP no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$detalle_tarjeta->eliminar($idtarjeta);
 		echo $rspta ? "Item eliminado" : "Item no se puede eliminar";
	break;

	case 'mostrar':
		$rspta=$detalle_tarjeta->mostrar($idtarjeta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$detalle_tarjeta->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(

 				"0"=>$reg->art_codigo,
 				"1"=>$reg->art_nombre,
 				"2"=>$reg->col_nombre,
 				"3"=>$reg->art_nom_talla, 				
 				"4"=>$reg->codpro,
 				"5"=>$reg->codfab,
 				"6"=>$reg->despro,
 				"7"=>$reg->des_larga,
 				"8"=>$reg->cantidad,
 				"9"=>$reg->medida,
 				"10"=>$reg->prepro,
                "11"=>($reg->art_est_tarjeta)?'<span class="label bg-green">EDITABLE</span>':
                '<span class="label bg-red">Desactivado</span>',
				"12"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idtarjeta.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->idtarjeta.')"><i class="fa fa-trash"></i></button>',                

 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarART':
		require_once "../modelos/articuloV.php";
		$articuloV = new ArticuloV();

		$rspta = $articuloV->listarART();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->art_codigo . '>' . $reg->art. '</option>';
				}
	break;
	

	case 'listarMP':

		require_once "../modelos/MateriaPrima.php";
		$materiaprima = new MateriaPrima();

		$rspta = $materiaprima->listarMP();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->codpro . '>' . $reg->mp. '</option>';
				}
	break;




}
?>