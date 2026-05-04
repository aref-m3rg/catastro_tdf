<?php
//BindEvents Method @1-8D6E91C0
function BindEvents()
{
    global $noticias_categoria;
    $noticias_categoria->icon_preview->CCSEvents["BeforeShow"] = "noticias_categoria_icon_preview_BeforeShow";
}
//End BindEvents Method

//noticias_categoria_icon_preview_BeforeShow @18-1295D13E
function noticias_categoria_icon_preview_BeforeShow(& $sender)
{
    $noticias_categoria_icon_preview_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $noticias_categoria; //Compatibility
//End noticias_categoria_icon_preview_BeforeShow

//Custom Code @19-2A29BDB7
// -------------------------

	//include_once('../scripts/myFunctions.php');

    // Si se está insertando un elemento no mostrar el preview del ícono
	$recordID = $noticias_categoria->noti_cat_id->GetValue();
	
	if ( empty( $recordID ) ) {
		$noticias_categoria->icon_preview->Visible = False;
	}


// -------------------------
//End Custom Code

//Close noticias_categoria_icon_preview_BeforeShow @18-C1802E55
    return $noticias_categoria_icon_preview_BeforeShow;
}
//End Close noticias_categoria_icon_preview_BeforeShow

//DEL  // -------------------------
//DEL      // Write your own code here.
//DEL  	include_once('../scripts/myFunctions.php');
//DEL  
//DEL  	debug( $noticias_categoria->DataSource );
//DEL  
//DEL  // -------------------------



?>
