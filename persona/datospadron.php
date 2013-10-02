<?php
include_once("../impresion/pdf.php");
$titulo="Datos del Padron";
$id=$_GET['id'];
$nit=$_GET['nit'];
class PDF extends PPDF{
}

include_once("../class/persona.php");
$persona=new persona;
include_once("../class/datospadron.php");
$datospadron=new datos_padron;
include_once("../class/obligacion.php");
$obligacion=new obligacion;
include_once("../class/personas.php");
$personas=new personas;
include_once("../class/actividad.php");
$actividad=new actividad;


$dp=$datospadron->mostrarTodos("cod_persona_natural=$id and nit='$nit'");
$dp=array_shift($dp);

$pers=array_shift($persona->mostrar($id));

$act=$actividad->mostrarTodos("cod_persona_natural=$id and nit='$nit'");


$perso=$personas->mostrarTodos("cod_persona_natural=$id and nit='$nit'");


$obli=$obligacion->mostrarTodos("cod_persona_natural=$id and nit='$nit'");


$pdf=new PDF("P","mm","letter");

$pdf->AddPage();
mostrarI(array("Cédula de Identidad"=>$pers['cedula_id'],
				"Paterno"=>ucwords($pers['ap_paterno']),
				"Materno"=>ucwords($pers['ap_materno']),
				"Nombres"=>ucwords($pers['nombres']),
				"Nit"=>$pers['nit'],
				"Razon Social"=>$pers['razon_social'],
				"Tipo de Persona"=>$pers['tipo_persona'],
				"Juridicción"=>$dp['jurisdiccion'],
				"Dirección Fiscal"=>$dp['direccion_fiscal'],
				"Fecha de Inscripción"=>fecha2Str($dp['fecha_incripcion']),
				"Estado"=>$dp['estado'],
				"Régimen"=>$dp['regimen'],
			));

//$pdf->Linea();
$pdf->CuadroCuerpoResaltar(185,"Actividad Económica",1,"",0);
$pdf->ln();
$pdf->ln();
if(count($act)){
	$i=0;
	$pdf->CuadroCuerpoResaltar(5,"N",1,"",1,3);
	$pdf->CuadroCuerpoResaltar(70,"Descripción Actividad",1,"",1,3);
	$pdf->CuadroCuerpoResaltar(60,"Tipo de Actividad",1,"",1,3);
	$pdf->CuadroCuerpoResaltar(25,"FechaDesde",1,"",1,3);
	$pdf->CuadroCuerpoResaltar(25,"FechaHasta",1,"",1,3);
	$pdf->ln();
	foreach($act as $a){$i++;
		$pdf->CuadroCuerpo(5,$i,0,"R",1);	
		$pdf->CuadroCuerpo(70,$a['desc_actividad'],0,"",1);	
		$pdf->CuadroCuerpo(60,$a['tipo_actividad'],0,"",1);
		$pdf->CuadroCuerpo(25,fecha2Str($a['act_fecha_desde']),0,"",1);
		$pdf->CuadroCuerpo(25,fecha2Str($a['act_fecha_hasta']),0,"",1);
		$pdf->ln();
	}
}else{
	$pdf->CuadroCuerpo(60,"No Existen Actividades",0,"",0);
}
$pdf->ln();

//$pdf->Linea();
$pdf->CuadroCuerpoResaltar(185,"Obligaciones Tributarias",1,"",0);
$pdf->ln();
$pdf->ln();
if(count($obli)){
	$i=0;
	$pdf->CuadroCuerpoResaltar(5,"N",1,"",1,3);
	$pdf->CuadroCuerpoResaltar(130,"Descripción",1,"",1,3);
	$pdf->CuadroCuerpoResaltar(25,"FechaDesde",1,"",1,3);
	$pdf->CuadroCuerpoResaltar(25,"FechaHasta",1,"",1,3);
	$pdf->ln();
	foreach($obli as $o){$i++;
		$pdf->CuadroCuerpo(5,$i,0,"R",1);	
		$pdf->CuadroCuerpo(130,$o['obli_descripcion'],0,"",1);	
		$pdf->CuadroCuerpo(25,fecha2Str($o['obli_fecha_desde']),0,"",1);
		$pdf->CuadroCuerpo(25,fecha2Str($o['obli_fecha_hasta']),0,"",1);
		$pdf->ln();
	}
}else{
	$pdf->CuadroCuerpo(60,"No Existen Obligaciones Tributarias",0,"",0);
}

$pdf->ln();
//$pdf->Linea();
$pdf->CuadroCuerpoResaltar(185,"Personas Contribuyentes",1,"",0);
$pdf->ln();
$pdf->ln();
if(count($perso)){
	$i=0;
	$pdf->CuadroCuerpoResaltar(5,"N",1,"",1,3);
	$pdf->CuadroCuerpoResaltar(40,"Cédula",1,"",1,3);
	$pdf->CuadroCuerpoResaltar(140,"Personas",1,"",1,3);
	$pdf->ln();
	foreach($perso as $p){$i++;
		$pdf->CuadroCuerpo(5,$i,0,"R",1);	
		$pdf->CuadroCuerpo(40,$p['cedula_personas'],0,"",1);	
		$pdf->CuadroCuerpo(140,$p['nombre_personas'],0,"",1);	

		$pdf->ln();
	}
}else{
	$pdf->CuadroCuerpo(60,"No Existen Personas Contribuyentes",0,"",0);
}

/*$foto="../foto/".$emp['foto'];
if(!empty($emp['foto']) && file_exists($foto)){
	$pdf->Image($foto,140,50,40,40);	
}
*/
$pdf->Output();
?>