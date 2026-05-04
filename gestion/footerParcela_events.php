<?php

// //Events @1-F81417CB

//DEL  // -------------------------
//DEL  	$page = CCGetParam(page);
//DEL  	$folder = CCGetParam(folder);
//DEL  	$qs = CCGetQueryString("QueryString", array('folder','page','ccsForm','parcela_id','mejora_id','add'));
//DEL  	$lnk = RelativePath . "/$folder/$page" . ".php?$qs";
//DEL  	$Component->SetLink($lnk);
//DEL  // -------------------------

//footerParcela_opciones_lnk_edit_BeforeShow @10-3616812A
function footerParcela_opciones_lnk_edit_BeforeShow(& $sender)
{
    $footerParcela_opciones_lnk_edit_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $footerParcela; //Compatibility
//End footerParcela_opciones_lnk_edit_BeforeShow

//Custom Code @11-2A29BDB7
// -------------------------

  // Write your own code here.
	$no = array('ccsForm','mejora_id','add',
				'persona_id','personas','direcciones',
				'direccion_id','persona_parcela_id','tipo',
				'personas_personas_parcelaPage',
				'mejoras_tipos_mejoras_tipPage');

	$qs = CCGetQueryString("QueryString", $no);
	$lnk = RelativePath . "/gestion/recordParcela" . ".php?$qs";
	$Component->SetLink($lnk);

// -------------------------
//End Custom Code

//Close footerParcela_opciones_lnk_edit_BeforeShow @10-901799E8
    return $footerParcela_opciones_lnk_edit_BeforeShow;
}
//End Close footerParcela_opciones_lnk_edit_BeforeShow

//footerParcela_opciones_reporte_BeforeShow @12-83098874
function footerParcela_opciones_reporte_BeforeShow(& $sender)
{
    $footerParcela_opciones_reporte_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $footerParcela; //Compatibility
//End footerParcela_opciones_reporte_BeforeShow

//Close footerParcela_opciones_reporte_BeforeShow @12-485F744A
    return $footerParcela_opciones_reporte_BeforeShow;
}
//End Close footerParcela_opciones_reporte_BeforeShow

//DEL  // -------------------------
//DEL  // -------------------------

//footerParcela_opciones_BeforeShowRow @15-B1E86F36
function footerParcela_opciones_BeforeShowRow(& $sender)
{
    $footerParcela_opciones_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $footerParcela; //Compatibility
//End footerParcela_opciones_BeforeShowRow

//Custom Code @26-2A29BDB7
// -------------------------
    // Write your own code here.
	//lnk del reporte
	$parcela_id = $Component->ds->f('parcela_id');
	$Component->reporte->SetLink(RelativePath . "/reportes/rpt_nom_pdf.php?parcela_id=$parcela_id");
	if(CCGetParam(parcela_id)){
   		$db = new clsDBtdf_nuevo();
		$Component->Label1->SetValue("<b>(".CCDLookUp("COUNT(*)","mejoras","parcela_id = ".CCGetParam(parcela_id)." AND tipo_estado_id = 1",$db).")</b>");
		$Component->Label2->SetValue("<b>(".CCDLookUp("COUNT(*)","personas_parcelas","parcela_id = ".CCGetParam(parcela_id)." AND tipo_estado_id = 1",$db).")</b>");
		$db->close();
	}else{
		$Component->Label1->SetValue("");
		$Component->Label2->SetValue("");
	}
// -------------------------
//End Custom Code

//Close footerParcela_opciones_BeforeShowRow @15-EC776425
    return $footerParcela_opciones_BeforeShowRow;
}
//End Close footerParcela_opciones_BeforeShowRow

//footerParcela_opciones_BeforeShow @15-8943FED9
function footerParcela_opciones_BeforeShow(& $sender)
{
    $footerParcela_opciones_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $footerParcela; //Compatibility
//End footerParcela_opciones_BeforeShow

//Custom Code @34-2A29BDB7
// -------------------------
    if(CCGetParam(parcela_id)){
		$Component->footerParcela->Visible = true;
	}else{
		$Component->footerParcela->Visible = false;
	}
// -------------------------
//End Custom Code

//Close footerParcela_opciones_BeforeShow @15-967DD7A4
    return $footerParcela_opciones_BeforeShow;
}
//End Close footerParcela_opciones_BeforeShow

//footerParcela_BeforeInitialize @1-AADAE676
function footerParcela_BeforeInitialize(& $sender)
{
    $footerParcela_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $footerParcela; //Compatibility
//End footerParcela_BeforeInitialize

//Custom Code @45-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close footerParcela_BeforeInitialize @1-EF280C7E
    return $footerParcela_BeforeInitialize;
}
//End Close footerParcela_BeforeInitialize
?>
