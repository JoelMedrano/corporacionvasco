
<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";



Class ArticuloV
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($newart_codigo,$art_modelo,$art_color,$art_talla,$art_marca, $art_nombre, $art_unidad, $art_caracteristica, $art_stock_min,  $art_stock_max )
	{
		
		$num_elementos=0;
		$sw=true;

		$fechaactual = getdate();
        $art_fecha_creacion="$fechaactual[year]-$fechaactual[mon]-$fechaactual[mday]";


		while ($num_elementos < count($newart_codigo))
		{


			
			$codigo_talla = substr($art_talla, 0, 1);  
			$des_talla = substr($art_talla, 1); 

			$sql_detalle = "INSERT INTO articulo1( art_codigo,art_modelo,art_color,art_talla, art_nom_talla,art_marca,art_nombre,art_unidad,art_caracteristica, art_cod_almacen, art_stock_min, art_stock_max, art_fecha_creacion, art_estado, art_tipo, art_vtas_web, art_dig_precios, art_list_pri, art_afec_dscto, art_afec_igv
				) VALUES ('$newart_codigo', '$art_modelo', '$art_color', '$codigo_talla', '$des_talla', '$art_marca', '$art_nombre', '$art_unidad', '$art_caracteristica', '01' ,  '$art_stock_min', '$art_stock_max', '$art_fecha_creacion', 'ACTIVO', 'F' , '1', '1' , '6' , '1', '1')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;


	}

	//Implementamos un método para editar registros
	public function editar( $idarticulo, $art_nombre, $art_stock_min,  $art_stock_max )
	{
		$sql="UPDATE articulo1 SET 	art_nombre='$art_nombre',
									art_stock_min='$art_stock_min',
									art_stock_max='$art_stock_max'
									WHERE idarticulo='$idarticulo'";

		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idarticulo)
	{
		$sql="UPDATE articulo1 SET art_estado='DESCONTINUADO' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idarticulo)
	{
		$sql="UPDATE articulo1 SET art_estado='ACTIVO' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{

		$sql=" SELECT DISTINCT a.idarticulo, a.art_codigo, a.art_modelo, a.art_color, a.art_talla, a.art_nom_talla, a.art_marca,
a.art_nombre, a.art_unidad, a.art_caracteristica, art_stock_min, art_stock_max, c.col_nombre, ta.nombre_talla AS Talla
FROM articulo1 a, color  c , caracteristica ca, talla ta
WHERE a.idarticulo='$idarticulo'
AND c.art_color=a.art_color
AND a.art_talla= ta.art_talla
AND a.art_caracteristica= ca.art_caracteristica
AND ca.carac_familia= ta.familia

";

		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT	a.idarticulo,
						a.art_codigo,
						a.art_marca,
						a.art_nombre,
						a.art_color,
						c.col_nombre,
						a.art_talla,
						a.art_nom_talla,
						a.art_caracteristica,
						a.art_estado
						FROM articulo1 a
						LEFT JOIN color c
						ON a.art_color=c.art_color
						";

		return ejecutarConsulta($sql);		
	}

		public function select()
	{
		$sql=" SELECT 
				   a.art_codigo,
				   a.art_nombre,
				   c.col_nombre,
				  a.art_nom_talla 
				 FROM
				 articulo1 AS a , Color c
				 where   c.art_color=  a.art_color 
 	    ";
		return ejecutarConsulta($sql);		
	}

	

	public function listarART()
	{
		$sql="SELECT	a.idarticulo,
						CONCAT(a.art_codigo,' - ',a.art_modelo,' - ',a.art_marca,' - ',a.art_nombre,' - ',c.col_nombre,' - ',a.art_nom_talla,' - ',a.art_estado) AS art
						FROM articulo1 a
						LEFT JOIN color c
						ON a.art_color=c.art_color
						WHERE art_est_tarjeta='1'";

		return ejecutarConsulta($sql);

	}


}

?>
 