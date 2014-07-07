<?php
include_once("../login/check.php");
extract($_GET);
$parametros=array("Nit"=>$nit,
);
include_once("../config.php");
require_once("../lib/nusoap.php");
$clientesoap=new nusoap_client($ipsoap,true);
$respuesta=$clientesoap->call("ConsultarDatosContribuyenteActuales",$parametros);
$respuesta=array("ConsultarDatosContribuyenteActualesResult"=>
				array("Nit"=>"123",
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
);
include_once("../class/persona.php");
$persona=new persona;

include_once("../class/datospadron.php");
$datos_padron=new datos_padron;

include_once("../class/actividad.php");
$actividad=new actividad;

include_once("../class/obligacion.php");
$obligacion=new obligacion;

include_once("../class/personas.php");
$personas=new personas;

//print_r($respuesta);
/*?><table border="1"><tr><td>Nit</td><td>Razon Social</td><td>Descripcion Tipo Persona</td></tr><?php*/
foreach($respuesta as $datos){
	$vpersona=array("cedula_id"=>"'".$datos['Cedula']."'",
					"ap_paterno"=>"'$paterno'",
					"ap_materno"=>"'$materno'",
					"nombres"=>"'$nombres'",
					"nit"=>"'".$datos['Nit']."'",
					"razon_social"=>"'".$datos['NombreRazonSocial']."'",
					"tipo_persona"=>"'".$datos['DescripcionJurisdiccion']."'",
					);
	$persona->insertar($vpersona);
	$idpersona=$persona->last_id();
	$vdatospadron=array("cod_persona_natural"=>"'".$idpersona."'",
						"nit"=>"'".$datos['Nit']."'",
					"nom_razon_social"=>"'".$datos['NombreRazonSocial']."'",
					"cedula_id"=>"'".$datos['Nit']."'",
					"jurisdiccion"=>"'".$datos['DescripcionJurisdiccion']."'",
					"direccion_fiscal"=>"'".$datos['DireccionFiscal']."'",
					"fecha_incripcion"=>"'".$datos['FechaInscripcion']."'",
					"estado"=>"'".$datos['DescripcionEstado']."'",
					"regimen"=>"'".$datos['DescripcionRegimen']."'",
					);
	$datos_padron->insertar($vdatospadron);
	//echo $idpersona;
	/*?>
    <tr>
    	<td><?php echo $datos['Nit']?></td>
        <td><?php echo $datos['NombreRazonSocial']?></td>
        <td><?php echo $datos['Cedula']?></td>
        <td><?php echo $datos['DescripcionJurisdiccion']?></td>
        <td><?php echo $datos['DireccionFiscal']?></td>
        <td><?php echo $datos['FechaInscripcion']?></td>
        <td><?php echo $datos['DescripcionEstado']?></td>
        <td><?php echo $datos['DescripcionRegimen']?></td>
        <td>
            ActividadesEconomicas
            <table border="1">
            <tr>
            <td>Descrip</td><td>Desc Tipo Persona</td><td>FechaD</td><td>FechaH</td></tr><?php*/
            foreach($datos['ActividadesEconomicas'] as $d){
				$vactividad=array("cod_persona_natural"=>"'".$idpersona."'",
									"nit"=>"'".$datos['Nit']."'",
									"desc_actividad"=>"'".$d['DescripcionActividad']."'",
									"tipo_actividad"=>"'".$d['DescripcionTipoActividad']."'",
									"act_fecha_desde"=>"'".$d['FechaDesde']."'",
									"act_fecha_hasta"=>"'".$d['FechaHasta']."'"
								);
					$actividad->insertar($vactividad);
               /* ?>
                <tr>
                    <td><?php echo $d['DescripcionActividad']?></td>
                    <td><?php echo $d['DescripcionTipoActividad']?></td>
                    <td><?php echo $d['FechaDesde']?></td>
                    <td><?php echo $d['FechaHasta']?></td>
                </tr>
                <?php*/
            }
            /*?>
            </table>
        </td>
        <td>
        	ObligacionesTributarias
            <table border="1">
            <tr>
            <td>Desc</td><td>FeDesde</td><td>FeHasta</td></tr><?php*/
            foreach($datos['ObligacionesTributarias'] as $d){
				$vobligacion=array("cod_persona_natural"=>"'".$idpersona."'",
									"nit"=>"'".$datos['Nit']."'",
									"obli_descripcion"=>"'".$d['DescripcionObligacion']."'",
									"obli_fecha_desde"=>"'".$d['FechaDesde']."'",
									"obli_fecha_hasta"=>"'".$d['FechaHasta']."'",
								);
					$obligacion->insertar($vobligacion);
                /*?>
                <tr>
                    <td><?php echo $d['DescripcionObligacion']?></td>
                    <td><?php echo $d['FechaDesde']?></td>
                    <td><?php echo $d['FechaHasta']?></td>

                </tr>
                <?php*/
            }
            /*?>
            </table>
        </td>
        <td>
        	PersonasContribuyente
            <table border="1">
            <tr>
            <td>Cedula</td><td>Nom Completo</td></tr><?php*/
            foreach($datos['PersonasContribuyente'] as $d){
				$vpersonas=array("cod_persona_natural"=>"'".$idpersona."'",
									"nit"=>"'".$datos['Nit']."'",
									"cedula_personas"=>"'".$d['Cedula']."'",
									"nombre_personas"=>"'".$d['NombreCompleto']."'",
								);
					$personas->insertar($vpersonas);
                /*?>
                <tr>
                    <td><?php echo $d['Cedula']?></td>
                    <td><?php echo $d['NombreCompleto']?></td>

                </tr>
                <?php*/
            }
           /* ?>
            </table>
        </td>
        <td><a href="datospadron.php?nit=<?php echo $datos['Nit']?>" target="_blank">Ver Datos</a></td>
    </tr>
    <?php*/
}
/*?>
</table>
<?php */
header("Location:datos2.php?id=".$idpersona."&nit=".$nit);
?>