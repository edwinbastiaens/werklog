<?php if ($pagename=="") header("Location: home");?>
<?php get_header();?>
                    <h1><?php the_title(); ?></h1>
                    <!--<div class="fotoslider">
                        <img src='' />
                    </div>-->
                    <?php
                    while ( have_posts() ) : the_post(); ?> 
                        <p><?php the_content(); ?></p>
                    <?php
                    endwhile; //resetting the page loop
                    wp_reset_query(); //resetting the page query
                    ?>
<?php get_footer(); ?>