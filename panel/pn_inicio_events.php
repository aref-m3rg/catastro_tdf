<?php
//BindEvents Method @1-AD7F742E
function BindEvents()
{
    global $noticias_noticias_categor;
    global $CCSEvents;
    $noticias_noticias_categor->CCSEvents["BeforeShowRow"] = "noticias_noticias_categor_BeforeShowRow";
}
//End BindEvents Method

//noticias_noticias_categor_BeforeShowRow @30-0CC011A7
function noticias_noticias_categor_BeforeShowRow(& $sender)
{
    $noticias_noticias_categor_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $noticias_noticias_categor; //Compatibility
//End noticias_noticias_categor_BeforeShowRow

//Custom Code @70-2A29BDB7
// -------------------------
    // Write your own code here.
	if($Component->ds->f('usuario_id') == CCGetUserID()){
		$Component->edit->Visible = true;
	} else {
		$Component->edit->Visible = false;
	}
// -------------------------
//End Custom Code

//Close noticias_noticias_categor_BeforeShowRow @30-07507DD7
    return $noticias_noticias_categor_BeforeShowRow;
}
//End Close noticias_noticias_categor_BeforeShowRow

//Page_BeforeInitialize @1-09C1C4AC
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pn_inicio; //Compatibility
//End Page_BeforeInitialize

//Custom Code @165-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
