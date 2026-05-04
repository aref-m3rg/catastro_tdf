<?php
//BindEvents Method @1-1C1322E9
function BindEvents()
{
    global $departamentos_planchetas;
    $departamentos_planchetas->CCSEvents["BeforeShowRow"] = "departamentos_planchetas_BeforeShowRow";
}
//End BindEvents Method

//departamentos_planchetas_BeforeShowRow @2-39A73C7D
function departamentos_planchetas_BeforeShowRow(& $sender)
{
    $departamentos_planchetas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $departamentos_planchetas; //Compatibility
//End departamentos_planchetas_BeforeShowRow

//Custom Code @24-2A29BDB7
// -------------------------
    // Write your own code here.
	if($Component->ds->f('plancheta_file')){
		$archivo = $Component->ds->f('plancheta_file');
		$htm = '<a class="" target="foto" href="archivos/' . $archivo . '"><img border="0" class=""  src="' . RelativePath . '/phpThumb/phpThumb.php?src=/planchetas/archivos/' . $archivo . '&w=450"></a>';
		
	} else {
		$htm = "Sin Imagen";
	}

	$Component->htm->SetValue($htm);
// -------------------------
//End Custom Code

//Close departamentos_planchetas_BeforeShowRow @2-8A6CECFE
    return $departamentos_planchetas_BeforeShowRow;
}
//End Close departamentos_planchetas_BeforeShowRow


?>
