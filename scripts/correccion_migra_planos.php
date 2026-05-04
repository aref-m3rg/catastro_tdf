<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$db3 = new clsDBcatastro();
$i=0;
$parcelas = array();
$SQL="SELECT parcela_destino_id
	FROM uniones_desgloses
	WHERE ISNULL(plano_id)
	GROUP BY parcela_destino_id;";
$db->query($SQL);

while($db->next_record()){
	//echo "-> parcela_destino_id: ".$db->f('parcela_destino_id')." partida: ".$db->f('parcela_partida')." Depto: ".$db->f('Depto')." parcela_seccion: ".$db->f('parcela_seccion')." parcela_macizo: ".$db->f('parcela_macizo')." parcela_parcela: ".$db->f('parcela_parcela')."  parcela_uf: ".$db->f('parcela_uf')." <br>";
	$parcela_id = $db->f('parcela_destino_id');
	$SQL="SELECT * FROM afectaciones WHERE parcela_id = $parcela_id";
	$db2->query($SQL);
	//echo "$SQL<br>";
	if($db2->next_record()){
		echo "afectacioes - esta: ".$db2->f('parcela_id')."<br>";
	}
	$SQL="SELECT * FROM parcelas WHERE parcela_id = $parcela_id";
	$db2->query($SQL);
	echo "$SQL<br>";
	if($db2->next_record()){
		//echo "parcelas - esta: ".$db2->f('parcela_id')."<br>";
		$parcelas[$i++] = $db2->f('parcela_id');
	}	
}

//echo $i;
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

$db->close();
?>