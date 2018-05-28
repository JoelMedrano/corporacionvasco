<?php 
if (strlen(session_id()) < 1) 
  session_start();


require_once "../modelos/Operacion.php";

$operacion=new Operacion();

$art_modelo=isset($_POST["art_modelo"])? limpiarCadena($_POST["art_modelo"]):"";

$idoperacion=isset($_POST["idoperacion"])? limpiarCadena($_POST["idoperacion"]):"";




switch ($_GET["op"]){
	case 'guardaryeditar':

		
		if (empty($idoperacion)){
			$rspta=$operacion->insertar($art_modelo, $_POST["CodOperacion"], $_POST["DesOperacion"], $_POST["PreDocena"], $_POST["TpoStandar"]);
			echo $rspta ? "La operación registrado" : "La operación no se pudo registrar";
		}
		else {
			$rspta=$operacion->editar($idoperacion,$art_modelo);
			echo $rspta ? "La operación actualizado" : "La operación  no se pudo actualizar";
		}

	break;


	case 'desactivar':
		$rspta=$operacion->desactivar($idoperacion);
 		echo $rspta ? "Artículo Desactivado" : "Artículo no se puede desactivar";
	break;

	case 'activar':
		$rspta=$operacion->activar($idoperacion);
 		echo $rspta ? "Artículo activado" : "Artículo no se puede activar";
	break;

	case 'mostrar':
		$rspta=$operacion->mostrar($idoperacion);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

 		
	break;

	case 'listar':
		$rspta=$operacion->listar();
 		//Vamos a declarar un array

 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>($reg->art_estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idoperacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger" onclick="desactivar('.$reg->idoperacion.')"><i class="fa fa-close"></i></button>':
 					' <button class="btn btn-warning" onclick="mostrar('.$reg->idoperacion.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary" onclick="activar('.$reg->idoperacion.')"><i class="fa fa-check"></i></button>',
 				"1"=>$reg->art_modelo,
 				"2"=>$reg->art_nombre,
                "3"=>($reg->art_estado=='ACTIVO')?'<span class="label bg-green">Activado</span>':
 				'<span class="label bg-red">Desactivado</span>'
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

		$rspta = $operacion->listarDetalle($id);
		

		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Cod.Operacion</th>
                                    <th>Descripción</th>
                                    <th>Precio x Doc</th>
                                    <th>Tiempo Standar</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td> <input type="text" value="'.$reg->CodOperacion.'" ></td><td><input type="text" size="70px" value="'.$reg->DesOperacion.'" ></td><td><input type="text" value="'.$reg->PreDocena.'" ></td><td><input type="text" value="'.$reg->TpoStandar.'" ></td></tr>';
					
				}
		echo '<tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    
                                </tfoot>';
	break;



	case "selectModeloOperacion":
		require_once "../modelos/Consultas.php";
		$consultas = new Consultas();

		$rspta = $consultas->selectModeloOperacion();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->art_modelo . '>' . $reg->art_nombre . '</option>';
				}
	break;

}
?>