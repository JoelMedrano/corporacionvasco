
<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TarjetaV
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function listar()
	{
		$sql="SELECT	a.idarticulo,	
						a.art_codigo,
						a.art_marca,
						a.art_nombre,
						a.art_color,
						c.col_nombre,
						a.art_nom_talla,
						a.art_estado,
						a.art_caracteristica,
						a.art_est_tarjeta
						FROM articulo1 a
						LEFT JOIN color c
						ON a.art_color=c.art_color";
		return ejecutarConsulta($sql);		
	}

	public function activar($idarticulo){

		$sql="UPDATE articulo1 SET art_est_tarjeta=1 WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);				
	}

	public function desactivar($idarticulo){

		$sql="UPDATE articulo1 SET art_est_tarjeta=0 WHERE idarticulo='$idarticulo'";
		return ejecutarConsulta($sql);				
	}

	public function mostrar($idtarjeta)
	{
		$sql="SELECT	tc.idtarjeta,
						DATE(tc.fecha_creacion) AS fecha,
						a.idarticulo,
						tc.idusuario,
						UPPER(u.login) AS usuario,
						tc.estado
						FROM tb_tarjetaC tc
						LEFT JOIN articulo1 a
						ON tc.idarticulo=a.idarticulo
						LEFT JOIN color c
						ON a.art_color=c.art_color
						LEFT JOIN usuario u
						ON tc.idusuario=u.idusuario
						WHERE tc.idtarjeta='1'";

		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idarticulo)
	{
		$sql="SELECT		t.idtarjeta,
							a.idarticulo,
							t.art_codigo,
							t.codpro,
							mp.codfab,
							mp.despro,
							td.des_larga,
							t.cantidad,
							mp.undpro,
							mp.mo,
							mp.prepro,
							CASE WHEN mp.mo='2' THEN mp.prepro*3.245 ELSE mp.prepro END AS presol,
							(cantidad*(CASE WHEN mp.mo='2' THEN mp.prepro*3.245 ELSE mp.prepro END)) AS pretot
							FROM tb_tarjeta t
							LEFT JOIN articulo1 a
							ON t.art_codigo=a.art_codigo
							LEFT JOIN  materia_prima mp
							ON t.codpro=mp.codpro
							LEFT JOIN tabla_m_detalle td
							ON mp.colpro=td.cod_argumento
							WHERE td.cod_tabla='tcol' AND a.idarticulo='$idarticulo'
							ORDER BY t.codpro";

		return ejecutarConsulta($sql);
	}			

}	
?>
 