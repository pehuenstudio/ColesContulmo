<?php
echo "<br/>".dirname(__FILE__)."\\".basename(__FILE__)."<br/>";

require_once($_SERVER["DOCUMENT_ROOT"]."/code/modelos/Usuarios/Usuario.php");

class Profesor extends Usuario{

}

?>