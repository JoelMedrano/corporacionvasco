<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";





Class Operacion
{

	//Implementamos nuestro constructor
	public function __construct()
	{

	}


	//Implementamos un método para insertar registros
	public function insertar($art_modelo, $CodOperacion, $DesOperacion, $PreDocena, $TpoStandar)
	{

		$num_elementos=0;
		$sw=true;
		$cod=0;
		$idope=0;
		$row=0;

		$sql=("SELECT  MAX(idoperacion)+1 AS  idope FROM operacion");
		
		$row=ejecutarConsultaSimpleFila($sql); 


		$idope=$row["idope"];




		while ($num_elementos < count($DesOperacion))
		{



			 $cod=$num_elementos +1 ;
			 //obtengop el largo del numero
			 $largo_numero = strlen($cod);
			 //especifico el largo maximo de la cadena
			 $largo_maximo = 2;
			 //tomo la cantidad de ceros a agregar
			 $agregar = $largo_maximo - $largo_numero;
			 //agrego los ceros
			 for($i =0; $i<$agregar; $i++){
			 $cod = "0".$cod;
			 }

			 
			 $CodOpe = $art_modelo.$cod;



			$sql="INSERT INTO operacion(idoperacion, art_modelo, CodOperacion , DesOperacion, PreDocena, TpoStandar)
			VALUES ('$idope', '$art_modelo', '$CodOpe',  '$DesOperacion[$num_elementos]',  '$PreDocena[$num_elementos]','$TpoStandar[$num_elementos]' )";
			ejecutarConsulta($sql) or $sw = false;
			$num_elementos=$num_elementos + 1;


		}

		return $sw;


	}

	//Implementamos un método para editar registros
	public function editar($art_modelo, $idoperacion)
	{
		$sql="UPDATE operacion SET DesOperacion='$art_modelo',PreDocena='$art_modelo',TpoStandar='$art_modelo' WHERE CodOperacion='$CodOperacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}


	//Implementamos un método para activar registros
	public function activar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idoperacion)
	{
		$sql="SELECT * FROM operacion 
		WHERE idoperacion='$idoperacion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT DISTINCT o.idoperacion, a.art_nombre, a.art_modelo, a.art_estado	 FROM articulo1 a, operacion o where a.art_modelo= o.art_modelo group by o.art_modelo ";
		return ejecutarConsulta($sql);		
	}

	public function listarDetalle($idoperacion)
	{
		$sql="SELECT idoperacion, CodOperacion, DesOperacion, PreDocena, TpoStandar FROM operacion WHERE idoperacion='$idoperacion'";
		return ejecutarConsulta($sql);
	}




}

?>