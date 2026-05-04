<?php
//BindEvents Method @1-DE2ADF60
function BindEvents()
{
    global $area;
    $area->cant->CCSEvents["BeforeShow"] = "area_cant_BeforeShow";
    $area->CCSEvents["BeforeShowRow"] = "area_BeforeShowRow";
}
//End BindEvents Method

//area_cant_BeforeShow @55-516D1872
function area_cant_BeforeShow(& $sender)
{
    $area_cant_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $area; //Compatibility
//End area_cant_BeforeShow

//Retrieve number of records @56-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close area_cant_BeforeShow @55-D1FFC940
    return $area_cant_BeforeShow;
}
//End Close area_cant_BeforeShow

//area_BeforeShowRow @2-E835437A
function area_BeforeShowRow(& $sender)
{
    $area_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $area; //Compatibility
//End area_BeforeShowRow

//Custom Code @18-2A29BDB7
// -------------------------
    // Write your own code here.
	$db = new clsDBmesa();
	$qs = 'pieza_id=' . $Component->ds->f('pieza_id');

	//Link desarchivar
	$lnk = 'msa_desarchivar.php?' . $qs;
	$newlnk = "$lnk\" onclick=\"javascript:window.open(this.href,'ruta','width=450,height=150,top='+(screen.height-500)/2+',left='+(screen.width-600)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->archLnk->SetLink($newlnk);

	//Link Ruta
	$lnk = 'msa_ruta.php?' . $qs;
	$newlnk = "$lnk\" onclick=\"javascript:window.open(this.href,'ruta','width=600,height=500,top='+(screen.height-500)/2+',left='+(screen.width-600)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->rutaLnk->SetLink($newlnk);
	//Link Adjuntos
	$lnk = 'msa_adjuntos.php?' . $qs;
	$newlnk = "$lnk\" onclick=\"javascript:window.open(this.href,'ruta','width=600,height=500,top='+(screen.height-500)/2+',left='+(screen.width-600)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no');return false;";
	$Component->adjLnk->SetLink($newlnk);

	//mostrar o no los links
	//Adjuntos, si no tiene adjuntos no se muestra
	//por defecto invisible
	$Component->adjLnk->Visible = False;
	$adj = CCDLookUp('COUNT(*)','adjuntos','ppal_pieza_id = ' . $Component->ds->f('pieza_id'),$db);
	if($adj > 0){$Component->adjLnk->Visible = True;}
	
// -------------------------
//End Custom Code

//Close area_BeforeShowRow @2-B8056EE6
    return $area_BeforeShowRow;
}
//End Close area_BeforeShowRow


?>
