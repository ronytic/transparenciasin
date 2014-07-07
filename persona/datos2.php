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
                <a href="datospadron.php?id=<?php echo $pers['cod_persona_natural']?>&nit=<?php echo $pers['nit']?>" class="botonnegro" target="_blank">Ver Datos del Padrón</a>
                <hr>
                <div class="titulo">Extracto Tributario</div>
                <form action="extracto.php" method="post">
                	<table>
                    	<tr>
                        	<td><label for="nit">Nit</label></td>
                            <td><label for="PeriodoDesde">PeriodoDesde - <small>AAAAMM</small></label></td>
                            <td><label for="PeriodoHasta">PeriodoHasta</label></td>
                        </tr>
                        <tr>
                        	<td><input type="text" name="nit" id="nit" value="<?php echo $_GET['nit']?>" readonly></td>
                            <td><input type="text" name="PeriodoDesde" id="PeriodoDesde" value="201301" autofocus></td>
                            <td><input type="text" name="PeriodoHasta" id="PeriodoHasta" value="201312"></td>
                            <td><input type="submit" value="Buscar Periodo" class="botonnegro"></td>
                        </tr>
                        
                    </table>
                   
                    
                    
                    
                    
                    
                    
                </form>
			</fieldset>
		</div>
    	<div class="clear"></div>
    </div>
</div>
<?php include_once '../piepagina.php';?>