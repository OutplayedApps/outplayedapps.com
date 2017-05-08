<?php
/**
 * The blog page file.
 **/
get_header(); ?>

<section>
<div class="container">
<div class="row">
<div class="col-xs-12">

<?php // Show the selected frontpage content.
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
        		get_template_part( 'template-parts/post-content', '' );
				
			endwhile;
		else : // I'm not sure it's possible to have no posts when this page is shown, but WTH.
			//get_template_part( 'template-parts/post/content', 'none' );
		endif; ?>

<div class="panel panel-default">
    <div class="panel-heading">
    <h3 class="panel-title">Spread the word!</h3>
    </div>
    <div id="shareIcons"></div>
</div>

</div>
</div>
</div>
</section>

<?php get_footer(); ?>