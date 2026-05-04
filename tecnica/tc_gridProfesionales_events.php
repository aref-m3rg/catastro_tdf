<?php
//BindEvents Method @1-2367723E
function BindEvents()
{
    global $departamentos_profesional1;
    global $CCSEvents;
    $departamentos_profesional1->departamentos_profesional1_TotalRecords->CCSEvents["BeforeShow"] = "departamentos_profesional1_departamentos_profesional1_TotalRecords_BeforeShow";
    $departamentos_profesional1->toXls->CCSEvents["BeforeShow"] = "departamentos_profesional1_toXls_BeforeShow";
    $departamentos_profesional1->CCSEvents["BeforeShowRow"] = "departamentos_profesional1_BeforeShowRow";
    $departamentos_profesional1->ds->CCSEvents["AfterExecuteSelect"] = "departamentos_profesional1_ds_AfterExecuteSelect";
}
//End BindEvents Method

//departamentos_profesional1_departamentos_profesional1_TotalRecords_BeforeShow @24-CA2F2967
function departamentos_profesional1_departamentos_profesional1_TotalRecords_BeforeShow(& $sender)
{
    $departamentos_profesional1_departamentos_profesional1_TotalRecords_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_profesional1; //Compatibility
//End departamentos_profesional1_departamentos_profesional1_TotalRecords_BeforeShow

//Retrieve number of records @25-ABE656B4
    $Component->SetValue($Container->DataSource->RecordsCount);
//End Retrieve number of records

//Close departamentos_profesional1_departamentos_profesional1_TotalRecords_BeforeShow @24-730D457F
    return $departamentos_profesional1_departamentos_profesional1_TotalRecords_BeforeShow;
}
//End Close departamentos_profesional1_departamentos_profesional1_TotalRecords_BeforeShow

//departamentos_profesional1_toXls_BeforeShow @100-FC0147B2
function departamentos_profesional1_toXls_BeforeShow(& $sender)
{
    $departamentos_profesional1_toXls_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_profesional1; //Compatibility
//End departamentos_profesional1_toXls_BeforeShow

//Open as popup @101-130D6000
    

// toXls
// toXls
	
global $departamentos_profesional1;

$lnk=$departamentos_profesional1->toXls->GetLink();
$newlnk="$lnk\" onclick=\"javascript:window.open(this.href,'xls','width=450,height=550,top='+(screen.height-550)/2+',left='+(screen.width-450)/2+',scrollbars=yes,location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=yes').focus();return false;";
$departamentos_profesional1->toXls->SetLink($newlnk);

	
//End Open as popup

//Close departamentos_profesional1_toXls_BeforeShow @100-A49A20F7
    return $departamentos_profesional1_toXls_BeforeShow;
}
//End Close departamentos_profesional1_toXls_BeforeShow

//departamentos_profesional1_BeforeShowRow @2-5A41A9E5
function departamentos_profesional1_BeforeShowRow(& $sender)
{
    $departamentos_profesional1_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_profesional1; //Compatibility
//End departamentos_profesional1_BeforeShowRow

//Set Row Style @35-982C9472
    $styles = array("Row", "AltRow");
    if (count($styles)) {
        $Style = $styles[($Component->RowNumber - 1) % count($styles)];
        if (strlen($Style) && !strpos($Style, "="))
            $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
        $Component->Attributes->SetValue("rowStyle", $Style);
    }
//End Set Row Style

//Close departamentos_profesional1_BeforeShowRow @2-66E450A0
    return $departamentos_profesional1_BeforeShowRow;
}
//End Close departamentos_profesional1_BeforeShowRow

//departamentos_profesional1_ds_AfterExecuteSelect @2-CED46C5E
function departamentos_profesional1_ds_AfterExecuteSelect(& $sender)
{
    $departamentos_profesional1_ds_AfterExecuteSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_profesional1; //Compatibility
//End departamentos_profesional1_ds_AfterExecuteSelect

//Custom Code @102-2A29BDB7
// -------------------------
		if($Component->DataSource->Where){
			$q = $Component->DataSource->SQL . " WHERE " . $Component->DataSource->Where;
		}else{
			$q = $Component->DataSource->SQL;
		}

		$q = str_replace("{SQL_Where} {SQL_OrderBy}","",$q);

		$col = array (
		  'tipo_depto_parc_desc'=>'Departamento',
		  'prof_nombre'=>'Profesional',
		  'prof_dni'=>'DNI',
		  'prof_direccion'=>'Direccion',
		  'prof_telefono'=>'Telefono 1',
		  'prof_telefono_celular'=>'Telefono 2',
		  'prof_matricula'=>'Matricula',
		  'prof_matricula_tdf'=>'Mat. CPA. TDF',
		  'tipo_profesional_descrip'=>'Profesion',
		  'prof_mail'=>'email',
		  'tipo_estado_descrip'=>'Estado');

		CCSetSession('qryXls',$q);
		CCSetSession('colXls',$col);
		CCSetSession('nameXls',"Lista de Profesionales");
// -------------------------
//End Custom Code

//Close departamentos_profesional1_ds_AfterExecuteSelect @2-3388083A
    return $departamentos_profesional1_ds_AfterExecuteSelect;
}
//End Close departamentos_profesional1_ds_AfterExecuteSelect

//Page_BeforeInitialize @1-09AD79C1
function Page_BeforeInitialize(& $sender)
{
    $Page_BeforeInitialize = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tc_gridProfesionales; //Compatibility
//End Page_BeforeInitialize

//Custom Code @55-2A29BDB7
// -------------------------

	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");

// -------------------------
//End Custom Code

//Close Page_BeforeInitialize @1-23E6A029
    return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
