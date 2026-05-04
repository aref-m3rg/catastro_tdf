<?php

//BindEvents Method @1-2FA96A6B
function BindEvents()
{
    global $menu;
    global $CCSEvents;
    $menu->ds->CCSEvents["AfterExecuteInsert"] = "menu_ds_AfterExecuteInsert";
}
//End BindEvents Method

//menu_ds_AfterExecuteInsert @27-5A581E7A
function menu_ds_AfterExecuteInsert(& $sender)
{
    $menu_ds_AfterExecuteInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $menu; //Compatibility
//End menu_ds_AfterExecuteInsert

//Custom Code @49-2A29BDB7
// -------------------------
    // Write your own code here.
	$ultima_pagina = mysql_insert_id();
$db = new clsDBtdf_nuevo();
$insert = "INSERT INTO _perfiles_items (perfil_id, menu_id, nivel_id) VALUES (1,".$ultima_pagina .",2);";
$db->Query($insert);

// -------------------------
//End Custom Code

//Close menu_ds_AfterExecuteInsert @27-B9AFB173
    return $menu_ds_AfterExecuteInsert;
}
//End Close menu_ds_AfterExecuteInsert

//Page_BeforeInitialize @1-CDB25C7E
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $subpaginas; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------
    // Write your own code here.
	//include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
