
<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Proyeccion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	public function listar()
	{
		$sql="SELECT	mp.codpro,
						td2.des_larga AS linea,
						mp.codfab,
						mp.despro,
						td.des_larga,
						mp.undpro,
						td1.des_larga AS medida,
						(CASE WHEN mp.mo='1' THEN 'S/' ELSE 'U$' END) AS moneda,
						mp.mo,
						mp.prepro,
						(CASE WHEN mp.mo='2' THEN mp.prepro*3.245 ELSE mp.prepro END) AS presol,
						IFNULL(proy,0) AS proy,
						(IFNULL(proy,0)*(CASE WHEN mp.mo='2' THEN mp.prepro*3.245 ELSE mp.prepro END)) AS total
						FROM materia_prima mp
						LEFT JOIN tabla_m_detalle td
						ON mp.colpro=td.cod_argumento
						LEFT JOIN tabla_m_detalle td1
						ON mp.undpro=td1.cod_argumento
						LEFT JOIN tabla_m_detalle td2
						ON  LEFT(mp.CodFab,3) = td2.Des_Corta
						LEFT JOIN
						(SELECT
						td.codpro,
						SUM(cantidad*cant) AS proy 
						FROM tb_tarjetadet td
						LEFT JOIN tb_tarjetacab tc
						ON td.idtarjeta=tc.idtarjeta
						LEFT JOIN
						(SELECT
						a.idarticulo,
						IFNULL(cant,0) AS cant 
						FROM articulo1 a
						LEFT JOIN
						(SELECT
						art_codigo,
						SUM(cantidad) AS cant 
						FROM proyeccion
						WHERE estado='1'
						GROUP BY art_codigo) AS p
						ON a.art_codigo=p.art_codigo) AS p
						ON tc.idarticulo=p.idarticulo
						WHERE cant>0
						GROUP BY td.codpro) AS p
						ON mp.codpro=p.codpro
						WHERE td.Cod_Tabla = 'TCOL'
						AND td1.cod_tabla='TUND'
						AND td2.cod_tabla='TLIN' AND proy>0
						ORDER BY mp.despro";

		return ejecutarConsulta($sql);		
	}



	public function listarmes()
	{
		$sql="SELECT 
						mes,
						CASE 
						WHEN mes='1' THEN '1 - ENERO'
						WHEN mes='2' THEN '2 - FEBRERO'
						WHEN mes='3' THEN '3 - MARZO'
						WHEN mes='4' THEN '4 - ABRIL'
						WHEN mes='5' THEN '5 - MAYO'
						WHEN mes='6' THEN '6 - JUNIO'
						WHEN mes='7' THEN '7 - JULIO'
						WHEN mes='8' THEN '8 - AGOSTO'
						WHEN mes='9' THEN '9 - SEPTIEMBRE'
						WHEN mes='10' THEN '10 - OCTUBRE'
						WHEN mes='11' THEN '11 - NOVIEMBRE'
						ELSE '12 - DICIEMBRE' END AS nommes, 
						estado
						FROM proyeccion
						GROUP BY mes
						ORDER BY mes";
						
		return ejecutarConsulta($sql);						
	}

	public function activar($mes){

		$sql="UPDATE proyeccion SET estado=1 WHERE mes='$mes'";
		return ejecutarConsulta($sql);				
	}	

	public function desactivar($mes){

		$sql="UPDATE proyeccion SET estado=0 WHERE mes='$mes'";

		return ejecutarConsulta($sql);				
	}	

}	
?>
 