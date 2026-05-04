<?php
//BindEvents Method @1-83811438
function BindEvents()
{
    global $auditorias_auditorias_tip1;
    global $CCSEvents;
    $auditorias_auditorias_tip1->auditorias_auditorias_tip1_TotalRecords->CCSEvents["BeforeShow"] = "auditorias_auditorias_tip1_auditorias_auditorias_tip1_TotalRecords_BeforeShow";
    $auditorias_auditorias_tip1->det->CCSEvents["BeforeShow"] = "auditorias_auditorias_tip1_det_BeforeShow";
    $auditorias_auditorias_tip1->CCSEvents["BeforeShowRow"] = "auditorias_auditorias_tip1_BeforeShowRow";
    $auditorias_auditorias_tip1->ds->CCSEvents["BeforeExecuteSelect"] = "auditorias_auditorias_tip1_ds_BeforeExecuteSelect";
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

//auditorias_auditorias_tip1_det_BeforeShow @78-4C5A5D94
function auditorias_auditorias_tip1_det_BeforeShow(& $sender)
{
    $auditorias_auditorias_tip1_det_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditorias_auditorias_tip1; //Compatibility
//End auditorias_auditorias_tip1_det_BeforeShow

//Open as popup @94-385C8F54
    

// det
// det
	
global $auditorias_auditorias_tip1;

$lnk=$auditorias_auditorias_tip1->det->GetLink();
$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'asd','width=500,height=550,top='+(screen.height-550)/2+',left='+(screen.width-500)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes').focus();return false;";
$auditorias_auditorias_tip1->det->SetLink($newlnk);

	
//End Open as popup

//Close auditorias_auditorias_tip1_det_BeforeShow @78-EE47937C
    return $auditorias_auditorias_tip1_det_BeforeShow;
}
//End Close auditorias_auditorias_tip1_det_BeforeShow

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

//Custom Code @80-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close auditorias_auditorias_tip1_BeforeShowRow @2-533A71CB
    return $auditorias_auditorias_tip1_BeforeShowRow;
}
//End Close auditorias_auditorias_tip1_BeforeShowRow

//auditorias_auditorias_tip1_ds_BeforeExecuteSelect @2-6E5BAF8B
function auditorias_auditorias_tip1_ds_BeforeExecuteSelect(& $sender)
{
    $auditorias_auditorias_tip1_ds_BeforeExecuteSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditorias_auditorias_tip1; //Compatibility
//End auditorias_auditorias_tip1_ds_BeforeExecuteSelect

//Custom Code @96-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close auditorias_auditorias_tip1_ds_BeforeExecuteSelect @2-50651E5D
    return $auditorias_auditorias_tip1_ds_BeforeExecuteSelect;
}
//End Close auditorias_auditorias_tip1_ds_BeforeExecuteSelect

//Page_AfterInitialize @1-884D1441
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditorias; //Compatibility
//End Page_AfterInitialize

//Custom Code @116-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeInitialize @1-07293E66
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $auditorias; //Compatibility
//End Page_BeforeInitialize

//Custom Code @119-2A29BDB7
// -------------------------
    include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
