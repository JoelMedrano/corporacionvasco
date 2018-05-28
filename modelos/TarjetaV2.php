
<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class TarjetaV2
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idarticulo,$idusuario,$fecha_creacion,$codpro,$cantidad)
	{
		$sql="INSERT INTO tb_tarjetaC (idarticulo,idusuario,fecha_creacion,estado)
		VALUES ('$idarticulo','$idusuario','$fecha_creacion','REVISAR')";
		//return ejecutarConsulta($sql);
		$idtarjetanew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;

		while ($num_elementos < count($codpro))
		{
			$sql_detalle = "INSERT INTO tb_tarjetaD(idtarjeta, codpro,cantidad) VALUES ('$idtarjetanew', '$codpro[$num_elementos]','$cantidad[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}
	

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
						a.art_est_tarjeta
						FROM tb_tarjetaC tc
						LEFT JOIN articulo1 a
						ON tc.idarticulo=a.idarticulo
						LEFT JOIN color c
						ON a.art_color=c.art_color
						LEFT JOIN usuario u
						ON tc.idusuario=u.idusuario
						where tc.estado='FALTA'";
		return ejecutarConsulta($sql);		
	}

	public function aprobar($idtarjeta){

		$sql="UPDATE tb_tarjetaC SET estado='APROBADA' WHERE idtarjeta='$idtarjeta'";
		return ejecutarConsulta($sql);				
	}

	public function revisar($idtarjeta){

		$sql="UPDATE tb_tarjetaC SET estado='REVISAR' WHERE idtarjeta='$idtarjeta'";
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
		
	public function mostrar($idtarjeta)
	{
		$sql="SELECT	tc.idtarjeta,
						DATE(tc.fecha_creacion) AS fecha,
						a.idarticulo,
						a.art_codigo,
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
						WHERE tc.idtarjeta='$idtarjeta'";

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
						FROM tb_tarjetad td
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



}	
?>
 