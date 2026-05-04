<?php
$path = realpath(dirname(__FILE__));
define("RelativePath", "../..");
include_once(RelativePath . "/Common.php");

$html = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
<style type="text/css">
body {
  color: #333333;
  font-family: helvetica;
}
</style>
</head>
<body><table border="0" cellpadding="12" width="100%"><tr><td>';

$html .= '<img style="width: 75%;" border="0" src="imagenes/header_rpt.jpg"/><br>';

if(CCGetParam('pieza_id')){
	require_once(RelativePath . "/dompdf/dompdf_config.inc.php");
	$db = new clsDBmesa();
	$SQL = "SELECT *,CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) as pieza,
			DATE_FORMAT(pieza_f_alta,'%Y-%m-%d') as pieza_f_alta
			FROM piezas 
			INNER JOIN tramites USING(tramite_id)
			WHERE pieza_id = " . CCGetParam('pieza_id');
	$db->query($SQL);
	
	if($db->next_record()){
		
		$file = $db->f('pieza_nro') . "_" . $db->f('pieza_anio') . ".pdf";
		$fecha = CCFormatDate(CCParseDate($db->f('pieza_f_alta'),array("yyyy", "-", "mm", "-", "dd",)), array("ShortDate"));
					
		//identificacion
		
		$html .= '<BR><table border="1" width="100%" cellpadding="0" cellspacing="1">';
		$html .= '<tr><td align="center">IDENTIFICACION DE LA PIEZA ADMINISTRATIVA</td></tr>';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= 'EXPEDIENTE NRO : <b>' . $db->f('pieza') . '</b><BR>';
		$html .= 'INICIADOR : ' . $db->f('pieza_iniciador') . '<BR>';
		$html .= 'FECHA DE INICIACION : ' . $fecha . '<BR>';
		$html .= '</td>';
		$html .= '<tr><td align="center">ASUNTO DE LA PIEZA ADMINISTRATIVA</td></tr>';
		$html .= '<tr>';
		$html .= '<td>';
		$html .= 'DESCRIPCION : ' . $db->f('pieza_descripcion') . '<BR>';
		$html .= 'TRAMITE : ' . $db->f('tramite_desc') . '<BR>';
		$html .= 'OBSERVACIONES : ' . $db->f('pieza_observaciones') . '<BR>';
		$html .= '</tr>';
		$html .= '</td>';
		$html .= '</table>';
		
		$html .= '</td></tr></table></body></html>'; 
		
		
		//a pdf
		$dompdf = new DOMPDF();
		$dompdf->set_paper('a4'); 
		$dompdf->set_base_path($path . "/" . RelativePath);

		$dompdf->load_html($html);
		$dompdf->render();
		$dompdf->stream($file,array("Attachment" => 0));
		
		$db->close();

	}
}

?>

