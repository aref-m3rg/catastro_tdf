<?php

//BindEvents Method @1-2DDC76D5
function BindEvents()
{
    global $parcelas_documentos;
    global $parcelas_documentos1;
    global $CCSEvents;
    $parcelas_documentos->FileUpload1->CCSEvents["AfterProcessFile"] = "parcelas_documentos_FileUpload1_AfterProcessFile";
    $parcelas_documentos->CCSEvents["BeforeInsert"] = "parcelas_documentos_BeforeInsert";
    $parcelas_documentos->CCSEvents["BeforeUpdate"] = "parcelas_documentos_BeforeUpdate";
    $parcelas_documentos1->CCSEvents["BeforeShowRow"] = "parcelas_documentos1_BeforeShowRow";
}
//End BindEvents Method

//parcelas_documentos_FileUpload1_AfterProcessFile @13-7B205CCF
function parcelas_documentos_FileUpload1_AfterProcessFile(& $sender)
{
    $parcelas_documentos_FileUpload1_AfterProcessFile = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_documentos; //Compatibility
//End parcelas_documentos_FileUpload1_AfterProcessFile

//Custom Code @14-2A29BDB7
// -------------------------
    $old = $Component->GetValue();
	$ext = substr ($old,-3);
	$new = date('Ymd_') . (double)microtime()*1000000 . '.' . $ext;
	rename(RelativePath . "/gestion/parceladocs/".$old,RelativePath . "/gestion/parceladocs/".$new);
	$db = new clsDBtdf_nuevo(); //or whatever your db class is called
	$db->query("UPDATE parcelas_documentos SET parcela_document_archivo = '".$new."' WHERE parcela_document_archivo = '".$old."'");
	$db->close();
// -------------------------
//End Custom Code

//Close parcelas_documentos_FileUpload1_AfterProcessFile @13-3E88A87B
    return $parcelas_documentos_FileUpload1_AfterProcessFile;
}
//End Close parcelas_documentos_FileUpload1_AfterProcessFile

//parcelas_documentos_BeforeInsert @6-69085E3F
function parcelas_documentos_BeforeInsert(& $sender)
{
    $parcelas_documentos_BeforeInsert = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_documentos; //Compatibility
//End parcelas_documentos_BeforeInsert

//Custom Code @32-2A29BDB7
// -------------------------
	$db = new clsDBtdf_nuevo(); //or whatever your db class is called
	$parcelas_documentos->parcela_document_f_proc->SetValue(CCDLookUp("NOW()","","",$db));
	$db->close();
// -------------------------
//End Custom Code

//Close parcelas_documentos_BeforeInsert @6-188A1D0C
    return $parcelas_documentos_BeforeInsert;
}
//End Close parcelas_documentos_BeforeInsert

//parcelas_documentos_BeforeUpdate @6-1AA53D25
function parcelas_documentos_BeforeUpdate(& $sender)
{
    $parcelas_documentos_BeforeUpdate = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_documentos; //Compatibility
//End parcelas_documentos_BeforeUpdate

//Custom Code @33-2A29BDB7
// -------------------------
    $db = new clsDBtdf_nuevo(); //or whatever your db class is called
	$parcelas_documentos->parcela_document_f_proc->SetValue(CCDLookUp("NOW()","","",$db));
	$db->close();
// -------------------------
//End Custom Code

//Close parcelas_documentos_BeforeUpdate @6-D7A3DC83
    return $parcelas_documentos_BeforeUpdate;
}
//End Close parcelas_documentos_BeforeUpdate

//parcelas_documentos1_BeforeShowRow @17-241BB332
function parcelas_documentos1_BeforeShowRow(& $sender)
{
    $parcelas_documentos1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelas_documentos1; //Compatibility
//End parcelas_documentos1_BeforeShowRow

//Custom Code @36-2A29BDB7
// -------------------------
	$clase = array(" Bytes", " KB", " MB", " GB", " TB"); 
	$peso = filesize("parceladocs/".$parcelas_documentos1->parcela_document_archivo->GetValue());
	$parcelas_documentos1->tamano->SetValue(round($peso/pow(1024,($i = floor(log($peso, 1024)))),2 ).$clase[$i]);
	if($parcelas_documentos1->tipo_doc_descrip->GetValue() == "Foto" || $parcelas_documentos1->tipo_doc_descrip->GetValue() == "Escaneo" || $parcelas_documentos1->tipo_doc_descrip->GetValue() == "Imagen"){
    	$parcelas_documentos1->parcela_document_archivo->SetValue("<a href='parceladocs/".$parcelas_documentos1->parcela_document_archivo->GetValue()."' target='_blank'><img style='height: 85px; BORDER-RIGHT: 0px; BORDER-TOP: 0px; BORDER-LEFT: 0px; BORDER-BOTTOM: 0px' src='parceladocs/".$parcelas_documentos1->parcela_document_archivo->GetValue()."'></a>");
	}else{
		$parcelas_documentos1->parcela_document_archivo->SetValue("<a href='parceladocs/".$parcelas_documentos1->parcela_document_archivo->GetValue()."' title='Bajar documento'>".$parcelas_documentos1->parcela_document_archivo->GetValue()."</a>");
	}
	
// -------------------------
//End Custom Code

//Close parcelas_documentos1_BeforeShowRow @17-E480DB77
    return $parcelas_documentos1_BeforeShowRow;
}
//End Close parcelas_documentos1_BeforeShowRow

//Page_BeforeInitialize @1-E6146F00
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $parcelaDocumentos; //Compatibility
//End Page_BeforeInitialize

//Custom Code @5-2A29BDB7
// -------------------------
    // Write your own code here.
	include_once(RelativePath . "/scripts/permisos1.php");
// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize
?>
