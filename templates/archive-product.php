<?php
/**
* The Template for displaying product archives
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header(); ?>
            <?php if ( have_posts() ) : $count = 1 ?>
            <div class="row">
            <?php while ( have_posts() ) : the_post(); ?>
                    <div class="col-md-4 product">
                        <img class="img-responsive" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="">
                        <div class="product__info">
                            <h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
            <?php the_posts_pagination(); ?>
<?php
get_footer();