<?php
include_once("../login/check.php");
//print_r($_POST);
extract($_POST);
$parametros=array("Nit"=>$nit,
				"PeriodoDesde"=>$PeriodoDesde,
				"PeriodoHasta"=>$PeriodoHasta,
);
$bodyxml = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <ConsultarExtractoTributario xmlns="http://www.impuestos.gob.bo/">
      <mensajeSolicitud>
        <Nit>'.$nit.'</Nit>
        <PeriodoDesde>'.$PeriodoDesde.'</PeriodoDesde>
        <PeriodoHasta>'.$PeriodoHasta.'</PeriodoHasta>
      </mensajeSolicitud>
    </ConsultarExtractoTributario>
  </soap:Body>
</soap:Envelope>
';
include_once("../class/extracto.php");
$extracto=new extracto;
include_once("../config.php");
require_once("../lib/nusoap.php");
$clientesoap=new nusoap_client($ipsoap,true);
//$respuesta=$clientesoap->call("ConsultarExtractoTributario",$parametros);
$clientesoap->soap_defencoding = 'utf-8';
	$clientesoap->useHTTPPersistentConnection();
	$clientesoap->setUseCurl($useCURL);
	$respuesta=$clientesoap->send($bodyxml, "http://www.impuestos.gob.bo/ConsultarExtractoTributario");
	$respuesta=array_shift($respuesta);
	$respuesta=array_shift($respuesta);
	$respuesta=$respuesta['MitExtractoTributario'];
	//print_r($respuesta);
/*$respuesta=array("DetalleExtractoTributario"=>
				array("MitExtractoTributario"=>
					array("Anio"=>"2007",
						"Mes"=>"03",
						"DescripcionFormulario"=>"IVA-101",
						"FechaPago"=>"20070403",
						"NumeroOrden"=>"10123",
						"ImporteEnEfectivo"=>"0",
						"ImporteEnValores"=>"0",
						"ImporteOtros"=>"0",
						"NumeroOrdenRectificada"=>"NumeroOrdenRectificada",
						"DescripcionBanco"=>"Banco Sol",
					)
				),
				array("MitExtractoTributario"=>
					array("Anio"=>"2007",
						"Mes"=>"04",
						"DescripcionFormulario"=>"IT-103",
						"FechaPago"=>"20070404",
						"NumeroOrden"=>"10124",
						"ImporteEnEfectivo"=>"0",
						"ImporteEnValores"=>"0",
						"ImporteOtros"=>"0",
						"NumeroOrdenRectificada"=>"NumeroOrdenRectificada",
						"DescripcionBanco"=>"Banco Union",
					)
				)
			);*/
//print_r($respuesta);
/*?><table border="1"><tr><td>Nit</td><td>Razon Social</td><td>Descripcion Tipo Persona</td></tr><?php*/
if(count($respuesta)==1){
?>
<h3>No existen datos</h3>
<?php
exit();
};

foreach($respuesta as $datos){
	//print_r($datos);
	$dato=($datos);
	$vextracto=array("cod_persona_natural"=>"'".$cod_persona_natural."'",
					"nit"=>"'".$nit."'",
					"anio_extracto"=>"'".$dato['Anio']."'",
					"mes_extracto"=>"'".$dato['Mes']."'",
					"desc_formulario"=>"'".$dato['DescripcionFormulario']."'",
					"fecha_pago"=>"'".$dato['FechaPago']."'",
					"num_orden"=>"'".$dato['NumeroOrden']."'",
					"importe_efectivo"=>"'".$dato['ImporteEnEfectivo']."'",
					"importe_valores"=>"'".$dato['ImporteEnValores']."'",
					"importe_otros"=>"'".$dato['ImporteOtros']."'",
					"num_rectificado"=>"'".$dato['NumeroOrdenRectificada']."'",
					"banco_extracto"=>"'".$dato['DescripcionBanco']."'",
					);
	$extracto->insertar($vextracto);
	/*?>
    <tr>
    	<td><?php echo $datos['MitExtractoTributario']['Anio']?></td>
        <td><?php echo $datos['MitExtractoTributario']['Mes']?></td>
		<td><?php echo $datos['MitExtractoTributario']['DescripcionFormulario']?></td>
		<td><?php echo $datos['MitExtractoTributario']['FechaPago']?></td>
		<td><?php echo $datos['MitExtractoTributario']['NumeroOrden']?></td>
		<td><?php echo $datos['MitExtractoTributario']['ImporteEnEfectivo']?></td>
		<td><?php echo $datos['MitExtractoTributario']['ImporteEnValores']?></td>
		<td><?php echo $datos['MitExtractoTributario']['ImporteOtros']?></td>
		<td><?php echo $datos['MitExtractoTributario']['NumeroOrdenRectificada']?></td>
		<td><?php echo $datos['MitExtractoTributario']['DescripcionBanco']?></td>
    </tr>
    <?php */
}
/*?>
</table>
<?php */
header("Location:extractotributario.php?id=$cod_persona_natural&nit=$nit");
?>