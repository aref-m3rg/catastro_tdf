<?php
//BindEvents Method @1-D07A47E5
function BindEvents()
{
    global $tipos_documentacion_tasas;
    global $CCSEvents;
    $tipos_documentacion_tasas->CCSEvents["OnValidate"] = "tipos_documentacion_tasas_OnValidate";
}
//End BindEvents Method

//tipos_documentacion_tasas_OnValidate @2-6B895D13
function tipos_documentacion_tasas_OnValidate(& $sender)
{
    $tipos_documentacion_tasas_OnValidate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tipos_documentacion_tasas; //Compatibility
//End tipos_documentacion_tasas_OnValidate

//Custom Code @14-2A29BDB7
// -------------------------
    // Write your own code here.
	//Ariel 17/11
	
	//$db = new clsDBtdf_nuevo();
	$db = new clsDBcatastro();
	if(CCGetParam('tipo_doc_t_r_id')){
		$where = "AND tipo_doc_t_r_id <> ".CCGetParam('tipo_doc_t_r_id');
	}
	else{
		$where = "";
	}	
	$tipo_doc_t_r_descripcion = trim($tipos_documentacion_tasas->tipo_doc_t_r_descrip->GetValue());

	if (!$tipos_documentacion_tasas->ListBox1->GetValue())
	{
		$tipos_documentacion_tasas->Errors->addError("Es necesario seleccionar un Estado");
	}

	if($tipo_doc_t_r_descripcion){
		$tipo_doc_t_r_id = CCDLookUp("tipo_doc_t_r_id","tipos_documentacion_tasas_retributivas","tipo_doc_t_r_descrip = '$tipo_doc_t_r_descripcion' $where",$db);
		if($tipo_doc_t_r_id){
			$tipos_documentacion_tasas->Errors->addError("El nombre que desea ingresar ya existe");
		}
	}else{
		$tipos_documentacion_tasas->Errors->addError("No se permiten valores vacios");
	}
	$db->close();	
// -------------------------
//End Custom Code

//Close tipos_documentacion_tasas_OnValidate @2-C521A490
    return $tipos_documentacion_tasas_OnValidate;
}
//End Close tipos_documentacion_tasas_OnValidate

//Page_BeforeInitialize @1-1296951C
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $pa_dtr_editar; //Compatibility
//End Page_BeforeInitialize

//Custom Code @15-2A29BDB7
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
