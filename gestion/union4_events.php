<?php

//BindEvents Method @1-801C4CE5
function BindEvents()
{
    global $parcelas_tmp;
    global $CCSEvents;
    $parcelas_tmp->CCSEvents["BeforeShow"] = "parcelas_tmp_BeforeShow";
}
//End BindEvents Method

//parcelas_tmp_BeforeShow @22-DF068139
function parcelas_tmp_BeforeShow(& $sender)
{
    $parcelas_tmp_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_tmp; //Compatibility
//End parcelas_tmp_BeforeShow

//Custom Code @34-2A29BDB7
// -------------------------
    // Write your own code here.
	if (CCGetParam(parcela_id_a)){
		
		$db = new clsDBtdf_nuevo();
		$esta= CCDLookUp('tmp_parcela_id', 'tmp','tmp_parcela_id ='. CCGetParam(parcela_id_a) , $db);
		if (!$esta){
			$SQL = "INSERT INTO tmp SET tmp_parcela_id = " . CCGetParam(parcela_id_a)   ;
			echo $SQL;
			//exit;
			$db->Query($SQL);
			$Redirect = CCGetParam("ret_link", $Redirect);

			//$_GET["parcela_id_a"] = "";


			}
	}


// -------------------------
//End Custom Code

//Close parcelas_tmp_BeforeShow @22-DE2F83E3
    return $parcelas_tmp_BeforeShow;
}
//End Close parcelas_tmp_BeforeShow

//Page_BeforeInitialize @1-5F618617
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union4; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
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
