<?php
//BindEvents Method @1-62F62E99
function BindEvents()
{
    global $usuarios_unidades_unidade;
    $usuarios_unidades_unidade->usuarios_unidades_unidade_TotalRecords->CCSEvents["BeforeShow"] = "usuarios_unidades_unidade_usuarios_unidades_unidade_TotalRecords_BeforeShow";
}
//End BindEvents Method

//usuarios_unidades_unidade_usuarios_unidades_unidade_TotalRecords_BeforeShow @3-DD459855
function usuarios_unidades_unidade_usuarios_unidades_unidade_TotalRecords_BeforeShow(& $sender)
{
    $usuarios_unidades_unidade_usuarios_unidades_unidade_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $usuarios_unidades_unidade; //Compatibility
//End usuarios_unidades_unidade_usuarios_unidades_unidade_TotalRecords_BeforeShow

//Retrieve number of records @4-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close usuarios_unidades_unidade_usuarios_unidades_unidade_TotalRecords_BeforeShow @3-493F7F02
    return $usuarios_unidades_unidade_usuarios_unidades_unidade_TotalRecords_BeforeShow;
}
//End Close usuarios_unidades_unidade_usuarios_unidades_unidade_TotalRecords_BeforeShow
?>
