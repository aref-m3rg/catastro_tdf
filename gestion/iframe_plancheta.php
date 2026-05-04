<?php
//Include Common Files @1-F0F75090
define("RelativePath", "..");
define("PathToCurrentPage", "/gestion/");
define("FileName", "iframe_plancheta.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @3-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Include Page implementation @5-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Initialize Page @1-C707D4D6
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "iframe_plancheta.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "../";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-4EB2F842
include_once("./iframe_plancheta_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-C4C16F02
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("../", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_menu = new clstdf_menu("../", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$iframe_plancheta = new clsControl(ccsLabel, "iframe_plancheta", "iframe_plancheta", ccsText, "", CCGetRequestParam("iframe_plancheta", ccsGet, NULL), $MainPage);
$iframe_plancheta->HTML = true;
$tdf_footer = new clstdf_footer("../", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->iframe_plancheta = & $iframe_plancheta;
$MainPage->tdf_footer = & $tdf_footer;

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-52F9C312
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "../");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-1BB09E23
$tdf_header->Operations();
$tdf_menu->Operations();
$tdf_footer->Operations();
//End Execute Components

//Go to destination page @1-7A92C57E
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-39CDD0AF
$tdf_header->Show();
$tdf_menu->Show();
$tdf_footer->Show();
$iframe_plancheta->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
if(preg_match("/<\/body>/i", $main_block)) {
    $main_block = preg_replace("/<\/body>/i", implode(array("<center><font face=\"Arial\"", "><small>&#71;&#101;n&#101", ";r&#97;&#116;ed <!-- SCC ", "-->wit&#104; <!-- SCC -->", "C&#111;d&#101;&#67;&#104", ";&#97;&#114;&#103;&#1", "01; <!-- CCS -->S&#116", ";udi&#111;.</small></font>", "</center>"), "") . "</body>", $main_block);
} else if(preg_match("/<\/html>/i", $main_block) && !preg_match("/<\/frameset>/i", $main_block)) {
    $main_block = preg_replace("/<\/html>/i", implode(array("<center><font face=\"Arial\"", "><small>&#71;&#101;n&#101", ";r&#97;&#116;ed <!-- SCC ", "-->wit&#104; <!-- SCC -->", "C&#111;d&#101;&#67;&#104", ";&#97;&#114;&#103;&#1", "01; <!-- CCS -->S&#116", ";udi&#111;.</small></font>", "</center>"), "") . "</html>", $main_block);
} else if(!preg_match("/<\/frameset>/i", $main_block)) {
    $main_block .= implode(array("<center><font face=\"Arial\"", "><small>&#71;&#101;n&#101", ";r&#97;&#116;ed <!-- SCC ", "-->wit&#104; <!-- SCC -->", "C&#111;d&#101;&#67;&#104", ";&#97;&#114;&#103;&#1", "01; <!-- CCS -->S&#116", ";udi&#111;.</small></font>", "</center>"), "");
}
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-EC725EB2
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
unset($Tpl);
//End Unload Page


?>
