<?php
    /**
    * Template Name: Blank Page
    */
?>  
		<?php
			while ( have_posts() ) : the_post();

				the_content();
		endwhile; ?>