<?php

//BindEvents Method @1-BAB1EC45
function BindEvents()
{
    global $auditorias_detalle;
    global $CCSEvents;
    $auditorias_detalle->CCSEvents["BeforeShowRow"] = "auditorias_detalle_BeforeShowRow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//auditorias_detalle_BeforeShowRow @2-2EC453E2
function auditorias_detalle_BeforeShowRow(& $sender)
{
    $auditorias_detalle_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditorias_detalle; //Compatibility
//End auditorias_detalle_BeforeShowRow

//Set Row Style @9-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Close auditorias_detalle_BeforeShowRow @2-15B30CCF
    return $auditorias_detalle_BeforeShowRow;
}
//End Close auditorias_detalle_BeforeShowRow

//Page_AfterInitialize @1-33F2A3F7
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditDetalle; //Compatibility
//End Page_AfterInitialize

//Custom Code @52-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-328C5720
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditDetalle; //Compatibility
//End Page_BeforeInitialize

//Custom Code @59-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
