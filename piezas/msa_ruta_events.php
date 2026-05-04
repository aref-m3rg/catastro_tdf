<?php
//BindEvents Method @1-8BA677FC
function BindEvents()
{
    global $destino_origen_pase_anter;
    $destino_origen_pase_anter->destino_origen_pase_anter_TotalRecords->CCSEvents["BeforeShow"] = "destino_origen_pase_anter_destino_origen_pase_anter_TotalRecords_BeforeShow";
    $destino_origen_pase_anter->CCSEvents["BeforeShowRow"] = "destino_origen_pase_anter_BeforeShowRow";
}
//End BindEvents Method

//destino_origen_pase_anter_destino_origen_pase_anter_TotalRecords_BeforeShow @31-32FD9DD8
function destino_origen_pase_anter_destino_origen_pase_anter_TotalRecords_BeforeShow(& $sender)
{
    $destino_origen_pase_anter_destino_origen_pase_anter_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $destino_origen_pase_anter; //Compatibility
//End destino_origen_pase_anter_destino_origen_pase_anter_TotalRecords_BeforeShow

//Retrieve number of records @32-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close destino_origen_pase_anter_destino_origen_pase_anter_TotalRecords_BeforeShow @31-5039E74F
    return $destino_origen_pase_anter_destino_origen_pase_anter_TotalRecords_BeforeShow;
}
//End Close destino_origen_pase_anter_destino_origen_pase_anter_TotalRecords_BeforeShow

//destino_origen_pase_anter_BeforeShowRow @2-1E49C432
function destino_origen_pase_anter_BeforeShowRow(& $sender)
{
    $destino_origen_pase_anter_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $destino_origen_pase_anter; //Compatibility
//End destino_origen_pase_anter_BeforeShowRow

//Set Row Style @41-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Close destino_origen_pase_anter_BeforeShowRow @2-52511241
    return $destino_origen_pase_anter_BeforeShowRow;
}
//End Close destino_origen_pase_anter_BeforeShowRow

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  
//DEL  		
//DEL  	//Donde tiene que ir?
//DEL  	switch($Component->ds->f('tipo')){
//DEL  		case 1://Expediente
//DEL  			$lnk_edit = "msa_editExp.php?pieza_id=" . CCGetParam('pieza_id');
//DEL  			$lnk_print = "Scripts/scr_expPdf.php?pieza_id=" . CCGetParam('pieza_id');
//DEL  			break;
//DEL  		case 2://Nota
//DEL  			$lnk_edit = "msa_editNota.php?pieza_id=" . CCGetParam('pieza_id');
//DEL  			$lnk_print = "Scripts/scr_notaPdf.php?pieza_id=" . CCGetParam('pieza_id');
//DEL  
//DEL  	}
//DEL  
//DEL  	$Component->print->SetLink($lnk_print);
//DEL  	$Component->edit->SetLink($lnk_edit);
//DEL  	
//DEL  	//ahora mostrarlos..
//DEL  	//si tiene mas de una pase o no es la unidad creadora
//DEL  	//no puede imprimir ni editar
//DEL  	$pases = CCDLookUp("COUNT(*)","pases","pieza_id = " . CCGetParam('pieza_id'),new clsDBmesa());
//DEL  	//echo "$pases<br>";
//DEL  	//echo $Component->ds->f('unidad_id') . " - ";
//DEL  	//echo CCGetSession(unidad_id);
//DEL  	if(($pases > 1) || ($Component->ds->f('unidad_id') <> CCGetSession(unidad_id))){
//DEL  		//esconder paneles
//DEL  		$Component->imprimir->Visible = false;
//DEL  		$Component->editar->Visible = false;
//DEL  	}
//DEL  
//DEL  
//DEL  
//DEL  // -------------------------



?>
