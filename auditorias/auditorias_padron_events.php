<?php
//BindEvents Method @1-CCC06056
function BindEvents()
{
    global $auditorias_auditorias_tip1;
    global $CCSEvents;
    $auditorias_auditorias_tip1->auditorias_auditorias_tip1_TotalRecords->CCSEvents["BeforeShow"] = "auditorias_auditorias_tip1_auditorias_auditorias_tip1_TotalRecords_BeforeShow";
    $auditorias_auditorias_tip1->CCSEvents["BeforeShowRow"] = "auditorias_auditorias_tip1_BeforeShowRow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

//auditorias_auditorias_tip1_auditorias_auditorias_tip1_TotalRecords_BeforeShow @22-773AA343
function auditorias_auditorias_tip1_auditorias_auditorias_tip1_TotalRecords_BeforeShow(& $sender)
{
    $auditorias_auditorias_tip1_auditorias_auditorias_tip1_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditorias_auditorias_tip1; //Compatibility
//End auditorias_auditorias_tip1_auditorias_auditorias_tip1_TotalRecords_BeforeShow

//Retrieve number of records @23-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close auditorias_auditorias_tip1_auditorias_auditorias_tip1_TotalRecords_BeforeShow @22-DC1014BE
    return $auditorias_auditorias_tip1_auditorias_auditorias_tip1_TotalRecords_BeforeShow;
}
//End Close auditorias_auditorias_tip1_auditorias_auditorias_tip1_TotalRecords_BeforeShow

//auditorias_auditorias_tip1_BeforeShowRow @2-90C71173
function auditorias_auditorias_tip1_BeforeShowRow(& $sender)
{
    $auditorias_auditorias_tip1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditorias_auditorias_tip1; //Compatibility
//End auditorias_auditorias_tip1_BeforeShowRow

//Set Row Style @34-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Close auditorias_auditorias_tip1_BeforeShowRow @2-533A71CB
    return $auditorias_auditorias_tip1_BeforeShowRow;
}
//End Close auditorias_auditorias_tip1_BeforeShowRow

//Page_AfterInitialize @1-D4D59310
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditorias_padron; //Compatibility
//End Page_AfterInitialize

//Custom Code @130-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-A170C5B2
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditorias_padron; //Compatibility
//End Page_BeforeInitialize

//Custom Code @137-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

?>
