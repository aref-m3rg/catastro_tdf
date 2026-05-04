<?php
//BindEvents Method @1-2FFD3A65
function BindEvents()
{
    global $departamentos_planchetas1;
    $departamentos_planchetas1->Label1->CCSEvents["BeforeShow"] = "departamentos_planchetas1_Label1_BeforeShow";
    $departamentos_planchetas1->CCSEvents["BeforeShowRow"] = "departamentos_planchetas1_BeforeShowRow";
}
//End BindEvents Method

//departamentos_planchetas1_Label1_BeforeShow @79-A99BB4D9
function departamentos_planchetas1_Label1_BeforeShow(& $sender)
{
    $departamentos_planchetas1_Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_planchetas1; //Compatibility
//End departamentos_planchetas1_Label1_BeforeShow

//Retrieve number of records @80-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close departamentos_planchetas1_Label1_BeforeShow @79-241265DE
    return $departamentos_planchetas1_Label1_BeforeShow;
}
//End Close departamentos_planchetas1_Label1_BeforeShow

//departamentos_planchetas1_BeforeShowRow @43-7BD00500
function departamentos_planchetas1_BeforeShowRow(& $sender)
{
    $departamentos_planchetas1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_planchetas1; //Compatibility
//End departamentos_planchetas1_BeforeShowRow

//Custom Code @78-2A29BDB7
// -------------------------
    // Write your own code here.
	if($Component->ds->f('plancheta_file')){
		$archivo = $Component->ds->f('plancheta_file');
		$htm = '<a class="" target="plancheta" href="archivos/' . $archivo . '"><img border="0" class=""  src="' . RelativePath . '/phpThumb/phpThumb.php?src=/planchetas/archivos/' . $archivo . '&h=40"></a>';
		
	} else {
		$htm = "";
	}

	$Component->htm->SetValue($htm);

	//popup plancheta pdf
	$plancheta_id = $Component->ds->f('plancheta_id');
	$lnk = "../reportes/rpt_plancheta.php?plancheta_id=" . $plancheta_id;
	$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'','width=870,height=600,top='+(screen.height-600)/2+',left='+(screen.width-870)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes');return false;";
	$Component->ImageLink3->SetLink($newlnk);
// -------------------------
//End Custom Code

//Close departamentos_planchetas1_BeforeShowRow @43-557CDD6C
    return $departamentos_planchetas1_BeforeShowRow;
}
//End Close departamentos_planchetas1_BeforeShowRow


?>
