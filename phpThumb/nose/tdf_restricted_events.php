<?php
//BindEvents Method @1-D40060DD
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//Page_BeforeShow @1-415EA394
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tdf_restricted; //Compatibility
//End Page_BeforeShow

//Custom Code @8-2A29BDB7
// -------------------------
    // Write your own code here.
	$db = new clsDBcatastro();
	$SQL = "SELECT usuarios_nombre, usuarios_login , us_grup_nombre 
			FROM usuarios
			INNER JOIN usuarios_grupos USING(us_grup_id)
			WHERE usuarios_id = " . CCGetUserID();
	$db->query($SQL);
	//echo $SQL;
	if($db->next_record()){
		$Component->usr->SetValue($db->f('usuarios_nombre'));
		$Component->grp->SetValue($db->f('us_grup_nombre'));
		$Component->login->SetValue($db->f('usuarios_login'));
	}

	$db->close();
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
