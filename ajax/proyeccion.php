<?php 
if (strlen(session_id()) < 1) 
  session_start();
require_once "../modelos/Proyeccion.php";

$proyeccion=new Proyeccion();

$mes=isset($_POST["mes"])? limpiarCadena($_POST["mes"]):"";

switch ($_GET["op"]){

    case 'listar':
        $rspta=$proyeccion->listar();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(

                "0"=>$reg->codpro,
                "1"=>$reg->linea,
                "2"=>$reg->codfab,
                "3"=>$reg->despro,
                "4"=>$reg->des_larga,
                "5"=>$reg->medida,
                "6"=>$reg->moneda,
                "7"=>$reg->prepro,
                "8"=>$reg->presol,
                "9"=>$reg->proy
                

               );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;

    case 'listarmes':
        $rspta=$proyeccion->listarmes();
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(

                "0"=>$reg->nommes,
                "1"=>($reg->estado=='1')?'<span class="label bg-green">Activo</span>':
                '<span class="label bg-red">Desactivado</span>', 
                "2"=>(($reg->estado=='0')?' <button class="btn btn-success" onclick="activar('.$reg->mes.')"><i class="fa fa-check"></i></button>':' <button class="btn btn-danger" onclick="desactivar('.$reg->mes.')"><i class="fa fa-close"></i></button>')               
               );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

    break;

    case 'activar':
        $rspta=$proyeccion->activar($mes);
        echo $rspta ? "Mes activado" : "Mes no se puede activar";
        break;
    break;

    case 'desactivar':
        $rspta=$proyeccion->desactivar($mes);
        echo $rspta ? "Mes Desactivado" : "Mes no se puede desactivar";
        break;
    break;



   

}
?>