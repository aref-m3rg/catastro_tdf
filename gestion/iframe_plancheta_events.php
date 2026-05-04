<?php
//BindEvents Method @1-136E29C8
function BindEvents()
{
    global $iframe_plancheta;
    global $CCSEvents;
    $iframe_plancheta->CCSEvents["BeforeShow"] = "iframe_plancheta_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//iframe_plancheta_BeforeShow @4-6D79F70E
function iframe_plancheta_BeforeShow(& $sender)
{
    $iframe_plancheta_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $iframe_plancheta; //Compatibility
//End iframe_plancheta_BeforeShow

//Custom Code @7-2A29BDB7
// -------------------------
	$iframe_plancheta->SetValue("<iframe src='http://192.168.5.6/plancheta/planchetas/planchetas.php?interno=1' scrolling='NO' frameborder='0' height='700' width='100%'></iframe>");
// -------------------------
//End Custom Code

//Close iframe_plancheta_BeforeShow @4-65D46D16
    return $iframe_plancheta_BeforeShow;
}
//End Close iframe_plancheta_BeforeShow

//Page_BeforeShow @1-E3A1214C
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $iframe_plancheta; //Compatibility
//End Page_BeforeShow

//Custom Code @6-2A29BDB7
// -------------------------
	session_start();
	$_SESSION["user_id"]=1;
	$_SESSION["user_login"]='pruebax';
	$_SESSION["user_grupo"]='Profesional';

// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
