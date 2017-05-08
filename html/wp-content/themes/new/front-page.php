<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php /* do_action("paypal_ipn_for_wordpress_txn_type_web_accept", $posted = shortcode_atts( array(
        'custom' => 'testest',
    ), $atts )) */ ?>

<?php // Show the selected frontpage content.
			while ( have_posts() ) : the_post();
        		the_content();
				//get_template_part( 'template-parts/page/content', 'front-page' );
			endwhile;
		 ?>

    <script>
    $(function() {
        $('.carousel').carousel({
            interval: 5000 //changes the speed
        })
    });
    </script>

<?php get_footer(); ?>
