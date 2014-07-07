<?php
include_once '../login/check.php';
$folder="../";
extract($_POST);
$titulo="Busqueda de Personas";
include_once("../class/persona.php");
$persona=new persona;
$where="cedula_id='$Ci' and ap_paterno='$Paterno' and ap_materno='$Materno' and nombres='$Nombres'";
$perso=$persona->mostrarTodos($where);
/*INICIA SOAP*/
/*
require_once("../lib/nusoap.php");
echo $ipsoap;

$SoapCliente=new nusoap_client($ipsoap, true);
//$parametros=array("IPAddress"=>$ip);
$parametros=array("Cedula"=>$Ci,"ApellidoPaterno"=>$Paterno,"ApellidoMaterno"=>$Materno,"Nombres"=>$Nombres);
//$respuesta=$SoapCliente->call("GetGeoIP",$parametros);
$respuesta=$SoapCliente->call("ConsultarDatosPersonaNatural",$parametros);
print_r($respuesta);
/*FIN DE SOAP*/
$respuesta=array("MitPersonaNatural"=>
				array("Nit"=>"123",
					"RazonSocial"=>"Razon Social",
					"DescripcionTipoPersona"=>"Descripcion"
				)
);

include_once '../funciones/funciones.php';
include_once '../cabecerahtml.php';
?>
<?php include_once '../cabecera.php';?>
<div class="grid_12">
	<div class="contenido">
    	<div class="prefix_0 grid_11">
                <table class="tablalistado">
                <tr class="cabecera"><td colspan="5">Datos Buscados</td></tr>
                <tr class="cabecera"><td>Cédula de Identidad</td><td>Paterno</td><td>Materno</td><td>Nombres</td><td>Nit</td></tr>
                <tr class="contenido"><td><?php echo $Ci?></td><td><?php echo capitalizar($Paterno)?></td><td><?php echo capitalizar($Materno)?></td><td><?php echo capitalizar($Nombres)?></td><td><?php echo $Nit?></td></tr>
                </table>
			<fieldset>
				<div class="titulo">Personas encontradas en Base de Datos Ministerio Transparencia</div>
                <?php
                $titulo=array("cedula_id"=>"Cédula Identidad","ap_paterno"=>"Paterno","ap_materno"=>"Materno","nombres"=>"Nombres","nit"=>"Nit","fecha_reg"=>"Fecha de Registro");
				listadoTabla($titulo,$perso,1,"","","ver.php",array("Ver Datos"=>"datos.php"),array(),"_blank");
				?>
			</fieldset>
            <fieldset>
				<div class="titulo">Personas encontradas en Base de Datos de Servicios de Impuestos Nacionales</div>
               <table border="1" class="tablalistado">
               	<tr class="cabecera"><td>N</td><td>Nit</td><td>Razon Social</td><td>Descripcion Tipo Persona</td></tr>
				<?php $i=0;foreach($respuesta as $datos){$i++?>
    			<tr class="contenido">
                	<td><?php echo $i?></td>
                    <td><?php echo $datos['Nit']?></td>
                    <td><?php echo $datos['RazonSocial']?></td>
                    <td><?php echo $datos['DescripcionTipoPersona']?></td>
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