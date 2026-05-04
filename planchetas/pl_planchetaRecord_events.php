<?php
//BindEvents Method @1-6B8AEF96
function BindEvents()
{
    global $planchetas;
    $planchetas->FileUpload1->CCSEvents["AfterProcessFile"] = "planchetas_FileUpload1_AfterProcessFile";
    $planchetas->CCSEvents["BeforeShow"] = "planchetas_BeforeShow";
    $planchetas->CCSEvents["BeforeUpdate"] = "planchetas_BeforeUpdate";
    $planchetas->CCSEvents["AfterInsert"] = "planchetas_AfterInsert";
    $planchetas->CCSEvents["BeforeDelete"] = "planchetas_BeforeDelete";
}
//End BindEvents Method

//planchetas_FileUpload1_AfterProcessFile @18-7E931A4B
function planchetas_FileUpload1_AfterProcessFile(& $sender)
{
    $planchetas_FileUpload1_AfterProcessFile = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End planchetas_FileUpload1_AfterProcessFile

//Custom Code @19-2A29BDB7
// -------------------------
    // Write your own code here.
	$old = $Component->GetValue();
	$ext = substr ($old,-3);
	$new = date('Ymd_') . (double)microtime()*1000000 . '.' . $ext;
	rename(RelativePath . "/planchetas/archivos/".$old,RelativePath . "/planchetas/archivos/".$new);
	$db = new clsDBcatastro(); //or whatever your db class is called
	$db->query("UPDATE planchetas SET plancheta_file = '".$new."' where plancheta_file = '".$old."'");
	$db->close();
// -------------------------
//End Custom Code

//Close planchetas_FileUpload1_AfterProcessFile @18-77DFD03C
    return $planchetas_FileUpload1_AfterProcessFile;
}
//End Close planchetas_FileUpload1_AfterProcessFile

//planchetas_BeforeShow @2-B2069D41
function planchetas_BeforeShow(& $sender)
{
    $planchetas_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End planchetas_BeforeShow

//Custom Code @24-2A29BDB7
// -------------------------
    // Write your own code here.
	$Component->plancheta_f_act->SetValue(date('Y-m-d H:i:s'));

	if($Component->ds->f('plancheta_file')){
		$archivo = $Component->ds->f('plancheta_file');
		$htm = '<a class="" target="foto" href="archivos/' . $archivo . '"><img border="0" class=""  src="' . RelativePath . '/phpThumb/phpThumb.php?src=/planchetas/archivos/' . $archivo . '&w=400"></a>';
		
	} else {
		$htm = "";
	}

	$Component->htm->SetValue($htm);
// -------------------------
//End Custom Code

//Close planchetas_BeforeShow @2-490D4B80
    return $planchetas_BeforeShow;
}
//End Close planchetas_BeforeShow

//planchetas_BeforeUpdate @2-C20DE53B
function planchetas_BeforeUpdate(& $sender)
{
    $planchetas_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End planchetas_BeforeUpdate

//Custom Code @32-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/myFunctions.php");
	auditar("planchetas",CCGetParam(plancheta_id),5);
// -------------------------
//End Custom Code

//Close planchetas_BeforeUpdate @2-4F294A74
    return $planchetas_BeforeUpdate;
}
//End Close planchetas_BeforeUpdate

//planchetas_AfterInsert @2-B17263A3
function planchetas_AfterInsert(& $sender)
{
    $planchetas_AfterInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End planchetas_AfterInsert

//Custom Code @33-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/myFunctions.php");
	$id = mysql_insert_id();
	auditar("planchetas",$id,3);
// -------------------------
//End Custom Code

//Close planchetas_AfterInsert @2-945CB4A4
    return $planchetas_AfterInsert;
}
//End Close planchetas_AfterInsert

//planchetas_BeforeDelete @2-E3061649
function planchetas_BeforeDelete(& $sender)
{
    $planchetas_BeforeDelete = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $planchetas; //Compatibility
//End planchetas_BeforeDelete

//Custom Code @34-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/myFunctions.php");
	auditar("planchetas",CCGetParam(plancheta_id),4);
// -------------------------
//End Custom Code

//Close planchetas_BeforeDelete @2-D30DEC05
    return $planchetas_BeforeDelete;
}
//End Close planchetas_BeforeDelete


?>
