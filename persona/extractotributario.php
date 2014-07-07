<?php
include_once("../impresion/pdf.php");
$titulo="Extracto Tributario";
$id=$_GET['id'];
$nit=$_GET['nit'];
class PDF extends PPDF{
	function Cabecera(){
		global $dp,$pers;	
		$this->CuadroCabecera(20,"Juridicción:",40,$dp['jurisdiccion']);
		$this->ln();
		$this->CuadroCabecera(10,"Nit:",40,$dp['nit']);
		$this->CuadroCabecera(25,"Razon Social:",45,$pers['razon_social']);
		$this->ln();
		$this->CuadroCabecera(20,"Dirección:",160,$dp['direccion_fiscal']);
		$this->ln();
		$this->TituloCabecera(8,"Nro.","8");
		$this->TituloCabecera(15,"Periodo Mes","7");
		$this->TituloCabecera(15,"Periodo Año","7");
		$this->TituloCabecera(20,"Fecha Pago","8");
		$this->TituloCabecera(20,"Número de Orden","7");
		$this->TituloCabecera(20,"Importe Pagado","7");
		$this->TituloCabecera(20,"Monto Declarado","7");
		$this->TituloCabecera(17,"Otro Pagos","8");
		$this->TituloCabecera(23,"DD. JJ Rectificada","7");
		$this->TituloCabecera(30,"Banco","8");
	}
}

include_once("../class/persona.php");
$persona=new persona;
include_once("../class/datospadron.php");
$datospadron=new datos_padron;
include_once("../class/extracto.php");
$extracto=new extracto;


$dp=$datospadron->mostrarTodos("cod_persona_natural=$id and nit='$nit'");
$dp=array_shift($dp);

$pers=array_shift($persona->mostrar($id));

$ext=$extracto->mostrarTodos("cod_persona_natural=$id and nit='$nit'","desc_formulario");

$ext1=$ext;

$ex=array_shift($ext1);
$TipoFormulario=$ex['desc_formulario'];

$pdf=new PDF("P","mm","letter");
$pdf->Fuente("","8");
$pdf->AddPage();

//$pdf->Linea();
$pdf->ln();
if(count($ext)){
	$i=0;
	
	$pdf->ln();
	$pdf->CuadroCuerpo(8,"Formulario: ".$TipoFormulario,0,"L",0,"8");
	$pdf->ln();
	foreach($ext as $e){$i++;
	if($TipoFormulario!=$e['desc_formulario']){
		
		$TipoFormulario=$e['desc_formulario'];
		$pdf->CuadroCuerpo(8,"Formulario: ".$TipoFormulario,0,"L",0,"8");
		$pdf->ln();	
	}
		$pdf->CuadroCuerpo(8,$i,0,"R",1,"8");
		$pdf->CuadroCuerpo(15,$e['mes_extracto'],0,"R",1,"8");		
		$pdf->CuadroCuerpo(15,$e['anio_extracto'],0,"R",1,"8");	
		$pdf->CuadroCuerpo(20,$e['fecha_pago'],0,"R",1,"8");	
		$pdf->CuadroCuerpo(20,$e['num_orden'],0,"R",1,"8");	
		$pdf->CuadroCuerpo(20,$e['importe_efectivo'],0,"R",1,"8");	
		$pdf->CuadroCuerpo(20,$e['importe_valores'],0,"R",1,"8");	
		$pdf->CuadroCuerpo(17,$e['importe_otros'],0,"R",1,"8");	
		$pdf->CuadroCuerpo(23,$e['num_rectificado'],0,"R",1,"8");	
		$pdf->CuadroCuerpo(30,$e['banco_extracto'],0,"",1,"7");
		$pdf->ln();
	}
}else{
	$pdf->CuadroCuerpo(60,"No Existen Actividades",0,"",0);
}
$pdf->ln();


/*$foto="../foto/".$emp['foto'];
if(!empty($emp['foto']) && file_exists($foto)){
	$pdf->Image($foto,140,50,40,40);	
}
*/
$pdf->Output();
?>