<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$db3 = new clsDBcatastro();

$parcelas = array();
$u_d = array();
$u_d2 = array();
$planos = array();
$i=0;
$j=0;
$k=0;
$cnx = mysql_connect('localhost', 'php_user', 'phpuser') or die ('Ha fallado la conexi&oacute;n: '.mysql_error());
mysql_select_db('catastro_tdf', $cnx) or die ('Error al seleccionar la Base de Datos: '.mysql_error());

$SQL="SELECT * FROM uniones_desgloses WHERE ISNULL(plano_id) GROUP BY parcela_destino_id";

//parcelas ID con plano
$result = mysql_query($SQL,$cnx) or die('Consulta fallida: ' . mysql_error());
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
	if($row['parcela_destino_id']){
		$u_d[$i++]=$row['parcela_destino_id'];
	}
}

echo "cantidad parcelas sin plano U_D - nuevo: ".count($u_d)."<br>";

$cnx2 = mysql_connect('localhost', 'php_user', 'phpuser') or die ('Ha fallado la conexi&oacute;n: '.mysql_error());
mysql_select_db('catastro_tdf_viejo', $cnx2) or die ('Error al seleccionar la Base de Datos: '.mysql_error());
//parcelas con destino
for($j=0,$i=0;$j<count($u_d);$j++){
	$SQL="SELECT *
			FROM parcelas
			WHERE parcela_id = ".$u_d[$j]." AND NOT ISNULL(plano_id)";
	echo $SQL."<br>";
	$result = mysql_query($SQL,$cnx) or die('Consulta fallida: ' . mysql_error());
	if($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		echo $row['parcela_id'];
	}
}

//echo "cantidad parcelas con plano sin U_D viejo: ".count($u_d)."<br>";
/*
$cnx2 = mysql_connect('localhost', 'php_user', 'phpuser') or die ('Ha fallado la conexi&oacute;n: '.mysql_error());
mysql_select_db('catastro_tdf_nuevo', $cnx) or die ('Error al seleccionar la Base de Datos: '.mysql_error());
//busca parcela destino sin plano en nueva base de datos

for($j=0,$i=0;$j<count($u_d);$j++){
	$SQL="SELECT *
			FROM uniones_desgloses
			WHERE parcela_destino_id = ".$u_d[$j]." AND ISNULL(uniones_desgloses.plano_id)";
	//echo $SQL."<br>";
	$result = mysql_query($SQL,$cnx2) or die('Consulta fallida: ' . mysql_error());
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		if($row['union_desglose_id'] && $row['parcela_destino_id']){
			$u_d2[$i++]=$row['parcela_destino_id'];
		}
	}
}

echo "cantidad U_D nuevo sin planos: ".count($u_d2)."<br>";

for($j=0;$j<count($u_d2);$j++){
	echo $u_d2[$j]."<br>";
}
*/
?>