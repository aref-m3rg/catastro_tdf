<?php
//BindEvents Method @1-FA225C19
function BindEvents()
{
    global $calles_tipos_estados1;
    $calles_tipos_estados1->calles_tipos_estados1_TotalRecords->CCSEvents["BeforeShow"] = "calles_tipos_estados1_calles_tipos_estados1_TotalRecords_BeforeShow";
}
//End BindEvents Method

//calles_tipos_estados1_calles_tipos_estados1_TotalRecords_BeforeShow @17-8BA3F7F4
function calles_tipos_estados1_calles_tipos_estados1_TotalRecords_BeforeShow(& $sender)
{
    $calles_tipos_estados1_calles_tipos_estados1_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $calles_tipos_estados1; //Compatibility
//End calles_tipos_estados1_calles_tipos_estados1_TotalRecords_BeforeShow

//Retrieve number of records @18-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close calles_tipos_estados1_calles_tipos_estados1_TotalRecords_BeforeShow @17-13F5BDAC
    return $calles_tipos_estados1_calles_tipos_estados1_TotalRecords_BeforeShow;
}
//End Close calles_tipos_estados1_calles_tipos_estados1_TotalRecords_BeforeShow


?>
