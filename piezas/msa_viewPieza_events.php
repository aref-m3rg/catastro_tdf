<?php
//BindEvents Method @1-C2EB1BD2
function BindEvents()
{
  global $piezas_piezas_tipos_trami;
  $piezas_piezas_tipos_trami->print->CCSEvents["BeforeShow"] = "piezas_piezas_tipos_trami_print_BeforeShow";
  $piezas_piezas_tipos_trami->CCSEvents["BeforeShowRow"] = "piezas_piezas_tipos_trami_BeforeShowRow";
}
//End BindEvents Method

//piezas_piezas_tipos_trami_print_BeforeShow @41-325D0CDE
function piezas_piezas_tipos_trami_print_BeforeShow(& $sender)
{
  $piezas_piezas_tipos_trami_print_BeforeShow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $piezas_piezas_tipos_trami; //Compatibility
//End piezas_piezas_tipos_trami_print_BeforeShow

//Close piezas_piezas_tipos_trami_print_BeforeShow @41-76163D7A
  return $piezas_piezas_tipos_trami_print_BeforeShow;
}
//End Close piezas_piezas_tipos_trami_print_BeforeShow

//piezas_piezas_tipos_trami_BeforeShowRow @4-D0B61AF7
function piezas_piezas_tipos_trami_BeforeShowRow(& $sender)
{
  $piezas_piezas_tipos_trami_BeforeShowRow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $piezas_piezas_tipos_trami; //Compatibility
//End piezas_piezas_tipos_trami_BeforeShowRow

//Custom Code @45-2A29BDB7
// -------------------------
    // Write your own code here.

		
	//Donde tiene que ir?
	switch($Component->ds->f('tipo')){
		case 1://Expediente
			$lnk_edit = "msa_editExp.php?pieza_id=" . CCGetParam('pieza_id');
			$lnk_print = "Scripts/scr_expPdf.php?pieza_id=" . CCGetParam('pieza_id');
			break;
		case 2://Nota
			$lnk_edit = "msa_editNota.php?pieza_id=" . CCGetParam('pieza_id');
			$lnk_print = "Scripts/scr_notaPdf.php?pieza_id=" . CCGetParam('pieza_id');

	}

	$Component->print->SetLink($lnk_print);
	$Component->edit->SetLink($lnk_edit);
	
	//ahora mostrarlos..
	//si tiene mas de una pase o no es la unidad creadora
	//no puede imprimir ni editar
	$pases = CCDLookUp("COUNT(*)","pases","pieza_id = " . CCGetParam('pieza_id'),new clsDBmesa());
	//echo "$pases<br>";
	//echo $Component->ds->f('unidad_id') . " - ";
	//echo CCGetSession(unidad_id);
	if(($pases > 1) || ($Component->ds->f('unidad_id') <> CCGetSession(unidad_id))){
		//esconder paneles
		$Component->imprimir->Visible = false;
		$Component->editar->Visible = false;
	}



// -------------------------
//End Custom Code

//Close piezas_piezas_tipos_trami_BeforeShowRow @4-9DE4BE72
  return $piezas_piezas_tipos_trami_BeforeShowRow;
}
//End Close piezas_piezas_tipos_trami_BeforeShowRow
?>
