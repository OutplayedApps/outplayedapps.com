<?php
/**
 * The blog page file.
 **/
get_header(); ?>

<section>
<div class="container-fluid">


<div class="row text-center">
                    <h2 id="services" class="section-heading">Blog</h2>
                    <hr class="primary">
<div class="col-xs-12">
<?php // Show the selected frontpage content.
    //$query = new WP_Query('pagename=home');
    //if ( $query->have_posts () ) : while ( $query->have_posts() ) : $query->the_post();

		if ( have_posts() ) :
			while ( have_posts() ) :

				the_post();
				get_template_part( 'template-parts/post-grid', '' );
			endwhile;
		else : // I'm not sure it's possible to have no posts when this page is shown, but WTH.
			//get_template_part( 'template-parts/post/content', 'none' );
		endif; ?>
</div>

</section>

<?php get_footer(); ?>