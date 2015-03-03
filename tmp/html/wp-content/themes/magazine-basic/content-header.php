<?php
/**
 * The template for displaying article headers
 *
 * @since 3.0.0
 */
global $mb_content_area;
?>
<header>
    <?php
	if ( ! is_archive() ) {
        $index_categories = mb_theme_options( 'index_categories' );
        $display_categories = mb_theme_options( 'display_categories' );
        if ( ( is_home() && !empty( $index_categories ) ) || ( ! is_home() && ! empty( $display_categories ) ) ) {
            ?>
            <h3 class="post-category"><?php the_category( ', ' ); ?></h3>
            <?php
        }
    }
    ?>
    <h1 class="entry-title">
        <?php if ( !is_singular() || 'sidebar' == $mb_content_area ) { ?>
            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'magazine-basic' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
            <?php } ?>
            <?php the_title(); ?>
            <?php
            if ( !is_singular() || 'sidebar' == $mb_content_area )
                echo '</a>';
            ?>
    </h1>

    <h2 class="entry-meta">
        <?php
        $index_author = mb_theme_options( 'index_author' );
        $display_author = mb_theme_options( 'display_author' );
        if ( ( is_home() && $index_author ) || ( ! is_home() && $display_author ) )
			printf( __( 'by %s', 'magazine-basic' ),
				'<a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( sprintf( __( 'Posts by %s', 'magazine-basic' ), get_the_author() ) ) . '" rel="author">' . get_the_author() . '</a>'
			);

        $index_date = mb_theme_options( 'index_date' );
        $display_date = mb_theme_options( 'display_date' );
        if ( ( is_home() && !empty( $index_date ) ) || (!is_home() && !empty( $display_date ) ) ) {
            if ( ( is_home() && !empty( $index_author ) ) || (!is_home() && !empty( $display_author ) ) )
                echo '&nbsp;&bull;&nbsp;';
            echo '<time class="published" datetime="' . get_the_date( 'Y-m-d' ) . '">' . get_the_date() . '</time>';
        }
        if ( 'sidebar' != $mb_content_area ) {
            $index_comment_count = mb_theme_options( 'index_comment_count' );
            $display_comment_count = mb_theme_options( 'display_comment_count' );
            if ( comments_open() && ( is_home() && !empty( $index_comment_count ) ) || (!is_home() && !empty( $display_comment_count ) ) ) {
                if ( ( is_home() && !empty( $index_author ) ) || (!is_home() && !empty( $display_author ) ) || ( is_home() && !empty( $index_date ) ) || (!is_home() && !empty( $display_date ) ) )
                    echo '&nbsp;&bull;&nbsp;';
                comments_popup_link( __( '0 Comments', 'magazine-basic' ), __( '1 Comment', 'magazine-basic' ), __( '% Comments', 'magazine-basic' ) );
            }
        }
        ?>
    </h2>
</header>
