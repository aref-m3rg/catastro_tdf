<?php
//BindEvents Method @1-138F9A7E
function BindEvents()
{
    global $adjuntos_adjuntos_tipos_p;
    global $CCSEvents;
    $adjuntos_adjuntos_tipos_p->adjuntos_adjuntos_tipos_p_TotalRecords->CCSEvents["BeforeShow"] = "adjuntos_adjuntos_tipos_p_adjuntos_adjuntos_tipos_p_TotalRecords_BeforeShow";
    $adjuntos_adjuntos_tipos_p->CCSEvents["BeforeShowRow"] = "adjuntos_adjuntos_tipos_p_BeforeShowRow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//adjuntos_adjuntos_tipos_p_adjuntos_adjuntos_tipos_p_TotalRecords_BeforeShow @55-A215DBF3
function adjuntos_adjuntos_tipos_p_adjuntos_adjuntos_tipos_p_TotalRecords_BeforeShow(& $sender)
{
    $adjuntos_adjuntos_tipos_p_adjuntos_adjuntos_tipos_p_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $adjuntos_adjuntos_tipos_p; //Compatibility
//End adjuntos_adjuntos_tipos_p_adjuntos_adjuntos_tipos_p_TotalRecords_BeforeShow

//Retrieve number of records @56-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close adjuntos_adjuntos_tipos_p_adjuntos_adjuntos_tipos_p_TotalRecords_BeforeShow @55-97D321F8
    return $adjuntos_adjuntos_tipos_p_adjuntos_adjuntos_tipos_p_TotalRecords_BeforeShow;
}
//End Close adjuntos_adjuntos_tipos_p_adjuntos_adjuntos_tipos_p_TotalRecords_BeforeShow

//adjuntos_adjuntos_tipos_p_BeforeShowRow @26-3A613E9E
function adjuntos_adjuntos_tipos_p_BeforeShowRow(& $sender)
{
    $adjuntos_adjuntos_tipos_p_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $adjuntos_adjuntos_tipos_p; //Compatibility
//End adjuntos_adjuntos_tipos_p_BeforeShowRow

//Set Row Style @57-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Close adjuntos_adjuntos_tipos_p_BeforeShowRow @26-2CAFAB02
    return $adjuntos_adjuntos_tipos_p_BeforeShowRow;
}
//End Close adjuntos_adjuntos_tipos_p_BeforeShowRow

//Page_AfterInitialize @1-20CA614B
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $msa_adjuntos; //Compatibility
//End Page_AfterInitialize

//Custom Code @73-2A29BDB7
// -------------------------
    // Write your own code here.
	global $Redirect;

	if(CCGetParam('desadjuntar')==1){
		if(CCGetParam('ppal_pieza_id') && CCGetParam('adj_pieza_id')){
			include_once(RelativePath . "/scripts/myFunctions.php");
			desadjuntar_pieza(CCGetParam('ppal_pieza_id'),CCGetParam('adj_pieza_id'));

			$Redirect = 'msa_adjuntos.php?refresh=1&pieza_id=' . CCGetParam('ppal_pieza_id');

		}	

	}
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize


?>
