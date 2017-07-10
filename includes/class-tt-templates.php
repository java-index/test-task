<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TT_Templates
{
    public static function get_product_single_template( $single ) {
        global $post;

        if ( $post->post_type == 'product' ) {
            if ( file_exists( TT_DIR . 'templates/single-product.php' ) ) {
                return TT_DIR . 'templates/single-product.php';
            }
        }
        return $single;
    }

    public static function get_product_archive_template( $archive ) {
        global $post;

        if ( $post->post_type == 'product' ) {
            if ( file_exists( TT_DIR . 'templates/archive-product.php' ) ) {
                return TT_DIR . 'templates/archive-product.php';
            }
        }
        return $archive;
    }
}