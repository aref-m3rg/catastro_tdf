<?php
//BindEvents Method @1-3988C530
function BindEvents()
{
    global $requisitos;
    global $CCSEvents;
    $requisitos->ds->CCSEvents["AfterExecuteUpdate"] = "requisitos_ds_AfterExecuteUpdate";
}
//End BindEvents Method

//requisitos_ds_AfterExecuteUpdate @39-4BF06393
function requisitos_ds_AfterExecuteUpdate(& $sender)
{
    $requisitos_ds_AfterExecuteUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $requisitos; //Compatibility
//End requisitos_ds_AfterExecuteUpdate

//Custom Code @59-2A29BDB7
// -------------------------
    // Write your own code here.
	//si viene req_plano_id hay que hacer UPDATE, si no INSERT

	$db = new clsDBcatastro();
	
	$req_est_id = $Component->req_est_id->GetValue();
	$req_id = $Component->req_id->GetValue();
	$req_plano_id = $Component->req_plano_id->GetValue();
	$plano_id = CCGetParam(plano_id);
	
	if($req_est_id){
	
		if($req_plano_id){
			$SQL_UPD = "UPDATE requisitos_planos
						SET req_est_id = '$req_est_id'
						WHERE req_plano_id = $req_plano_id"; 	
			$db->query($SQL_UPD);
		} else {
			$SQL_INS = "INSERT INTO requisitos_planos
						SET req_id = '$req_id',
						plano_id = '$plano_id',
						req_est_id = '$req_est_id'"; 	
			$db->query($SQL_INS);
		}
	}
// -------------------------
//End Custom Code

//Close requisitos_ds_AfterExecuteUpdate @39-C4E0FD61
    return $requisitos_ds_AfterExecuteUpdate;
}
//End Close requisitos_ds_AfterExecuteUpdate

//Page_BeforeInitialize @1-95560ECE
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_docGrid; //Compatibility
//End Page_BeforeInitialize

//Custom Code @81-2A29BDB7
// -------------------------

    // Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");
    
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
