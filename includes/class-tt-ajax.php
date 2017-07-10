<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TT_Ajax
{
    public static function insert_order_ajax() {
        $security = check_ajax_referer('ajax-order-nonce', 'security', false);
        try {
            if ( ! $security ) {
                throw new Exception( 'Ошибка авторизации' );
            }
            $data = array();
            parse_str( $_POST['form'], $data );
            $result = self::insert_post( $data );
            if ( ! $result ) {
                throw new Exception( 'Ошибка оформления заказа' );
            }
            self::sendResponse( 'Заказ оформлен', true );
        } catch ( Exception $e ) {
            self::sendResponse( $e->getMessage(), fase );
        }
    }

    private static function insert_post( $data ) {
        if ( empty( $data ) ) {
            throw new Exception( 'Нет данных для оформления' );
        }

        $new_order = array(
            'post_title' => 'Новый заказ ' . $data['product'],
            'post_content' => 'Покупатель: ' . $data['name'] . '; ' . $data['email'] . '; ' . $data['dostavka'],
            'post_status' => 'publish',
            'post_author' => $data['user_id'],
            'post_type' => 'order'
        );
        return wp_insert_post( $new_order );
    }

    private static function sendResponse( $message, $status ) {
        $response = array(
            'success' => $status,
            'message' => $message,
        );
        echo json_encode( $response );
        die();
    }
}