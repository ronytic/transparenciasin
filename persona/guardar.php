<?php
include_once '../login/check.php';
//print_r($_POST);
$folder="../";
extract($_POST);
$titulo="Busqueda de Personas";
include_once("../class/persona.php");
$persona=new persona;
if($nit!=""){
	$where="nit='$nit'";
	$bodyxml = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <ConsultarDatosContribuyenteActuales xmlns="http://www.impuestos.gob.bo/">
      <mensajeSolicitud>
        <Nit>'.$nit.'</Nit>
      </mensajeSolicitud>
    </ConsultarDatosContribuyenteActuales>
  </soap:Body>
</soap:Envelope>
';
}else{
	$bodyxml = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <ConsultarDatosPersonaNatural xmlns="http://www.impuestos.gob.bo/">
      <mensajeSolicitud>
        <Cedula>'.$Ci.'</Cedula>
        <ApellidoPaterno>'.$Paterno.'</ApellidoPaterno>
        <ApellidoMaterno>'.$Materno.'</ApellidoMaterno>
        <Nombres>'.$Nombres.'</Nombres>
      </mensajeSolicitud>
    </ConsultarDatosPersonaNatural>
  </soap:Body>
</soap:Envelope>
';
	$where="(cedula_id='$Ci' and ap_paterno='$Paterno' and ap_materno='$Materno' and nombres='$Nombres')";
}
$perso=$persona->mostrarTodos($where);
/*INICIA SOAP*/

require_once("../lib/nusoap.php");
//echo $ipsoap;

$clientesoap=new nusoap_client($ipsoap, true);
//$parametros=array("IPAddress"=>$ip);
if($nit!=""){
	$parametros=array("Nit"=>$nit);
}else{
	$parametros=array("Cedula"=>$Ci,"ApellidoPaterno"=>$Paterno,"ApellidoMaterno"=>$Materno,"Nombres"=>$Nombres);
}
//$respuesta=$SoapCliente->call("GetGeoIP",$parametros);
if($nit!=""){
	$clientesoap->soap_defencoding = 'utf-8';
	$clientesoap->useHTTPPersistentConnection();
	$clientesoap->setUseCurl($useCURL);
	$respuesta=$clientesoap->send($bodyxml, "http://www.impuestos.gob.bo/ConsultarDatosContribuyenteActuales");
	//$respuesta=array_shift($respuesta);
	//$respuesta=$clientesoap->call("ConsultarDatosContribuyenteActuales",$parametros);
	/*$respuesta=array("ConsultarDatosContribuyenteActualesResult"=>
				array("Nit"=>"789",
					"NombreRazonSocial"=>"Razon Social",
					"Cedula"=>"445566",
					"DescripcionJurisdiccion"=>"Descripcion",
					"DireccionFiscal"=>"DireccionFiscal",
					"FechaInscripcion"=>"20131003",
					"DescripcionEstado"=>"DescripcionEstado",
					"DescripcionRegimen"=>"DescripcionRegimen",
					"ActividadesEconomicas"=>array("MitActividadEconomica"=>
								array("DescripcionActividad"=>"DescripcionActividad",
									"DescripcionTipoActividad"=>"DescripcionTipoActividad",
									"FechaDesde"=>"FechaDesde",
									"FechaHasta"=>"FechaHasta"
								)
					),
					"ObligacionesTributarias"=>array("MitObligacionTributaria"=>
							array("DescripcionObligacion"=>"DescripcionObligacion",
								"FechaDesde"=>"FechaDesde",
								"FechaHasta"=>"FechaHasta",
								
							)
					),
					"PersonasContribuyente"=>array("MitPersonasContribuyente"=>
							array("Cedula"=>"Cedula",
								"NombreCompleto"=>"NombreCompleto",
							)
					)
				)
			);*/	
}else{
	$clientesoap->soap_defencoding = 'utf-8';
	$clientesoap->useHTTPPersistentConnection();
	$clientesoap->setUseCurl($useCURL);
	$respuesta=$clientesoap->send($bodyxml, "http://www.impuestos.gob.bo/ConsultarDatosPersonaNatural");
	$respuesta=array_shift($respuesta);
	

	$respuesta=$respuesta['MitPersonaNatural'];
	/*$respuesta=array("MitPersonaNatural"=>
				array("Nit"=>"123",
					"RazonSocial"=>"Razon Social",
					"DescripcionTipoPersona"=>"Descripcion"
				)
	);*/
}
//print_r($respuesta);
/*FIN DE SOAP*/
if(!is_array($respuesta)){
	$respuesta=array();
}

include_once '../funciones/funciones.php';
include_once '../cabecerahtml.php';
?>
<?php include_once '../cabecera.php';?>
<div class="grid_12">
	<div class="contenido">
    	<div class="prefix_0 grid_11">
                <table class="tablalistado">
                <tr class="cabecera"><td colspan="5">Datos Ingresados para Búsqueda</td></tr>
                <tr class="cabecera"><td>Cédula de Identidad</td><td>Paterno</td><td>Materno</td><td>Nombres</td><td>Nit</td></tr>
                <tr class="contenido"><td><?php echo $Ci?$Ci:'--------'?></td><td><?php echo capitalizar($Paterno)?capitalizar($Paterno):'--------'?></td><td><?php echo capitalizar($Materno)?capitalizar($Materno):'--------'?></td><td><?php echo capitalizar($Nombres)?capitalizar($Nombres):'--------'?></td><td><?php echo $nit?></td></tr>
                </table>
			<fieldset>
				<div class="titulo">Personas encontradas en Base de Datos Ministerio Transparencia</div>
                <?php
                $titulo=array("cedula_id"=>"Cédula Identidad","ap_paterno"=>"Paterno","ap_materno"=>"Materno","nombres"=>"Nombres","nit"=>"Nit","fecha_reg"=>"Fecha de Búsqueda","hora_reg"=>"Hora de Búsqueda");
				listadoTabla($titulo,$perso,1,"","","ver.php",array("Ver Datos"=>"datos.php"),array(),"_blank");
				?>
			</fieldset>
            <fieldset>
				<div class="titulo">Personas encontradas en Base de Datos de Servicios de Impuestos Nacionales</div>
				<?php //print_r($respuesta);?>
               <table border="1" class="tablalistado">
               	<tr class="cabecera"><td>N</td><td>Nit</td><td>Razon Social</td><td>Descripcion Tipo Persona</td></tr>
				<?php $i=0;

				foreach($respuesta as $datos){$i++;
				//print_r($datos);
				?>
    			<tr class="contenido">
                	<td><?php echo $i?></td>
                    <td><?php echo $datos['Nit']?></td>
                    <td><?php echo $nit?$datos['NombreRazonSocial']:$datos['RazonSocial']?></td>
                    <td><?php echo $nit?$datos['DescripcionTipoPersona']:$datos['DescripcionTipoPersona']?></td>
                    <td><a href="gdatospadron.php?ci=<?php echo $Ci?>&paterno=<?php echo capitalizar($Paterno)?>&materno=<?php echo capitalizar($Materno)?>&nombres=<?php echo capitalizar($Nombres)?>&nit=<?php echo $datos['Nit']?>" target="_blank" class="botonmostazapequeno">Ver Datos Persona</a></td>
                    <!--<td><a href="indexextracto.php?nit=<?php echo $datos['Nit']?>" target="_blank" class="botonmostazapequeno">Extracto Tributario</a></td>-->
    			</tr>
    			<?php }?>
				</table>
			</fieldset>
            
		</div>
    	<div class="clear"></div>
    </div>
</div>
<?php include_once '../piepagina.php';?>