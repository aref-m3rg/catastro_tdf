<?php
//BindEvents Method @1-1B680F73
function BindEvents()
{
    global $noticias_h_estados;
    $noticias_h_estados->icon_preview->CCSEvents["BeforeShow"] = "noticias_h_estados_icon_preview_BeforeShow";
}
//End BindEvents Method

//noticias_h_estados_icon_preview_BeforeShow @18-EB9D51E9
function noticias_h_estados_icon_preview_BeforeShow(& $sender)
{
    $noticias_h_estados_icon_preview_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $noticias_h_estados; //Compatibility
//End noticias_h_estados_icon_preview_BeforeShow

//Custom Code @19-2A29BDB7
// -------------------------

	//include_once('../scripts/myFunctions.php');

    // Si se está insertando un elemento no mostrar el preview del ícono
	$recordID = $noticias_h_estados->not_h_est_id->GetValue();
	
	if ( empty( $recordID ) ) {
		$noticias_h_estados->icon_preview->Visible = False;
	}

// -------------------------
//End Custom Code

//Close noticias_h_estados_icon_preview_BeforeShow @18-AC963629
    return $noticias_h_estados_icon_preview_BeforeShow;
}
//End Close noticias_h_estados_icon_preview_BeforeShow


?>
