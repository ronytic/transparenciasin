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

include_once '../funciones/funciones.php';
include_once '../cabecerahtml.php';
?>
<?php include_once '../cabecera.php';?>
<div class="grid_12">
	<div class="contenido">
    	<div class="prefix_1 grid_10 alpha">
			<fieldset>
				<div class="titulo">Personas encontradas en Base de Datos Ministerio Transparencia</div>
                <?php
                $titulo=array("cedula_id"=>"Cédula Identidad","ap_paterno"=>"Paterno","ap_materno"=>"Materno","nombres"=>"Nombres","fecha_reg"=>"Fecha de Registro");
				listadoTabla($titulo,$perso,1,"","","ver.php",array("Ver Datos"=>"datos.php"),array(),"_blank");
				?>
			</fieldset>
            <fieldset>
				<div class="titulo">Personas encontradas en Base de Datos de Servicios de Impuestos Nacionales</div>
                <?php
                $titulo=array("cedula_id"=>"Cédula Identidad","ap_paterno"=>"Paterno","ap_materno"=>"Materno","nombres"=>"Nombres","fecha_reg"=>"Fecha de Registro");
				listadoTabla($titulo,$perso,1,"","","ver.php");
				?>
			</fieldset>
		</div>
    	<div class="clear"></div>
    </div>
</div>
<?php include_once '../piepagina.php';?>