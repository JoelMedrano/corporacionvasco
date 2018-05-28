
<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class MateriaPrima
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
	{
		$sql="INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,imagen,condicion)
		VALUES ('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
	{
		$sql="UPDATE articulo SET 	idcategoria='$idcategoria',
									codigo='$codigo',
									nombre='$nombre',
									stock='$stock',
									descripcion='$descripcion',
									imagen='$imagen'
									WHERE idarticulo='$idarticulo'";

		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idarticulo)
	{
		$sql="UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idarticulo)
	{
		$sql="SELECT * FROM articulo WHERE idarticulo='$idarticulo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
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
					 on a.idcategoria=c.idcategoria";
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
	public function listarActivosTarjeta()

	{
		$sql="SELECT CodPro, CodFab, DesPro, 
        IFNULL(tbund.Des_Corta,'')AS Unidad,
        IFNULL(tbcol.Des_Larga,'') AS Color
    FROM materia_prima mp
        LEFT JOIN Tabla_M_Detalle AS tbund
            ON tbund.Cod_Argumento   =  mp.UndPro
        LEFT JOIN Tabla_M_Detalle AS tbcol 
            ON   tbcol.Cod_Argumento = mp.ColPro 
    WHERE   (tbund.Cod_Tabla = 'TUND' OR tbund.Cod_Tabla IS NULL) 
    AND  (tbcol.Cod_Tabla = 'TCOL' OR tbcol.Cod_Tabla IS NULL) 
    ";

		return ejecutarConsulta($sql);		
	}
	

	public function listarMP(){

		$sql="SELECT 	mp.codpro,
						CONCAT(mp.codpro,' - ',mp.codfab,' - ',mp.despro,' - ',td.des_larga,' - ',(SELECT td.des_larga FROM tabla_m_detalle td WHERE td.cod_tabla='TUND' AND mp.undpro=td.cod_argumento)) AS mp
						FROM materia_prima mp
						LEFT JOIN tabla_m_detalle td
						ON mp.colpro=td.cod_argumento
						WHERE td.cod_tabla='tcol'";

		return ejecutarConsulta($sql);

	}



	public function listarMPTarjeta()
	{
		$sql="SELECT 	mp.codpro,
						mp.codfab,
						mp.despro,
						CONCAT(codfab,' - ',despro,' - ',des_larga,' - ',(SELECT td.des_larga FROM tabla_m_detalle td WHERE td.cod_tabla='TUND' AND mp.undpro=td.cod_argumento),' - ',(CASE WHEN mp.mo='1' THEN 'S/' ELSE 'US$' END)) AS mp,
						td.des_larga,
						(SELECT td.des_larga FROM tabla_m_detalle td WHERE td.cod_tabla='TUND' AND mp.undpro=td.cod_argumento) AS medida,
						(CASE WHEN mp.mo='1' THEN 'S/' ELSE 'US$' END) AS moneda,
						mp.prepro,
						(CASE WHEN mp.mo='2' THEN mp.prepro*3.245 ELSE mp.prepro END) AS presol
						FROM materia_prima mp
						LEFT JOIN tabla_m_detalle td
						ON mp.colpro=td.cod_argumento
						WHERE td.cod_tabla='tcol'";

		return ejecutarConsulta($sql);							
	}
	





}

?>
 