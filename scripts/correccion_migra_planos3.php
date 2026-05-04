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
$plano = array();
$partida = array();
$i=0;
$j=0;
$k=0;
$cnx = mysql_connect('localhost', 'php_user', 'phpuser') or die ('Ha fallado la conexi&oacute;n: '.mysql_error());
mysql_select_db('catastro_tdf_viejo', $cnx) or die ('Error al seleccionar la Base de Datos: '.mysql_error());

$SQL="SELECT parcelas.*
		FROM parcelas
		WHERE NOT ISNULL(plano_id)
		ORDER BY parcela_id";

//parcelas ID con plano
$result = mysql_query($SQL,$cnx) or die('Consulta fallida: ' . mysql_error());
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
	if($row['parcela_id']){
		$parcelas[$i]=$row['parcela_id'];
		$plano[$i]=$row['plano_id'];
		$partida[$i]=$row['parcela_partida'];
		$i++;
	}
}

echo "cantidad parcelas con plano - viejo: ".count($parcelas)."<br>";

$i1=0;
$i2=0;
$cnx2 = mysql_connect('localhost', 'php_user', 'phpuser') or die ('Ha fallado la conexi&oacute;n: '.mysql_error());
mysql_select_db('catastro_tdf', $cnx2) or die ('Error al seleccionar la Base de Datos: '.mysql_error());
//parcelas con destino
for($j=0,$i=0;$j<count($parcelas);$j++){
	$SQL="SELECT COUNT(*) AS CANT
			FROM uniones_desgloses
			WHERE parcela_destino_id = ".$parcelas[$j];
	//echo $SQL."<br>";
	$result = mysql_query($SQL,$cnx2) or die('Consulta fallida: ' . mysql_error());
	if($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		if($row['CANT'] > 0){
			//echo "ESTA <br>";
			$u_d2[$i1++]=$parcelas[$j];
		}else{
			echo "INSERT uniones_desgloses (parcela_id,parcela_destino_id,tipo_union_desglose_id,union_desglose_fecha,usuario_id,partida_origen,partida_destino,audit_string,uniones_desgloses_observacion,plano_id) VALUES (NULL,".$parcelas[$j].",0,NOW(),24,0,".$partida[$j].",'24|192.168.62.100|correccion_migra_planos3.php','',".$plano[$j].");<br>";
			$u_d[$i2++]=$parcelas[$j];
		}
	}
}

echo "cantidad parcelas con plano sin U_D viejo: ".count($u_d)."<br>";
echo "cantidad parcelas con plano con U_D2 viejo: ".count($u_d2)."<br>";
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