<?php
/**
 * The Template for displaying single products
 */

get_header(); ?>
<?php if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>
        <?php the_post_thumbnail('post-thumbnail', array(
            'class' => 'img-responsive center-block',
            'alt'   => ''
            )
        ); ?>
        <div class="product-block-single text-center">
            <h2><?php the_title(); ?></h2>
            <?php if ( is_user_logged_in() ) {
                echo '<button id="tt_add_order" type="button" class="btn btn-primary btn-lg" data-name="' . get_the_title() .'" data-toggle="modal" data-target=".bs-example-modal-lg">Заказать</button>';
            }
            else {
                echo '<a href="'.  esc_url( wp_login_url( $_SERVER['REQUEST_URI'] ) )  . '" class="btn btn-primary btn-lg" data-toggle="modal">Заказать</a>';
            } ?>
        </div>
    <?php endwhile; ?>
    <?php require TT_DIR . 'templates/form-modal-order.php' ?>
    <?php require TT_DIR . 'templates/modal-message.php' ?>
<?php endif; ?>
<?php get_footer(); ?>
