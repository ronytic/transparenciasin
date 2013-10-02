<?php
include_once("../impresion/pdf.php");
$titulo="Datos del Contribuyente";
$id=$_GET['id'];
class PDF extends PPDF{
	
}

include_once("../class/persona.php");
$persona=new persona;
$pers=array_shift($persona->mostrar($id));


$pdf=new PDF("P","mm","letter");

$pdf->AddPage();
mostrarI(array("Cédula de Identidad"=>$pers['cedula_id'],
				"Paterno"=>ucwords($pers['ap_paterno']),
				"Materno"=>ucwords($pers['ap_materno']),
				"Nombres"=>ucwords($pers['nombres']),
				"Nit"=>$pers['nit'],
				"Razon Social"=>$pers['razon_social'],
				"Tipo de Persona"=>$pers['tipo_persona'],
			));

/*$foto="../foto/".$emp['foto'];
if(!empty($emp['foto']) && file_exists($foto)){
	$pdf->Image($foto,140,50,40,40);	
}
*/
$pdf->Output();
?>