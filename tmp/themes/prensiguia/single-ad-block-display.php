<?php 
if ($gid > 10000000)  
{
	include(STYLESHEETPATH . '/middle-300x250-loggedin.php');
}
else
{

	$category = get_the_category();
	echo $category[0]->cat_name;

        if ( in_category( 'nacionales' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-nacionales.php'); }
        else if ( in_category( 'deportes' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-deportes.php'); }
        else if ( in_category( 'internacionales' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-internacionales.php'); }
        else if ( in_category( 'economia' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-economia.php'); }
        else if ( in_category( 'politica' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-politica.php'); }
        else if ( in_category( 'economia' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-economia.php'); }
        else if ( in_category( 'espectaculo' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-espectaculo.php'); }
        else if ( in_category( 'salud' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-salud.php'); }
        else if ( in_category( 'departamentales' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-departamentales.php'); }
        else if ( in_category( 'tecnologia' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-tecnologia.php'); }
        else if ( in_category( 'ciencia' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-ciencia.php'); }
        else if ( in_category( 'opinion' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-opinion.php'); }
        else if ( in_category( 'nosotras' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-nosotras.php'); }
        else if ( in_category( 'Aquí Entre Nos' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-aqui-entre-nos.php'); }
        else if ( in_category( 'la prensa domingo' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-la-prensa-domingo.php'); }
        else if ( in_category( 'la-prensa-domingo' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-la-prensa-domingo.php'); }
        else if ( in_category( 'empresariales' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-empresariales.php'); }
        else if ( in_category( 'promociones' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-promociones.php'); }
        else if ( in_category( 'productos' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-productos.php'); }
        else if ( in_category( 'contactanos' ) ) { include(STYLESHEETPATH . '/ad-300x250-top-contactanos.php'); }
        else {
        include(STYLESHEETPATH . '/ad-300x250-top-none.php');
        }

}
?>

