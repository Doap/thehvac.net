<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */

//get_header(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LA PRENSA. El Diario de los Nicaragüenses. Nicaragua</title>
<style type="text/css">
            /* Based on The MailChimp Reset INLINE: Yes. */
            /* Client-specific Styles */
        #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
            /* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/
        .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
        .ExternalClass h1, h2, h3 {color:#FFF;} /* Force Hotmail to display emails at full width */
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
            /* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
        #backgroundTable {margin:10px; padding:0; width:580px !important; line-height: 100% !important;}
            /* End reset */
            .im {
                 color: #000000;
            }
                                   
                                               
            /* Some sensible defaults for images
           Bring inline: Yes. */
        img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;}
        a img {border:none;}
        
        a, a:link, a:hover {text-decoration: none;}
        
            /* Yahoo paragraph fix
           Bring inline: Yes. */
        p {margin: 1em 0; font-size: 12px;
            line-height: 15px;}

            /* Hotmail header color reset
           Bring inline: Yes. */
        body{ color: #444; font:13px/1.231 sans-serif; *font-size:small; }
        h1, h2, h3, h4, h5, h6 { font-weight: bold; }
        h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}
        

            /* Outlook 07, 10 Padding issue fix
           Bring inline: No.*/
        table td {border-collapse: collapse;}

            /* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email and make sure to 

bring your styles inline.  Your link colors will be uniform across clients when brought inline.
           Bring inline: Yes. */
        a, a:active{ color: #607890; text-decoration:none}
        a:hover { color: #036; }

            /***************************************************
           ****************************************************
           MOBILE TARGETING
           ****************************************************
           ***************************************************/
        @media only screen and (max-device-width: 480px) {
            /* Part one of controlling phone number linking for mobile. */
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: blue; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }

        }

            /* More Specific Targeting */

        @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
            /* You guessed it, ipad (tablets, smaller screens, etc) */
            /* repeating for the ipad */
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: blue; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }

            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: orange !important;
                pointer-events: auto;
                cursor: default;
            }
        }

        @media only screen and (-webkit-min-device-pixel-ratio: 2) {
            /* Put your iPhone 4g styles in here */
        }

            /* Android targeting */
        @media only screen and (-webkit-device-pixel-ratio:.75){
            /* Put CSS for low density (ldpi) Android layouts in here */
        }
        @media only screen and (-webkit-device-pixel-ratio:1){
            /* Put CSS for medium density (mdpi) Android layouts in here */
        }
        @media only screen and (-webkit-device-pixel-ratio:1.5){
            /* Put CSS for high density (hdpi) Android layouts in here */
        }
            /* end Android targeting */

    </style>

    <!-- Targeting Windows Mobile -->
    <!--[if IEMobile 7]>
    <style type="text/css">

    </style>
    <![endif]-->

    <!-- ***********************************************
     ****************************************************
     END MOBILE TARGETING
     ****************************************************
     ************************************************ -->

    <!--[if gte mso 9]>
        <style>
        /* Target Outlook 2007 and 2010 */
        </style>
 <![endif]-->
</head>
<body>
<div style="align:center;background:#fff;font-family:&quot;Times New Roman&quot;,Times,serif">
<table cellspacing="0" cellpadding="0" style="width:800px;background:#e6e6e6">
	<tbody><tr style="background:#e6e6e6">
	<td style="width:50%;background:#e6e6e6"></td>
	<td>
		<table cellspacing="0" cellpadding="5" style="width:700px;background:white">
        		<tbody><tr>

			<td width="25%"></td>    
        		<td width="300px" style="border-bottom:1px solid #eee;text-align:left;font-family:Arial,Helvetica,sans-serif;font-size:13px;margin:0px;padding:0px;color:#555">
                MARTES 22 DE ABRIL 2014 | EDICIÓN 27023
            		</td>
            		<td width="100px" style="text-align:right;border-bottom:1px solid #eee;vertical-align:middle">

		                <table cellspacing="0" cellpadding="0" style="float:right">
			                <tbody><tr><td style="padding-right:5px">
			                <a style="text-decoration:none;color:#5680ba;font-size:13px;font-family:Helvetica,sans-serif;padding:0px" href="http://www.laprensa.com.ni" target="_blank">www.laprensa.com.ni</a>
                   			</td>
                			<td style="padding-right:5px">
		                        <a style="text-decoration:none" href="http://www.facebook.com/laprensanicaragua" target="_blank">
					<img width="25px;" style="display:inline-block;vertical-align:middle" height="25px;" src="http://boletines.laprensa.com.ni/boletin/media/images/facebook.jpg"></a>
                			</td>
                			<td>
                                        <a href="http://twitter.com/laprensa" style="text-decoration:none;margin-left:0px;padding:0px;vertical-align:middle" target="_blank">
                                        <img width="25px;" height="25px;" src="http://boletines.laprensa.com.ni/boletin/media/images/twitter.jpg" style="display:inline-block;vertical-align:middle"></a>
               				</td>
                			</tr>
                			</tbody>
				</table>
           		 </td>

			<td width="25%"></td>    
		        </tr>
       			 <tr>

			<td width="25%"></td>    
	            	<td colspan="2" style="text-align:center;border-bottom:1px solid #eee;padding-bottom:20px;padding-top:20px">
            		<img src="http://boletines.laprensa.com.ni/boletin/media/images/laprensa.jpg" style="vertical-align:middle">
            		</td>

			<td width="25%"></td>    
        		</tr>
        		<tr>

			<td width="25%"></td>  
			</tbody>
		</table>
	</tbody>
</table>
</div>
			 <?php $thetag = "test"; ?> 
<div id="content-archive" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">
<?php //echo do_shortcode('[xyz-ips snippet="tag-widget"]'); ?>
<?php //echo do_shortcode('[doap_animate type="lightSpeedIn"]<h2>Etiquetas: ' . $thetag . '</h2>[/doap_animate]'); ?>
<h2><?php //single_tag_title(' '); ?></h2>

	<?php if( have_posts() ) : ?>

		<?php //get_template_part( 'loop-header' ); ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div  style="border:1px solid #ccc; margin-right:5px;margin-top:15px;padding:5px;position:relative;float:left;padding-right:15px;width:97%;" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta' ); ?>

				<div class="post-entry">
<?php $gmt_timestamp = get_post_time('U', true); ?>
<?php //tcp_posted_on(); ?><br>
<?php //if(qtrans_getLanguage() == "es") : ?>
<a href="<?php echo get_month_link('', ''); ?>">Notas este mes</a>
<?php //endif ?>
<?php //if(qtrans_getLanguage() == "en") : ?>
<!-- <a href="<?php echo get_month_link('', ''); ?>">All posts this month</a> -->
<?php //endif ?>

<?php if ( has_post_thumbnail() ) {

//the_post_thumbnail();

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
//echo do_shortcode('[doap_lightbox type="image" src="' . $feat_image . '" class="story-image"]<div style="position:relative;float:right;top:20px;left:5px;">[doap_button style="soft" background="#369" color="#ffffff" size="0" wide="no" radius="5" icon_color="#ffffff"  icon="icon:search-plus"][/doap_button]</div>[/doap_lightbox]');

echo "<div style=max-width:40%;height:280px;float:right;overflow:hidden;>";
					responsive_pro_featured_image();
echo "</div>";
} else { $thecategory = get_the_category(); $thecat = strtolower($thecategory[0]->cat_name); ?>
<div style="float:right;"><img src="http://laprensa13.doap.us/wp-content/uploads/sites/2/2014/04/laprensanota-<?php echo str_replace(" ","-",$thecat); ?>.jpg" draggable="false"> </div><?php } ?> 
					
					                                        <?php
                                        //responsive_pro_featured_image();

                                        if( responsive_pro_get_option( 'archive_post_excerpts' ) ) {
                                                add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
                                                add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
                                        echo "<div style=max-width:50%>";
 						$theexcerpt = get_the_excerpt();
						$words = str_word_count($theexcerpt, 2);
          					$pos = array_keys($words);
          					$theexcerpt = substr($theexcerpt, 0, $pos[90]) . '...';
                                        	//echo $theexcerpt;
                                                the_excerpt();
                                                //the_content( __( 'Read more &#8250;', 'responsive' ) );
                                        echo "</div>";
                                                remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
                                                remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
                                        }
                                        else {
                                                add_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
                                                add_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
                                        echo "<div style=max-width:50%>";
 						$theexcerpt = get_the_excerpt();
						$words = str_word_count($theexcerpt, 2);
          					$pos = array_keys($words);
          					$theexcerpt = substr($theexcerpt, 0, $pos[90]) . '...';
                                        	echo $theexcerpt;
                                                the_excerpt();
                                        echo "</div>";
                                                remove_filter( 'excerpt_more', 'responsive_pro_excerpt_more_text' );
                                                remove_filter( 'excerpt_length', 'responsive_pro_excerpt_more_length' );
                                        } ?>


<div id="cat-tax">
<?php $taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
                                                foreach( $taxonomies as $id => $taxonomy ) :
                                                        $terms_list = get_the_term_list( 0, $id, '', ', ' );
                                                        echo "<br>";
                                                        if ( strlen( $terms_list ) > 0 ) : ?>
                                                        <span class="tcp-product-taxonomy tcp-product-taxonomy-<?php echo $taxonomy->name;?>"><?php echo $taxonomy->labels->singular_name; ?>:
                                                        <?php echo $terms_list;?>
                                                        </span>
                                                        <?php endif;
                                                endforeach;?></div>

<?php
					wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) );
					?>
				</div>
				<!-- end of .post-entry -->




				<?php //get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>
		<?php
		endwhile;

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content-archive -->
<table style="font-family:Arial, Helvetica, sans-serif; margin:0px; padding:0px; color:#555;" cellspacing=0 cellpadding=0>
        
        <tr><td><img src="http://boletines.laprensa.com.ni/boletin/media/images/laprensa_logo.jpg" style="margin:0px; padding:0px; vertical-

align:middle;"/></td></tr>
         <tr><td><a href="http://www.laprensa.com.ni" style="font-size:17px; text-decoration:none; color:#5680ba; margin:0px; padding:5px 0 10px 

0;">www.laprensa.com.ni</a></td></tr>
  <tr><td style="padding-top:10px;">       <span style="font-weight:bold;">EDITORIAL LA PRENSA, S.A.</span></td></tr>
  <tr><td>       Km. 4<small>1/2</small> Carretera Norte, Managua,</td></tr>
  <tr><td>       Nicaragua</td></tr>
  <tr><td>       Apartado Postal #192</td></tr>
  <tr><td>       PBX (505) 2255-6767</td></tr>
  <tr><td>       FAX (505) 2255-6780 ext.5369</td></tr>
  <tr><td>       <a href="mailto:edicion.digital@laprensa.com.ni" style="text-decoration:none; color:#5680ba;">edicion.digital@laprensa.com.ni</a></td></tr>
    </table>
</td>
<tr><td colspan=3 height=20;>.</td></tr>

<tr>
<td></td>    
<td height=20;><strong>¿C&oacute;mo anunciarse?</strong><br/>
  Para anunciarse en <a href="http://www.laprensa.com.ni" target="_blank">www.laprensa.com.ni</a> escr&iacute;banos a: <a 

href="mailto:arturo.hernandez@laprensa.com.ni">arturo.hernandez@laprensa.com.ni</a> , <a href="mailto:lisseth.tellez@laprensa.com.ni" > 

lisseth.tellez@laprensa.com.ni</a>, <a href="mailto:amanda.lopez@laprensa.com.ni">amanda.lopez@laprensa.com.ni</a>
<br/>
</td>

<td></td>    
</tr>
<tr><td colspan=3 height=20;>.</td></tr>
<tr>

<td></td>    
<td  height=20;><strong>Privacidad</strong> <br/>
Usted recibe este mensaje porque est&aacute; registrado en nuestra base de datos. Si desea  dejar de recibir este bolet&iacute;n haga clic <a 

href="http://boletines.laprensa.com.ni/boletin/desuscribirse" target="new">aqu&iacute;</a>.</td>

<td></td>    
</tr>

<tr><td colspan=3 height=20;>.</td></tr>
<tr>

<td></td>    
<td colspan=3 height=20;>Si recibi&oacute; este mensaje a trav&eacute;s de otra persona y desea continuar recibiendo el bolet&iacute;n de noticias de 

www.laprensa.com.ni <br/>
puede suscribirse <a href="http://boletines.laprensa.com.ni/boletin/suscribirse" target="new">aqu&iacute;</a>.</td>

<td></td>    
</tr>

<tr><td colspan=3 height=20;>.</td></tr>
</table>
</body>
</html>
<?php //my_pagination(); ?>
<?php //get_footer(); ?>
