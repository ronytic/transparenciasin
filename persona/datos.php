<?php
include_once '../login/check.php';
$folder="../";
extract($_GET);
$titulo="Datos de Personas";
include_once("../class/persona.php");
$persona=new persona;
$pers=array_shift($persona->mostrar($id));
//$where="cedula_id='$Ci' and ap_paterno='$Paterno' and ap_materno='$Materno' and nombres='$Nombres'";
//$perso=$persona->mostrarTodos($where);
include_once '../funciones/funciones.php';
include_once '../cabecerahtml.php';
?>
<?php include_once '../cabecera.php';?>
<div class="grid_12">
	<div class="contenido">
    	<div class="prefix_1 grid_10 alpha">
			<fieldset>
				<div class="titulo">Datos de Persona</div>
                <table class="tablalistado">
                <tr class="cabecera"><td>Cédula de Identidad</td><td>Paterno</td><td>Materno</td><td>Nombres</td><td>Nit</td><td>Fecha de Búsqueda</td></tr>
                <tr class="contenido"><td><?php echo $pers['cedula_id']?></td><td><?php echo capitalizar($pers['ap_paterno'])?></td><td><?php echo capitalizar($pers['ap_materno'])?></td><td><?php echo capitalizar($pers['nombres'])?></td><td><?php echo $pers['nit']?></td><td><?php echo fecha2Str($pers['fecha_reg'])?></td></tr>
                </table>
                <?php
                
				?>
                <a href="datospadron.php?id=<?php echo $pers['cod_persona_natural']?>&nit=<?php echo $pers['nit']?>" class="botonnegro" target="_blank">Datos del Padrón</a>
                <a href="extractotributario.php?id=<?php echo $pers['cod_persona_natural']?>&nit=<?php echo $pers['nit']?>" class="botonnegro" target="_blank">Extracto Tributario</a>
			</fieldset>
		</div>
    	<div class="clear"></div>
    </div>
</div>
<?php include_once '../piepagina.php';?>