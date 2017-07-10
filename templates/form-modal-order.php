<?php
/**
* The Modal window order goods
*/
?>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="form-order">
            <div class="form-group">
                <label>Выберите товар:</label>
                <select class="form-control product-name" name="product">
                    <?php $args = array(
                        'post_type' => 'product',
                        'showposts' => -1
                    );
                    $products = get_posts( $args ); ?>
                    <?php foreach ( $products as $product ) : ?>
                        <option>
                            <?php echo $product->post_title ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <?php
                if ( is_user_logged_in() ) :
                    global $current_user;
                    $user = $current_user;
                endif; ?>
                <label>Имя и Фамилия:</label>
                <input type="text" value="<?php if ( isset ( $user->display_name ) ) echo $user->display_name; ?>" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label>E-Mail:</label>
                <input type="email" value="<?php if ( isset ( $user->user_email ) ) echo $user->user_email; ?>" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label>Способ доставки:</label>
                <select class="form-control" name="dostavka">
                    <?php $args = array(
                        'taxonomy'      =>  'delivery',
                        'hide_empty'    =>  false,
                    );
                    $terms = get_terms( $args ); ?>
                    <?php foreach ( $terms as $term ) : ?>
                        <option>
                            <?php echo( $term->name ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" value="<?php if ( isset ( $user->ID ) ) echo $user->ID; ?>" name="user_id" />
            <?php wp_nonce_field( 'ajax-order-nonce', 'security' ); ?>
            <div class="text-center">
                <button id="order-submit" type="button" class="btn btn-primary btn-lg">Заказать</button>
            </div>
           </form>
        </div>
    </div>
</div>

