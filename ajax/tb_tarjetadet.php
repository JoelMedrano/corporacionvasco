<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Tb_TarjetaDet.php";

$tb_tarjetadet=new Tb_TarjetaDet();

$idtarjeta=isset($_POST["idtarjeta"])? limpiarCadena($_POST["idtarjeta"]):"";
$iddetalle_tarjeta=isset($_POST["iddetalle_tarjeta"])? limpiarCadena($_POST["iddetalle_tarjeta"]):"";
$idarticulo=isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]):"";
$idtarjeta=isset($_POST["idtarjeta"])? limpiarCadena($_POST["idtarjeta"]):"";
$art_codigo=isset($_POST["art_codigo"])? limpiarCadena($_POST["art_codigo"]):"";
$codpro=isset($_POST["codpro"])? limpiarCadena($_POST["codpro"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($iddetalle_tarjeta)){
			$rspta=$tb_tarjetadet->insertar($idtarjeta,$codpro,$cantidad);
			echo $rspta ? "Item registrada" : "No se pudieron registrar todos los datos del Item";
		}
		else {
			$rspta=$tb_tarjetadet->editar($iddetalle_tarjeta,$idtarjeta,$codpro,$cantidad);
			echo $rspta ? "MP actualizada" : "MP no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$tb_tarjetadet->eliminar($iddetalle_tarjeta);
 		echo $rspta ? "Item eliminado" : "Item no se puede eliminar";
	break;

	case 'mostrar':
		$rspta=$tb_tarjetadet->mostrar($iddetalle_tarjeta);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$tb_tarjetadet->listar();
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
				"11"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->iddetalle_tarjeta.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="eliminar('.$reg->iddetalle_tarjeta.')"><i class="fa fa-trash"></i></button>',                

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
				echo '<option value=' . $reg->idtarjeta . '>' . $reg->art. '</option>';
				}
	break;
	

	case 'listarMP':

		require_once "../modelos/MateriaPrima.php";
		$materiaprima = new MateriaPrima();

		$rspta = $materiaprima->listarMP();

		while ($reg = $rspta->fetch_object())
				{
				echo '<option value=' . $reg->codpro .'>' . $reg->mp . '</option>';
				}
	break;




}
?>