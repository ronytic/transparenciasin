<?php
include_once '../login/check.php';
$folder="../";
$titulo="Buscar Persona";

include_once '../funciones/funciones.php';
include_once '../cabecerahtml.php';
?>
<?php include_once '../cabecera.php';?>
<div class="grid_12">
	<div class="contenido">
    	<div class="prefix_1 grid_4 alpha">
			<fieldset>
				<div class="titulo"><?php echo $titulo?></div>
                <form action="guardar.php" method="post" enctype="multipart/form-data">
				<table class="tablareg">
					<tr>
						<td><?php campos("Cedula de Identidad","Ci","text","",1,array("required"=>"required"));?></td>
					</tr>
					<tr>
						<td><?php campos("Paterno","Paterno","text","",0,array(""=>""));?></td>
					</tr>
                    <tr>
						<td><?php campos("Materno","Materno","text","",0,array(""=>""));?></td>
					</tr>
                    <tr>
						<td><?php campos("Nombres","Nombres","text","",0,array(""=>""));?></td>
					</tr>
					<tr><td><?php campos("Procesar","guardar","submit");?></td><td></td></tr>
				</table>
                </form>
			</fieldset>
		</div>
        <div class="prefix_2 grid_4 alpha">
			<fieldset>
				<div class="titulo"><?php echo $titulo?> por NIT</div>
                <form action="guardar.php" method="post" enctype="multipart/form-data">
				<table class="tablareg">
					<tr>
						<td><?php campos("Nit","nit","text","",0,array("required"=>"required"));?></td>
					</tr>
					<tr><td><?php campos("Procesar","guardar","submit");?></td><td></td></tr>
				</table>
                </form>
			</fieldset>
		</div>
    	<div class="clear"></div>
    </div>
</div>
<?php include_once '../piepagina.php';?>