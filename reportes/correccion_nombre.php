<?php
define("RelativePath", "..");
include(RelativePath . "/Common.php");

$db = new clsDBtdf_nuevo();
$db2 = new clsDBtdf_nuevo();
$SQL="SELECT persona_id, persona_denominacion, persona_nombre FROM personas WHERE persona_denominacion LIKE '% y o%'";
$db->query($SQL);
while($db->next_record()){
 $denominacion = split(" Y ",$db->f('persona_denominacion'));
 $nombre = split(" Y ",$db->f('persona_nombre'));
 $persona_id = $db->f('persona_id');
 $persona_denominacion = trim($denominacion[0]);
 $persona_nombre = trim($nombre[0]);
 $SQL="UPDATE personas SET persona_denominacion = '".mysql_real_escape_string($persona_denominacion)."', persona_nombre = '".mysql_real_escape_string($persona_nombre)."' WHERE persona_id = $persona_id";
 echo $SQL."<br>";
 $db2->query($SQL);
}
$db->close();
$db2->close();
?>