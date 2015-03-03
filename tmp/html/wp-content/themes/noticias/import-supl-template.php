<?php
/*
 * Template Name: Suplemento Import Page
 * Description: A Page Template for Receiving Product at the plant 
 */


//Trying to comment out
//require_once("../wp-config.php");
//require_once("../wp-load.php");
//$wp->init(); $wp->parse_request(); $wp->query_posts();
//$wp->register_globals();
//$wp->send_headers();



get_header();
if ( !is_user_logged_in() && !user_can( get_current_user_id(), 'edit_others_posts' )) {
    echo 'Tiene que ingresar su usuario y contraseña para continuar...';
	get_footer();
} else {
show_admin_bar(true);
$current_user = wp_get_current_user();
$username = $current_user->user_login;
$user_display_name = $current_user->display_name;
$pgsql_hostname = 'lp-rds.laprensa.com.ni';
//$pgsql_hostname = 'pgsql.doap.com';
$pgsql_username = 'shawn';
$pgsql_password ='fr1ck0ff';
$pgsql_db = 'laprensa';
$pgsql_port = '5432';
$limit = '100';

//echo '<br><b>Persona recibiendo la fruta: </b>' . $user_display_name . '<br><b># Usuario: </b>' . $username;
echo '<title>Importar Notas de Almidon</title>';
$url = site_url('/util/');
echo '<link rel="stylesheet" type="text/css" href="' . $url . 'styles.css" />';
echo '<script language="javascript" src="' . $url . 'products.js" type="text/javascript"></script>';
echo '<form name="frmUser" method="post" action="" target="_blank">';
echo '<div style="width:800px;">';
echo '<table id="tbl" border="0" cellpadding="10" cellspacing="1" width="500" class="tblListForm">';
echo '<tr class="listheader">';
echo '<td>Ediciones a importar</td>';
echo '<td>Fecha Edicion</td>';
echo '</tr>';
$i=0;
$wpdb->show_errors();
//$username="bob";
date_default_timezone_set('America/Managua');
$date = date('m/d/Y h:i:s a', time());
//$acopio_array= $wpdb->get_col( "SELECT distinct order_id FROM wp_manifiestometa ORDER BY ABS(order_id) ASC;" );
//$orders_imported = implode( ",", $orders_imported_array);
$supl_cats = array(1,2,3,5,10,13);
$suplemento_cats = implode(',', $supl_cats);
//$section=array("1" => "25763");
$section_supl = array("1" => "25763", "2" => "35630", "3" => "924", "5" => "35631", "7" => "3598", "10" => "35632", "11" => "6740", "13" => "35633");
try
{
        $dbp = new PDO("pgsql:dbname=$pgsql_db;host=$pgsql_hostname", "$pgsql_username", "$pgsql_password" );
        //$sql = "SELECT idseccion, seccion FROM seccion WHERE activo = TRUE ORDER BY seccion ASC;";
        $sql = "SELECT idsuplemento, idedicionsuplemento, edicionsuplemento FROM edicionsuplemento WHERE idedicionsuplemento IS NOT NULL AND edicionsuplemento IS NOT NULL and idsuplemento IN ($suplemento_cats) ORDER BY edicionsuplemento DESC LIMIT 10;";
//        $sql = "SELECT idnoticia, idseccion FROM noticia ORDER BY idnoticia DESC LIMIT 10;";

	foreach ($dbp->query($sql) as $import_item)
	{
		if($i%2==0)
		$classname="evenRow";
		else
		$classname="oddRow";
		$seccion_id = $import_item['idedicion'];
		$seccion_name = get_cat_name($section_supl[$import_item['idsuplemento']]);
//		$import_item['seccion'] = __($import_item['seccion']);
		echo '<tr class="' . $classname . '">';
		echo '<td><input type="checkbox" name="editions[]" value="' . $import_item['idedicionsuplemento'] . '" unchecked >' . $seccion_name . '</td>';
		echo '<td><input type="hidden" name="sections[' . $import_item['idedicionsuplemento'] . ']" value="' . $import_item['idsuplemento'] . '">' . $import_item['edicionsuplemento'] . '</td>';
//		echo '<td>' . $import_item['edicionsuplemento'] . '</td>';
		//echo '<td><input type="hidden" name="product_descriptions[]" value="' . _e($import_item['Descripcion']) . '">' . _e($import_item['Descripcion']) . '</td>';
//		echo '<td>' . $import_item['Precio'] . '</td>';
		echo '</tr>';
		$i++;
	}
        $dbp = null;
}
catch(PDOException $e)
{
	echo "$e there was a problem";
}
/*
echo '<tr class="listheader">';
echo '<td>Secciones a importar</td>';
echo '<td>Nombre Seccion</td>';
echo '</tr>';

	//foreach ($dbp->query($sql) as $import_item)
foreach ($supl_cats as $supl_cat)
{
	if($i%2==0)
	$classname="evenRow";
	else
	$classname="oddRow";
	$seccion_name = get_cat_name($section_supl[$supl_cat]);
	echo '<tr class="' . $classname . '">';
	echo '<td><input type="checkbox" name="sections[]" value="' . $supl_cat . '" unchecked >' . $supl_cat . '</td>';
	echo '<td>' . $seccion_name . '</td>';
	echo '</tr>';
	$i++;
}
*/
echo '<tr class="listheader">';
//echo '<td colspan="3"><input type="button" name="create" value="Create" onClick="setCreateAction();" /> <input type="button" name="delete" value="Delete"  onClick="setDeleteAction();" /></td>';
echo '<td>Importar estas secciones</td><td><input type="button" name="create" value="Importar" onClick="importSuplementos();" /></td>';
echo '</tr>';
echo '</table>';
echo '</form>';
echo '</div>';
}
//var_dump($import_item);
//echo PHP_EOL . "i = $i" . PHP_EOL;
//print_r($tag_test);
//print_r($test_get_obj);
get_footer();
?>
