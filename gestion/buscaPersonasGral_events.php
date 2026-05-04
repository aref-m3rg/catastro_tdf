<?php
//BindEvents Method @1-D10E8760
function BindEvents()
{
  global $personas;
  global $personasSearch;
  global $CCSEvents;
  $personas->ImageLink1->CCSEvents["BeforeShow"] = "personas_ImageLink1_BeforeShow";
  $personas->CCSEvents["BeforeShowRow"] = "personas_BeforeShowRow";
  $personasSearch->s_persona_denominacion->CCSEvents["BeforeShow"] = "personasSearch_s_persona_denominacion_BeforeShow";
  $personasSearch->s_persona_nro_doc->CCSEvents["BeforeShow"] = "personasSearch_s_persona_nro_doc_BeforeShow";
  $personasSearch->ButtonCancel->CCSEvents["OnClick"] = "personasSearch_ButtonCancel_OnClick";
}
//End BindEvents Method

//personas_ImageLink1_BeforeShow @54-DE30DA77
function personas_ImageLink1_BeforeShow(& $sender)
{
  $personas_ImageLink1_BeforeShow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $personas; //Compatibility
//End personas_ImageLink1_BeforeShow

//Custom Code @90-2A29BDB7
// -------------------------


  /* Modifica el enlace de selección para volver a la pág. de origen con el parámetro de la pers. seleccionada */

  $returnPage = rawurldecode( CCGetParam('return_page') ); // debug( $returnPage );
  $returnParams = rawurldecode( CCGetParam('return_params') ); // debug( $returnParams );
  $returnKey = CCGetParam('return_key');
  $newLink = $returnPage . '?' . CCAddParam( $returnParams, $returnKey, $Container->ds->f('persona_id') ); //debug($newLink);

  $Component->SetLink( $newLink );


// -------------------------
//End Custom Code

//Close personas_ImageLink1_BeforeShow @54-3427109F
  return $personas_ImageLink1_BeforeShow;
}
//End Close personas_ImageLink1_BeforeShow

//personas_BeforeShowRow @5-B025649C
function personas_BeforeShowRow(& $sender)
{
  $personas_BeforeShowRow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $personas; //Compatibility
//End personas_BeforeShowRow

//Set Row Style @81-982C9472
  $styles = array("Row", "AltRow");
  if (count($styles)) {
    $Style = $styles[($Component->RowNumber - 1) % count($styles)];
    if (strlen($Style) && !strpos($Style, "="))
      $Style = (strpos($Style, ":") ? 'style="' : 'class="'). $Style . '"';
    $Component->Attributes->SetValue("rowStyle", $Style);
  }
//End Set Row Style

//Close personas_BeforeShowRow @5-514EF97B
  return $personas_BeforeShowRow;
}
//End Close personas_BeforeShowRow

//personasSearch_s_persona_denominacion_BeforeShow @10-4D1AC52B
function personasSearch_s_persona_denominacion_BeforeShow(& $sender)
{
  $personasSearch_s_persona_denominacion_BeforeShow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $personasSearch; //Compatibility
//End personasSearch_s_persona_denominacion_BeforeShow

//PTAutocomplete1 BeforeShow @77-AD508C4D
  $Component->Attributes->SetValue('id', 'personasSearchs_persona_denominacion');
//End PTAutocomplete1 BeforeShow

//Close personasSearch_s_persona_denominacion_BeforeShow @10-830CF826
  return $personasSearch_s_persona_denominacion_BeforeShow;
}
//End Close personasSearch_s_persona_denominacion_BeforeShow

//personasSearch_s_persona_nro_doc_BeforeShow @9-423444F0
function personasSearch_s_persona_nro_doc_BeforeShow(& $sender)
{
  $personasSearch_s_persona_nro_doc_BeforeShow = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $personasSearch; //Compatibility
//End personasSearch_s_persona_nro_doc_BeforeShow

//PTAutocomplete2 BeforeShow @79-FA92BE47
  $Component->Attributes->SetValue('id', 'personasSearchs_persona_nro_doc');
//End PTAutocomplete2 BeforeShow

//Close personasSearch_s_persona_nro_doc_BeforeShow @9-B8973565
  return $personasSearch_s_persona_nro_doc_BeforeShow;
}
//End Close personasSearch_s_persona_nro_doc_BeforeShow

//personasSearch_ButtonCancel_OnClick @53-D57EA9EB
function personasSearch_ButtonCancel_OnClick(& $sender)
{
  $personasSearch_ButtonCancel_OnClick = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $personasSearch; //Compatibility
//End personasSearch_ButtonCancel_OnClick

//Custom Code @80-2A29BDB7
// -------------------------

  /* Vuelve a la página de origen sin el parámetro solicitado */
  
  global $Redirect;
  $returnPage = rawurldecode( CCGetParam('return_page') ); // debug( $returnPage );
  $returnParams = rawurldecode( CCGetParam('return_params') ); // debug( $returnParams );
  $Redirect = $returnPage . '?' . $returnParams;


// -------------------------
//End Custom Code

//Close personasSearch_ButtonCancel_OnClick @53-F76ADF3B
  return $personasSearch_ButtonCancel_OnClick;
}
//End Close personasSearch_ButtonCancel_OnClick

//Page_BeforeInitialize @1-963D8C35
function Page_BeforeInitialize(& $sender)
{
  $Page_BeforeInitialize = true;
  $Component = & $sender;
  $Container = & CCGetParentContainer($sender);
  global $buscaPersonasGral; //Compatibility
//End Page_BeforeInitialize

//Custom Code @88-2A29BDB7
// -------------------------

  	// Incluye el archivo de funciones generales
	include_once(RelativePath . "/scripts/myFunctions.php");


	// Incluye la gestión de permisos
	include_once(RelativePath . "/scripts/permisos1.php");


// -------------------------
//End Custom Code

//PTAutocomplete1 Initialization @77-76FD2921
  global $Charset;
  if ('personasSearchs_persona_denominacionPTAutocomplete1' == CCGetParam('callbackControl')) {
    $Service = new Service();
    $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete1 Initialization

//PTAutocomplete1 DataSource @77-56918E0F
    $Service->DataSource = new clsDBtdf_nuevo();
    $Service->ds = & $Service->DataSource;
    $Service->DataSource->SQL = "SELECT * \n" .
"FROM personas {SQL_Where} {SQL_OrderBy}";
    $Service->DataSource->Parameters["posts_persona_denominacion"] = CCGetFromPost("s_persona_denominacion", NULL);
    $Service->DataSource->wp = new clsSQLParameters();
    $Service->DataSource->wp->AddParameter("1", "posts_persona_denominacion", ccsText, "", "", $Service->DataSource->Parameters["posts_persona_denominacion"], -1, false);
    $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "persona_denominacion", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
    $Service->DataSource->Where = 
       $Service->DataSource->wp->Criterion[1];
    $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete1 DataSource

//PTAutocomplete1 Charset @77-4F7C968C
    $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete1 Charset

//PTAutocomplete1 DataFields @77-F1FB86B5
    $Service->AddDataSourceField('persona_denominacion');
//End PTAutocomplete1 DataFields

//PTAutocomplete1 Execution @77-D749E478
    $Service->DisplayHeaders();
    echo $Service->Execute();
//End PTAutocomplete1 Execution

//PTAutocomplete1 Tail @77-27890EF8
    exit;
  }
//End PTAutocomplete1 Tail

//PTAutocomplete2 Initialization @79-E84E6CBA
  global $Charset;
  if ('personasSearchs_persona_nro_docPTAutocomplete2' == CCGetParam('callbackControl')) {
    $Service = new Service();
    $Service->SetFormatter(new ListFormatter());
//End PTAutocomplete2 Initialization

//PTAutocomplete2 DataSource @79-6229DCA5
    $Service->DataSource = new clsDBtdf_nuevo();
    $Service->ds = & $Service->DataSource;
    $Service->DataSource->SQL = "SELECT * \n" .
"FROM personas {SQL_Where} {SQL_OrderBy}";
    $Service->DataSource->Parameters["posts_persona_nro_doc"] = CCGetFromPost("s_persona_nro_doc", NULL);
    $Service->DataSource->wp = new clsSQLParameters();
    $Service->DataSource->wp->AddParameter("1", "posts_persona_nro_doc", ccsText, "", "", $Service->DataSource->Parameters["posts_persona_nro_doc"], -1, false);
    $Service->DataSource->wp->Criterion[1] = $Service->DataSource->wp->Operation(opBeginsWith, "persona_nro_doc", $Service->DataSource->wp->GetDBValue("1"), $Service->DataSource->ToSQL($Service->DataSource->wp->GetDBValue("1"), ccsText),false);
    $Service->DataSource->Where = 
       $Service->DataSource->wp->Criterion[1];
    $Service->SetDataSourceQuery(CCBuildSQL($Service->DataSource->SQL, $Service->DataSource->Where, $Service->DataSource->Order));
//End PTAutocomplete2 DataSource

//PTAutocomplete2 Charset @79-4F7C968C
    $Service->AddHttpHeader("Content-type", "text/html; charset=" . $Charset);
//End PTAutocomplete2 Charset

//PTAutocomplete2 DataFields @79-E987230F
    $Service->AddDataSourceField('persona_nro_doc');
//End PTAutocomplete2 DataFields

//PTAutocomplete2 Execution @79-D749E478
    $Service->DisplayHeaders();
    echo $Service->Execute();
//End PTAutocomplete2 Execution

//PTAutocomplete2 Tail @79-27890EF8
    exit;
  }
//End PTAutocomplete2 Tail

//Close Page_BeforeInitialize @1-23E6A029
  return $Page_BeforeInitialize;
}
//End Close Page_BeforeInitialize


?>
