<?php
include_once("bd.php");
class usuarios extends bd{
	var $tabla="usuario";
	function loginUsuarios($Usuario,$Password){
		$this->campos=array("count(*) as Can,cod_usuario");	
		return $this->getRecords("usuario='$Usuario' and contrasena='$Password' and activo=1");
	}
	function mostrars($cod){
		$this->campos=array("*");	
		return $this->getRecords("cod_usuario='$cod' and activo=1");
	}
}
?>