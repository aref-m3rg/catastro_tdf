<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$db3 = new clsDBtdf_nuevo();
$db4 = new clsDBtdf_nuevo();
$db5 = new clsDBcatastro();

$SQL="SELECT * FROM viejo_nuevo WHERE Referencia LIKE '%2011'";
$db->query($SQL);

$parcelas = array();
$planos = array();
$i=0;

while($db->next_record()){
	$Partida = $db->f('Partida');
	$Seccion = $db->f('Seccion');
	$Quinta = $db->f('Quinta');
	$Macizo = $db->f('Macizo');
	$Parcela = $db->f('Parcela');
	$UF = $db->f('UF');
	
	$SQL2="SELECT * 
			FROM parcelas 
			INNER JOIN uniones_desgloses ON parcelas.parcela_id = uniones_desgloses.parcela_destino_id
			WHERE parcela_partida = '$Partida' 
			AND parcela_seccion = '$Seccion' 
			AND parcela_quinta = '$Quinta' 
			AND parcela_macizo = '$Macizo' 
			AND parcela_parcela = '$Parcela' 
			AND parcela_uf = '$UF'
			AND ISNULL(plano_id)";
	$db2->query($SQL2);
	
	//echo "$SQL<br>";
	
	while($db2->next_record()){
		//echo "esta: ".$db2->f('parcela_destino_id')."<br>";
		$parcelas[$i++]=$db2->f('parcela_destino_id');
	}
}

//conexion a base vieja
$cnx = mysql_connect('localhost', 'php_user', 'phpuser') or die ('Ha fallado la conexi&oacute;n: '.mysql_error());
mysql_select_db('catastro_tdf_viejo', $cnx) or die ('Error al seleccionar la Base de Datos: '.mysql_error());
for($j=0;$j<count($parcelas);$j++){
	$SQL5 = "SELECT * FROM parcelas WHERE parcela_id = '".$parcelas[$j]."' AND NOT ISNULL(plano_id);";
	//echo "$SQL5<br>";

	$result = mysql_query($SQL5,$cnx) or die('Consulta fallida: ' . mysql_error());
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		//echo "parcela_id: ".$row['parcela_id']." plano_id: ".$row['plano_id']."<br>";
		echo "UPDATE uniones_desgloses SET plano_id = ".$row['plano_id']." WHERE parcela_destino_id = ".$row['parcela_id']." AND ISNULL(plano_id);<br>"; 
	}
}
/*
$cnx = mysql_connect('localhost', 'php_user', 'phpuser') or die ('Ha fallado la conexi&oacute;n: '.mysql_error());
mysql_select_db('catastro_tdf_nuevo', $cnx) or die ('Error al seleccionar la Base de Datos: '.mysql_error());
for($j=0;$j<count($parcelas);$j++){
	$SQL = "SELECT * FROM parcelas WHERE parcela_id = '".$parcelas[$j]."';";
	echo $SQL."<br>";
	$result = mysql_query($SQL,$cnx) or die('Consulta fallida: ' . mysql_error());
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
		//echo "Depto: ".$row['tipo_depto_parc_id']." padron: ".$row['parcela_padron']."<br>";
	}
}
*/
$db->close();
$db2->close();
$db3->close();
$db4->close();
$db5->close();
?>