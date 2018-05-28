
<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Tb_TarjetaCab
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

		//Implementamos un método para insertar registros
	public function insertar($idarticulo,$idusuario,$fecha_creacion,$codpro,$cantidad)
	{
		$sql="INSERT INTO tb_tarjetacab (idarticulo,idusuario,fecha_creacion,estado)
		VALUES ('$idarticulo','$idusuario','$fecha_creacion','REVISAR')";
		//return ejecutarConsulta($sql);
		$idtarjetanew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($codpro))
		{
			$sql_detalle = "INSERT INTO tb_tarjetadet(idtarjeta,codpro,cantidad) VALUES ('$idtarjetanew', '$codpro[$num_elementos]','$cantidad[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//lista para tarjetas faltantes
	public function listarFaltantes()
	{
		$sql="SELECT	a.idarticulo,
						a.art_codigo,
						a.art_modelo,
						a.art_marca,
						a.art_nombre,
						c.col_nombre,
						a.art_nom_talla,
						IFNULL(tc.estado,'FALTA') AS estado
						FROM articulo1 a
						LEFT JOIN tb_tarjetaCab tc
						ON a.idarticulo=tc.idarticulo
						LEFT JOIN color c
						ON a.art_color=c.art_color
						WHERE tc.estado IS NULL AND a.art_estado IN ('ACTIVO','CAMPAÑAD')";
		return ejecutarConsulta($sql);		
	}

	//lista para articulos que tienen tarjetas

	public function listar()
	{
		$sql="SELECT	tc.idtarjeta, 
						tc.idarticulo,
						UPPER(u.login) AS usuario,
						DATE(tc.fecha_creacion) AS fecha,
						tc.estado,
						a.art_codigo,
						a.art_modelo,
						a.art_marca,
						a.art_nombre,
						c.col_nombre,
						a.art_nom_talla,
						a.art_estado,
						a.art_est_tarjeta
						FROM tb_tarjetaCab tc
						LEFT JOIN articulo1 a
						ON tc.idarticulo=a.idarticulo
						LEFT JOIN color c
						ON a.art_color=c.art_color
						LEFT JOIN usuario u
						ON tc.idusuario=u.idusuario";

		return ejecutarConsulta($sql);		
	}	

	public function mostrar($idtarjeta)
	{
		$sql="SELECT 	td.idtarjeta,
						idarticulo,
						fecha,
						estado,
						art_codigo,
						art_modelo,
						col_nombre,
						art_nom_talla,
						art_marca,
						art_nombre,
						art_estado,
						idusuario,
						login,
							SUM(td.cantidad*(CASE WHEN mp.mo='2' THEN mp.prepro*3.245 ELSE mp.prepro END)) AS total
						FROM tb_tarjetaDet td
						LEFT JOIN materia_prima mp
						ON td.codpro=mp.codpro
						LEFT JOIN
							(SELECT
							tc.idtarjeta,
							a.idarticulo,
							DATE(tc.fecha_creacion) AS fecha,
							tc.estado,
							a.art_codigo,
							a.art_modelo,
							c.col_nombre,
							a.art_nom_talla,
							a.art_marca,
							a.art_nombre,
							a.art_estado,
							u.idusuario,
							u.login
							FROM tb_tarjetaCab tc
							LEFT JOIN articulo1 a
							ON tc.idarticulo=a.idarticulo
							LEFT JOIN color c
							ON a.art_color=c.art_color
							LEFT JOIN usuario u
							ON tc.idusuario=u.idusuario) AS det
						ON td.idtarjeta=det.idtarjeta
						WHERE td.idtarjeta='$idtarjeta'
						GROUP BY td.idtarjeta";

		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idtarjeta)
	{
		$sql="SELECT	td.idtarjeta,
						td.codpro,
						codfab,
						despro,
						des_larga,
						medida,
						td.cantidad,
						(CASE WHEN mp.mo='1' THEN 'S/' ELSE 'US$' END) AS moneda,
						prepro,
						(CASE WHEN mp.mo='2' THEN mp.prepro*3.245 ELSE mp.prepro END) AS presol,
						(cantidad*(CASE WHEN mp.mo='2' THEN mp.prepro*3.245 ELSE mp.prepro END)) AS subtotal
						FROM tb_tarjetadet td
						LEFT JOIN
						(SELECT 
						mp.codpro,
						mp.codfab,
						mp.despro,
						td.des_larga,
						mp.undpro,
						(SELECT td.des_larga FROM tabla_m_detalle td WHERE td.cod_tabla='TUND' AND mp.undpro=td.cod_argumento) AS medida,
						mp.mo,
						mp.prepro
						FROM materia_prima mp
						LEFT JOIN tabla_m_detalle td
						ON mp.colpro=td.cod_argumento
						WHERE td.cod_tabla='tcol') AS mp
						ON td.codpro=mp.codpro
						WHERE td.idtarjeta='$idtarjeta'
						ORDER BY td.codpro";

		return ejecutarConsulta($sql);
	}


	public function aprobar($idtarjeta){

		$sql="UPDATE tb_tarjetaCab SET estado='APROBADA' WHERE idtarjeta='$idtarjeta'";
		return ejecutarConsulta($sql);				
	}

	public function revisar($idtarjeta){

		$sql="UPDATE tb_tarjetaCab SET estado='REVISAR' WHERE idtarjeta='$idtarjeta'";
		return ejecutarConsulta($sql);				
	}	

	public function editarTarjeta($idarticulo){

		$sql="UPDATE articulo1 SET art_est_tarjeta='1' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);				
	}	

	public function desactivarTarjeta($idarticulo){

		$sql="UPDATE articulo1 SET art_est_tarjeta='0' WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);				
	}		


}	
?>
 