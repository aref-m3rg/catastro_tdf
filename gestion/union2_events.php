<?php

//BindEvents Method @1-3BAD5759
function BindEvents()
{
    global $Panel1;
    global $parcelas_unidades_medidas1;
    global $Panel2;
    global $CCSEvents;
    $Panel1->CCSEvents["BeforeShow"] = "Panel1_BeforeShow";
    $parcelas_unidades_medidas1->CCSEvents["BeforeShowRow"] = "parcelas_unidades_medidas1_BeforeShowRow";
    $Panel2->CCSEvents["BeforeShow"] = "Panel2_BeforeShow";
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    $CCSEvents["BeforeOutput"] = "Page_BeforeOutput";
    $CCSEvents["BeforeUnload"] = "Page_BeforeUnload";
}
//End BindEvents Method

//Panel1_BeforeShow @6-AAD8AF72
function Panel1_BeforeShow(& $sender)
{
    $Panel1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel1; //Compatibility
//End Panel1_BeforeShow

//Panel1UpdatePanel Page BeforeShow @7-546243CA
    global $CCSFormFilter;
    if ($CCSFormFilter == "Panel1") {
        $Component->BlockPrefix = "";
        $Component->BlockSuffix = "";
    } else {
        $Component->BlockPrefix = "<div id=\"Panel1\">";
        $Component->BlockSuffix = "</div>";
    }
//End Panel1UpdatePanel Page BeforeShow

//Close Panel1_BeforeShow @6-D21EBA68
    return $Panel1_BeforeShow;
}
//End Close Panel1_BeforeShow

//parcelas_unidades_medidas1_BeforeShowRow @50-6DDD5ACE
function parcelas_unidades_medidas1_BeforeShowRow(& $sender)
{
    $parcelas_unidades_medidas1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_unidades_medidas1; //Compatibility
//End parcelas_unidades_medidas1_BeforeShowRow

//Set Row Style @75-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Close parcelas_unidades_medidas1_BeforeShowRow @50-2A1A3D30
    return $parcelas_unidades_medidas1_BeforeShowRow;
}
//End Close parcelas_unidades_medidas1_BeforeShowRow

//Panel2_BeforeShow @17-96696C3D
function Panel2_BeforeShow(& $sender)
{
    $Panel2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Panel2; //Compatibility
//End Panel2_BeforeShow

//Panel2UpdatePanel Page BeforeShow @18-CC9B4012
    global $CCSFormFilter;
    if ($CCSFormFilter == "Panel2") {
        $Component->BlockPrefix = "";
        $Component->BlockSuffix = "";
    } else {
        $Component->BlockPrefix = "<div id=\"Panel2\">";
        $Component->BlockSuffix = "</div>";
    }
//End Panel2UpdatePanel Page BeforeShow

//Close Panel2_BeforeShow @17-AE7F9FB3
    return $Panel2_BeforeShow;
}
//End Close Panel2_BeforeShow

//Page_BeforeInitialize @1-F855311F
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union2; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Panel1UpdatePanel PageBeforeInitialize @7-B4F71FC5
    if (CCGetFromGet("FormFilter") == "Panel1" && CCGetFromGet("IsParamsEncoded") != "true") {
        global $TemplateEncoding, $CCSIsParamsEncoded;
        CCConvertDataArrays("UTF-8", $TemplateEncoding);
        $CCSIsParamsEncoded = true;
    }
//End Panel1UpdatePanel PageBeforeInitialize

//Panel2UpdatePanel PageBeforeInitialize @18-5E181320
    if (CCGetFromGet("FormFilter") == "Panel2" && CCGetFromGet("IsParamsEncoded") != "true") {
        global $TemplateEncoding, $CCSIsParamsEncoded;
        CCConvertDataArrays("UTF-8", $TemplateEncoding);
        $CCSIsParamsEncoded = true;
    }
//End Panel2UpdatePanel PageBeforeInitialize

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize

//Page_AfterInitialize @1-39C39689
function Page_AfterInitialize(& $sender)
{
    $Page_AfterInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union2; //Compatibility
//End Page_AfterInitialize

//Close Page_AfterInitialize @1-379D319D
    return $Page_AfterInitialize;
}
//End Close Page_AfterInitialize

//Page_BeforeShow @1-289C3C94
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union2; //Compatibility
//End Page_BeforeShow

//Panel1UpdatePanel Page BeforeShow @7-9F5F0EA1
    global $CCSFormFilter;
    if (CCGetFromGet("FormFilter") == "Panel1") {
        $CCSFormFilter = CCGetFromGet("FormFilter");
        unset($_GET["FormFilter"]);
        if (isset($_GET["IsParamsEncoded"])) unset($_GET["IsParamsEncoded"]);
    }
//End Panel1UpdatePanel Page BeforeShow

//Panel2UpdatePanel Page BeforeShow @18-4589DE7C
    global $CCSFormFilter;
    if (CCGetFromGet("FormFilter") == "Panel2") {
        $CCSFormFilter = CCGetFromGet("FormFilter");
        unset($_GET["FormFilter"]);
        if (isset($_GET["IsParamsEncoded"])) unset($_GET["IsParamsEncoded"]);
    }
//End Panel2UpdatePanel Page BeforeShow

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

//Page_BeforeOutput @1-815F039F
function Page_BeforeOutput(& $sender)
{
    $Page_BeforeOutput = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union2; //Compatibility
//End Page_BeforeOutput

//Panel1UpdatePanel PageBeforeOutput @7-69FFB31D
    global $CCSFormFilter, $Tpl, $main_block;
    if ($CCSFormFilter == "Panel1") {
        $main_block = $Tpl->getvar("/Panel Panel1");
    }
//End Panel1UpdatePanel PageBeforeOutput

//Panel2UpdatePanel PageBeforeOutput @18-AE056578
    global $CCSFormFilter, $Tpl, $main_block;
    if ($CCSFormFilter == "Panel2") {
        $main_block = $Tpl->getvar("/Panel Panel2");
    }
//End Panel2UpdatePanel PageBeforeOutput

//Close Page_BeforeOutput @1-8964C188
    return $Page_BeforeOutput;
}
//End Close Page_BeforeOutput

//Page_BeforeUnload @1-858E0009
function Page_BeforeUnload(& $sender)
{
    $Page_BeforeUnload = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $union2; //Compatibility
//End Page_BeforeUnload

//Panel1UpdatePanel PageBeforeUnload @7-483BFCB6
    global $Redirect, $CCSFormFilter, $CCSIsParamsEncoded;
    if ($Redirect && $CCSFormFilter == "Panel1") {
        if ($CCSIsParamsEncoded) $Redirect = CCAddParam($Redirect, "IsParamsEncoded", "true");
        $Redirect = CCAddParam($Redirect, "FormFilter", $CCSFormFilter);
    }
//End Panel1UpdatePanel PageBeforeUnload

//Panel2UpdatePanel PageBeforeUnload @18-A0E8F191
    global $Redirect, $CCSFormFilter, $CCSIsParamsEncoded;
    if ($Redirect && $CCSFormFilter == "Panel2") {
        if ($CCSIsParamsEncoded) $Redirect = CCAddParam($Redirect, "IsParamsEncoded", "true");
        $Redirect = CCAddParam($Redirect, "FormFilter", $CCSFormFilter);
    }
//End Panel2UpdatePanel PageBeforeUnload

//Close Page_BeforeUnload @1-CFAEC742
    return $Page_BeforeUnload;
}
//End Close Page_BeforeUnload
?>
