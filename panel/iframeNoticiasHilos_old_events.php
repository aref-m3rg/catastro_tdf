<?php
//BindEvents Method @1-BFECDE4F
function BindEvents()
{
    global $noticias_hilos_usuarios1;
    $noticias_hilos_usuarios1->CCSEvents["BeforeShowRow"] = "noticias_hilos_usuarios1_BeforeShowRow";
}
//End BindEvents Method

//noticias_hilos_usuarios1_BeforeShowRow @26-A2083B8B
function noticias_hilos_usuarios1_BeforeShowRow(& $sender)
{
    $noticias_hilos_usuarios1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $noticias_hilos_usuarios1; //Compatibility
//End noticias_hilos_usuarios1_BeforeShowRow

//Set Row Style @32-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Close noticias_hilos_usuarios1_BeforeShowRow @26-587F51E7
    return $noticias_hilos_usuarios1_BeforeShowRow;
}
//End Close noticias_hilos_usuarios1_BeforeShowRow


?>
