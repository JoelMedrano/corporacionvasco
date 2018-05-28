
<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Tarjeta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($art_codigo,$mp_codigo,$tar_consumo)
	{





		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($mp_codigo))
		{
			$sql_detalle = "INSERT INTO tarjeta( art_codigo,mp_codigo,tar_consumo, estado) VALUES ('$art_codigo','$mp_codigo[$num_elementos]','$tar_consumo[$num_elementos]', '1')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;


	}

	//Implementamos un método para editar registros
	public function editar($id_tarjeta,$art_codigo,$mp_codigo,$tar_consumo)
	{
		$sql="UPDATE tarjeta SET 	mp_codigo='$mp_codigo',
									tar_consumo='$tar_consumo'
									WHERE art_codigo='$art_codigo'";

		return ejecutarConsulta($sql);
	}



	//Implementamos un método para desactivar categorías
	public function desactivar($id_tarjeta)
	{
		$sql="UPDATE tarjeta SET estado='0' WHERE id_tarjeta='$id_tarjeta'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id_tarjeta)
	{
		$sql="UPDATE tarjeta SET estado='1' WHERE id_tarjeta='$id_tarjeta'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar(string  $art_codigo)
	{
		$sql="SELECT  DISTINCT 
				  t.art_codigo,
				  a.art_nombre,
				  c.col_nombre,
				  a.Art_nom_talla,
				  t.estado,
				  MAX(t.id_tarjeta) as id_tarjeta
				FROM
				  tarjeta AS t,
				  articulo1 AS a,
				  color AS c 
				WHERE t.art_codigo = a.art_codigo 
				  AND c.art_color = a.art_color
				  AND t.art_codigo='$art_codigo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros en la pantalla principal

	public function listar()
	{
		$sql="SELECT a.art_nombre,   a.Art_nom_talla,
	c.col_nombre, a.art_codigo, 'ACTIVO' as estado
    FROM  articulo1 AS a,  color AS c 
   WHERE  c.art_color = a.art_color 
    ORDER BY art_codigo
    
     ";
		return ejecutarConsulta($sql);		
	}



	//Implementar un método para listar los registros activos


	public function listarActivos()
	{
		$sql="SELECT a.idarticulo,
					 a.idcategoria,
					 c.nombre as categoria,
					 a.codigo,
					 a.nombre,
					 a.stock,
					 a.descripcion,
					 a.imagen,
					 a.condicion
					 FROM articulo a 
					 INNER JOIN categoria c 
					 on a.idcategoria=c.idcategoria
					 WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosVenta()

	{
		$sql="SELECT 	a.idarticulo,
						a.idcategoria,
						c.nombre AS categoria,
						a.codigo,
						a.nombre,a.stock,
						(SELECT 
						precio_venta 
						FROM detalle_ingreso 
						WHERE idarticulo=a.idarticulo 
						ORDER BY iddetalle_ingreso 
						DESC LIMIT 0,1) AS precio_venta,
						a.descripcion,
						a.imagen,a.condicion 
						FROM articulo a 
						INNER JOIN categoria c 
						ON a.idcategoria=c.idcategoria 
						WHERE a.condicion='1'";

		return ejecutarConsulta($sql);		
	}

	//Trae los datos luego de eligiar que tarjeta se quiere visualizar
	public function listarDetalle($art_codigo)
	{
		$sql="SELECT distinct  t.art_codigo, mp.CodPro, t.mp_codigo, mp.DesPro,  mp.Unidad, mp.Color, t.tar_consumo
    FROM tarjeta t 
    LEFT JOIN 
    (SELECT mp.CodFab, tbund.Des_Corta AS Unidad, tbcol.Des_Larga AS Color, mp.DesPro, mp.CodPro
     FROM materia_prima mp
        LEFT JOIN Tabla_M_Detalle AS tbund
            ON  mp.UndPro = tbund.Cod_Argumento
        LEFT JOIN Tabla_M_Detalle AS tbcol 
            ON  mp.ColPro = tbcol.Cod_Argumento
         WHERE   (tbund.Cod_Tabla = 'TUND' OR tbund.Cod_Tabla IS NULL) 
                AND (tbcol.Cod_Tabla = 'TCOL' OR tbcol.Cod_Tabla IS NULL)
     )   mp ON  mp.CodFab=t.mp_codigo 
     WHERE   t.art_codigo='$art_codigo'";
		return ejecutarConsulta($sql);
	}


}

?>
 