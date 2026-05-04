<?php
//BindEvents Method @1-B56FC342
function BindEvents()
{
    global $entornos_unidades_unidade1;
    $entornos_unidades_unidade1->entornos_unidades_unidade1_TotalRecords->CCSEvents["BeforeShow"] = "entornos_unidades_unidade1_entornos_unidades_unidade1_TotalRecords_BeforeShow";
    $entornos_unidades_unidade1->CCSEvents["BeforeShowRow"] = "entornos_unidades_unidade1_BeforeShowRow";
}
//End BindEvents Method

//entornos_unidades_unidade1_entornos_unidades_unidade1_TotalRecords_BeforeShow @18-C4B319AF
function entornos_unidades_unidade1_entornos_unidades_unidade1_TotalRecords_BeforeShow(& $sender)
{
    $entornos_unidades_unidade1_entornos_unidades_unidade1_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $entornos_unidades_unidade1; //Compatibility
//End entornos_unidades_unidade1_entornos_unidades_unidade1_TotalRecords_BeforeShow

//Retrieve number of records @19-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close entornos_unidades_unidade1_entornos_unidades_unidade1_TotalRecords_BeforeShow @18-D7F9A173
    return $entornos_unidades_unidade1_entornos_unidades_unidade1_TotalRecords_BeforeShow;
}
//End Close entornos_unidades_unidade1_entornos_unidades_unidade1_TotalRecords_BeforeShow

//entornos_unidades_unidade1_BeforeShowRow @2-C82D308E
function entornos_unidades_unidade1_BeforeShowRow(& $sender)
{
    $entornos_unidades_unidade1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $entornos_unidades_unidade1; //Compatibility
//End entornos_unidades_unidade1_BeforeShowRow

//Set Row Style @24-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Custom Code @42-2A29BDB7
// -------------------------
    // Write your own code here.
	$Component->ImageLink2->Visible = true;
	if($Component->ds->f(entorno_id) == 2){//externa, no mostrar link usuarios
		$Component->ImageLink2->Visible = false;
	}
// -------------------------
//End Custom Code

//Close entornos_unidades_unidade1_BeforeShowRow @2-70FF09C2
    return $entornos_unidades_unidade1_BeforeShowRow;
}
//End Close entornos_unidades_unidade1_BeforeShowRow


?>
