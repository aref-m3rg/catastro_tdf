<?php
//Page_BeforeInitialize @1-2C9C602B
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pa_dtr_grilla; //Compatibility
//End Page_BeforeInitialize

//Custom Code @40-2A29BDB7
// -------------------------
    // Write your own code here.
	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");

	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
