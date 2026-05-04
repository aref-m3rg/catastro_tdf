<?php
//BindEvents Method @1-FD0CF662
function BindEvents()
{
    global $creador_destino_origen_pa;
    $creador_destino_origen_pa->creador_destino_origen_pa_TotalRecords->CCSEvents["BeforeShow"] = "creador_destino_origen_pa_creador_destino_origen_pa_TotalRecords_BeforeShow";
    $creador_destino_origen_pa->CCSEvents["BeforeShowRow"] = "creador_destino_origen_pa_BeforeShowRow";
}
//End BindEvents Method

//creador_destino_origen_pa_creador_destino_origen_pa_TotalRecords_BeforeShow @38-69F2F3B2
function creador_destino_origen_pa_creador_destino_origen_pa_TotalRecords_BeforeShow(& $sender)
{
    $creador_destino_origen_pa_creador_destino_origen_pa_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $creador_destino_origen_pa; //Compatibility
//End creador_destino_origen_pa_creador_destino_origen_pa_TotalRecords_BeforeShow

//Retrieve number of records @39-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close creador_destino_origen_pa_creador_destino_origen_pa_TotalRecords_BeforeShow @38-376884BC
    return $creador_destino_origen_pa_creador_destino_origen_pa_TotalRecords_BeforeShow;
}
//End Close creador_destino_origen_pa_creador_destino_origen_pa_TotalRecords_BeforeShow

//creador_destino_origen_pa_BeforeShowRow @2-2D63BF11
function creador_destino_origen_pa_BeforeShowRow(& $sender)
{
    $creador_destino_origen_pa_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $creador_destino_origen_pa; //Compatibility
//End creador_destino_origen_pa_BeforeShowRow

//Set Row Style @40-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Custom Code @84-2A29BDB7
// -------------------------
    // Write your own code here.
	//Link Ruta
	$qs = 'pieza_id=' . $Component->ds->f('pieza_id');
	$lnk = 'msa_ruta.php?' . $qs;
	$newlnk = "$lnk\" onclick=\"javascript:window.open(this.href,'ruta','width=600,height=500,top='+(screen.height-500)/2+',left='+(screen.width-600)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->rutaLnk->SetLink($newlnk);
	//Link Pieza
	$lnk = 'msa_pieza.php?' . $qs;
	$newlnk = "$lnk\" onclick=\"javascript:window.open(this.href,'ruta','width=450,height=400,top='+(screen.height-500)/2+',left='+(screen.width-600)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->piezaLnk->SetLink($newlnk);

// -------------------------
//End Custom Code

//Close creador_destino_origen_pa_BeforeShowRow @2-950582F5
    return $creador_destino_origen_pa_BeforeShowRow;
}
//End Close creador_destino_origen_pa_BeforeShowRow


?>
