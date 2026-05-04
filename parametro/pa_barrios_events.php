<?php
//BindEvents Method @1-B9E02534
function BindEvents()
{
    global $barrios;
    $barrios->barrios_TotalRecords->CCSEvents["BeforeShow"] = "barrios_barrios_TotalRecords_BeforeShow";
}
//End BindEvents Method

//barrios_barrios_TotalRecords_BeforeShow @7-EE1F7670
function barrios_barrios_TotalRecords_BeforeShow(& $sender)
{
    $barrios_barrios_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $barrios; //Compatibility
//End barrios_barrios_TotalRecords_BeforeShow

//Retrieve number of records @8-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close barrios_barrios_TotalRecords_BeforeShow @7-AF9B159F
    return $barrios_barrios_TotalRecords_BeforeShow;
}
//End Close barrios_barrios_TotalRecords_BeforeShow


?>
