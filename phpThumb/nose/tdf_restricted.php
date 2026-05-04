<?php
//Include Common Files @1-CE8BE48C
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "tdf_restricted.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//Include Page implementation @2-A8690D39
include_once(RelativePath . "/tdf_header.php");
//End Include Page implementation

//Include Page implementation @3-CD604306
include_once(RelativePath . "/tdf_footer.php");
//End Include Page implementation

//Include Page implementation @5-DC90FFC2
include_once(RelativePath . "/tdf_menu.php");
//End Include Page implementation

//Initialize Page @1-EBA3EFE3
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
$TemplateFileName = "tdf_restricted.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-F75D96E3
include_once("./tdf_restricted_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-818360E4
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$tdf_header = new clstdf_header("", "tdf_header", $MainPage);
$tdf_header->Initialize();
$tdf_footer = new clstdf_footer("", "tdf_footer", $MainPage);
$tdf_footer->Initialize();
$Image1 = new clsControl(ccsImage, "Image1", "Image1", ccsText, "", CCGetRequestParam("Image1", ccsGet, NULL), $MainPage);
$tdf_menu = new clstdf_menu("", "tdf_menu", $MainPage);
$tdf_menu->Initialize();
$usr = new clsControl(ccsLabel, "usr", "usr", ccsText, "", CCGetRequestParam("usr", ccsGet, NULL), $MainPage);
$grp = new clsControl(ccsLabel, "grp", "grp", ccsText, "", CCGetRequestParam("grp", ccsGet, NULL), $MainPage);
$login = new clsControl(ccsLabel, "login", "login", ccsText, "", CCGetRequestParam("login", ccsGet, NULL), $MainPage);
$MainPage->tdf_header = & $tdf_header;
$MainPage->tdf_footer = & $tdf_footer;
$MainPage->Image1 = & $Image1;
$MainPage->tdf_menu = & $tdf_menu;
$MainPage->usr = & $usr;
$MainPage->grp = & $grp;
$MainPage->login = & $login;

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-E710DB26
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-84EEC634
$tdf_header->Operations();
$tdf_footer->Operations();
$tdf_menu->Operations();
//End Execute Components

//Go to destination page @1-0BB81972
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    header("Location: " . $Redirect);
    $tdf_header->Class_Terminate();
    unset($tdf_header);
    $tdf_footer->Class_Terminate();
    unset($tdf_footer);
    $tdf_menu->Class_Terminate();
    unset($tdf_menu);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-863E4C18
$tdf_header->Show();
$tdf_footer->Show();
$tdf_menu->Show();
$Image1->Show();
$usr->Show();
$grp->Show();
$login->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-00C7F815
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$tdf_header->Class_Terminate();
unset($tdf_header);
$tdf_footer->Class_Terminate();
unset($tdf_footer);
$tdf_menu->Class_Terminate();
unset($tdf_menu);
unset($Tpl);
//End Unload Page


?>
