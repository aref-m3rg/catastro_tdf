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

$html .= '<img style="width: 75%;" border="0" src="imagenes/header_rpt_2_org.jpg"/>';

if(CCGetParam('pieza_id')){
	require_once(RelativePath . "/dompdf/dompdf_config.inc.php");
	$db = new clsDBmesa();
	$SQL = "SELECT *,CONCAT_WS('-',pieza_nro,pieza_letra,pieza_anio) as pieza,
			DATE_FORMAT(pieza_f_alta,'%Y-%m-%d') as pieza_f_alta
			FROM piezas WHERE pieza_id = " . CCGetParam('pieza_id');
	$db->query($SQL);
	if($db->next_record()){
		if($db->f('pieza_txt')){
			$file = $db->f('pieza_nro') . "_" . $db->f('pieza_anio') . ".pdf";
			$fecha = CCFormatDate(CCParseDate($db->f('pieza_f_alta'),array("yyyy", "-", "mm", "-", "dd",)), array("LongDate"));
						
			//numeracion y asunto
			$html .= '<div style="text-align: right;font-size: 18px">';
			$html .= '<strong>Nota: ' . $db->f('pieza') . '</strong><br>';
			$html .= '</div>';
			
			//fecha
			$html .= '<div style="text-align: right;"><strong>' . ucfirst($fecha) . '</strong></div>';
			
			//destinatario
			$html .= '<div style="text-align: left;"><strong>';
			$html .= 'A: ' . $db->f('pieza_destinatario') . '<br>';
			$html .= $db->f('pieza_of_destinatario') . '<br>';
			$html .= 'Asunto: ' . $db->f('pieza_descripcion');
			if($db->f('pieza_ref')){$html .= '<br>Ref.: ' . $db->f('pieza_ref');}
			$html .= '</strong><br><br></div>';
				
			
			//cuerpo
			$html .= '<table border="0" cellpadding="10" width="100%"><tr><td>';
			$html .=  $db->f('pieza_txt');
			$html .= '</td></tr></table>';
			
			//cerramos tabla principal t body
			$html .= '</td></tr></table></body></html>'; 
			
			//a pdf
			$dompdf = new DOMPDF();
			$dompdf->set_paper('a4'); 
			$dompdf->set_base_path($path . "/" . RelativePath);

			$dompdf->load_html($html);
			$dompdf->render();
			$dompdf->stream($file,array("Attachment" => 0));

		}
		
		$db->close();

	}
}
//echo $html;
?>

