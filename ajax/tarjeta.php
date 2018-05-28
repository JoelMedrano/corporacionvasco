<?php 
if (strlen(session_id()) < 1) 
  session_start();


require_once "../modelos/tarjeta.php";

$tarjeta=new Tarjeta();

$art_codigo=isset($_POST["art_codigo"])? limpiarCadena($_POST["art_codigo"]):"";
$id_tarjeta=isset($_POST["id_tarjeta"])? limpiarCadena($_POST["id_tarjeta"]):"";

$cod_prueba="";
switch ($_GET["op"]){
    case 'guardaryeditar':
    //LDGP 31012018
        if (empty($id_tarjeta)){
            $rspta=$tarjeta->insertar($art_codigo,$_POST["mp_codigo"],$_POST["tar_consumo"]);
            echo $rspta ? "Tarjeta registrada" : "No se pudieron registrar todos los datos de la venta";
        }
        else  {

             $rspta=$tarjeta->editar($id_tarjeta,$art_codigo,$_POST["mp_codigo"],$_POST["tar_consumo"]);
            echo $rspta ? "Tarjeta actualizado" : "Artículo no se pudo actualizar";
       

        } 
    break;

    case 'desactivar':
        $rspta=$tarjeta->desactivar($id_tarjeta);
        echo $rspta ? "Tarjeta Desactivada" : "Tarjeta no se puede desactivar";
    break;

    case 'activar':
        $rspta=$tarjeta->activar($id_tarjeta);
        echo $rspta ? "Tarjeta activada" : "Tarjeta no se puede activar";
    break;

    case 'mostrar':
        $rspta=$tarjeta->mostrar(string $art_codigo);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'listar':
        $rspta=$tarjeta->listar();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->art_codigo.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->art_codigo.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->art_codigo.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->art_codigo.')"><i class="fa fa-check"></i></button>',
                "1"=>$reg->art_codigo,
                "2"=>$reg->art_nombre,
                "3"=>$reg->col_nombre,
                "4"=>$reg->Art_nom_talla,

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

        $cont=0;


        $rspta = $tarjeta->listarDetalle($id);
        $total=0;
        echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Cod.Producto</th>
                                    <th>Cod.Fabrica</th>
                                    <th>Descripcion</th>
                                    <th>Color</th>
                                    <th>Unidad</th>
                                    <th>Consumo</th>
                                </thead>';

        while ($reg = $rspta->fetch_object())
                {

                       

                    echo '<tr class="filas" id="fila'.$cont.'" ><td><button type="button" class="btn btn-danger"  onclick="eliminarDetalle('.$cont.')"  >X</button></td><td>  '.$reg->CodPro.'   </td><td>'.$reg->mp_codigo.'   </td><td>'.$reg->DesPro.'</td><td>'.$reg->Color.'</td><td>'.$reg->Unidad.'</td><td>   '.$reg->tar_consumo.'  </td></tr>';
                   
                }
        echo '<tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                  </tfoot>';
    break;




    case 'listarMateriaPrimaTarjeta':
        require_once "../modelos/MateriaPrima.php";
        $materiaprima=new MateriaPrima();

        $rspta=$materiaprima->listarActivosTarjeta();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-war ning" onclick="agregarDetalle('.$reg->CodPro.', \''.$reg->CodFab.'\', \''.$reg->DesPro.'\', \''.$reg->Color.'\',\''.$reg->Unidad.'\')"><span class="fa fa-plus"></span></button>',
                "1"=>$reg->CodPro,
                "2"=>$reg->CodFab,
                "3"=>$reg->DesPro,
                "4"=>$reg->Color,
                "5"=>$reg->Unidad
                
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
    break;



    //Listado de Articulos para asociar a la cabecera de Tarjeta
    case "selectArticulo":
        require_once "../modelos/ArticuloV.php";
        $articulov = new ArticuloV();
 
        $rspta = $articulov->select();
        echo '<option value=0>Seleccione...</option>'; 
        while ($reg = $rspta->fetch_object())
                {
                    echo '<option value=' . $reg->art_codigo . '>' . $reg->art_codigo . '  '. $reg->art_nombre .' '. $reg->col_nombre .'  '. $reg->art_nom_talla .'   </option>';
                }
    break;



}
?>