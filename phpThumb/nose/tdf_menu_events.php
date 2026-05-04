<?php
// //Events @1-F81417CB

//tdf_menu_Menu1_BeforeShowRow @16-D4ADDAC7
function tdf_menu_Menu1_BeforeShowRow(& $sender)
{
    $tdf_menu_Menu1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu; //Compatibility
//End tdf_menu_Menu1_BeforeShowRow

//Custom Code @26-2A29BDB7
// -------------------------
    // Write your own code here.
	//echo "<pre>";
	//print_r($Component->ItemLink);
	//echo $Component->ItemLink->Value . "<br>";
	if($Component->ItemLink->Value != "Cerrar Sesión"){
		$Component->ItemLink->Parameters="";
	}
// -------------------------
//End Custom Code

//Close tdf_menu_Menu1_BeforeShowRow @16-B5A689F4
    return $tdf_menu_Menu1_BeforeShowRow;
}
//End Close tdf_menu_Menu1_BeforeShowRow

//tdf_menu_AfterInitialize @1-18CBE868
function tdf_menu_AfterInitialize(& $sender)
{
    $tdf_menu_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_menu; //Compatibility
//End tdf_menu_AfterInitialize

//Custom Code @15-2A29BDB7
// -------------------------
    // Write your own code here.
	$img1 = "../imagenes/header_1.gif";
	$img2 = "../imagenes/header_2.gif";
	$img3 = "../imagenes/header_3.gif";
	$Component->banner0->SetValue("<img alt='Catastro' src='$img1'>");
	$Component->banner->SetValue("<img alt='Catastro' src='$img2'>");
	$Component->banner2->SetValue("<img alt='Catastro' src='$img3'>");
// -------------------------
//End Custom Code

//Close tdf_menu_AfterInitialize @1-B2884DFD
    return $tdf_menu_AfterInitialize;
}
//End Close tdf_menu_AfterInitialize


?>
