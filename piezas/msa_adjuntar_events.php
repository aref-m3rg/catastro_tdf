<?php
//BindEvents Method @1-976A1747
function BindEvents()
{
    global $area;
    $area->ds->CCSEvents["AfterExecuteDelete"] = "area_ds_AfterExecuteDelete";
}
//End BindEvents Method

//area_ds_AfterExecuteDelete @103-5AD30FD9
function area_ds_AfterExecuteDelete(& $sender)
{
    $area_ds_AfterExecuteDelete = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $area; //Compatibility
//End area_ds_AfterExecuteDelete

//Custom Code @177-2A29BDB7
// -------------------------
    // Write your own code here.
	$db = new clsDBmesa();
	$adj_pieza_id = $Component->pieza_id->GetValue();
	$adj_tipo_id = $Component->adj_tipo_id->GetValue();
	$SQL = "INSERT INTO adjuntos 
			SET ppal_pieza_id = " . CCGetParam('pieza_id') . ",
				adj_pieza_id = " . $adj_pieza_id . ",
				adj_tipo_id = " . $adj_tipo_id . ",  
				adj_comentario = '',
				adj_fecha = NOW(),
				usuario_id = " . CCGetUserID();
	
	
	//echo $SQL;exit();
	$db->query($SQL);
	$db->close();
	
// -------------------------
//End Custom Code

//Close area_ds_AfterExecuteDelete @103-69AF8A13
    return $area_ds_AfterExecuteDelete;
}
//End Close area_ds_AfterExecuteDelete


?>
