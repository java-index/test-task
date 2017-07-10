<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TT_Post_Type
{
    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_taxonomies' ) );
        add_action( 'init', array( __CLASS__, 'register_post_types' ) );
    }

    /**
     * Register core taxonomies.
     */
    public static function register_taxonomies() {
        if ( taxonomy_exists( 'delivery' ) ) {
            return;
        }

        register_taxonomy( 'delivery',
            array( 'order' ),
            array(
                'labels'            =>  array(
                    'name'  =>  'Способ доставки',
                    ),
                'hierarchical'          =>  true,
                'public'                =>  true,
                'show_in_quick_edit'    =>  true,
                'show_admin_column'     =>  true,
                'capabilities'          =>  array(
                    'manage_terms'  =>  'manage_order_terms',
                    'edit_terms'    =>  'edit_order_terms',
                    'delete_terms'  =>  'delete_order_terms',
                    'assign_terms'  =>  'assign_order_terms',
                ),
            )
        );

        register_taxonomy( 'status',
            array( 'order' ),
            array(
                'labels'            => array(
                    'name'  =>  'Сатус заказа',
                    ),
                'hierarchical'          =>  true,
                'public'                =>  true,
                'show_in_quick_edit'    =>  true,
                'show_admin_column'     =>  true,
                'capabilities'          =>  array(
                    'manage_terms'  =>  'manage_order_terms',
                    'edit_terms'    =>  'edit_order_terms',
                    'delete_terms'  =>  'delete_order_terms',
                    'assign_terms'  =>  'assign_order_terms',
                ),
            )
        );
    }

    /**
     * Register core post types.
     */
    public static function register_post_types() {
        if ( post_type_exists('product' ) ) {
            return;
        }

        register_post_type( 'product',
            array(
                'labels'    =>  array(
                    'name'  => 'Товары',
                ),
                'public'            =>  true,
                'supports'          =>  array( 'title', 'editor', 'thumbnail', 'tags' ),
                'has_archive'       =>  true,
                'show_in_nav_menus' =>  true,
                'taxonomies'        =>  array( 'category', 'post_tag' ),
                'capability_type'   =>  'product',
                'map_meta_cap'      =>  true,
            )
        );

        register_post_type( 'order',
            array(
                'labels'    =>  array(
                    'name'  => 'Заказы',
                ),
                'public'            =>  true,
                'supports'          =>  array( 'title', 'editor' ),
                'has_archive'       =>  true,
                'show_in_nav_menus' =>  true,
                'capability_type'   =>  'order',
                'map_meta_cap'      =>  true,
            )
        );
    }

    /**
     * Insert core term taxonomies.
     */
    public static function insert_terms() {
        wp_insert_term( 'Самовывоз', 'delivery', array( 'slug' => 'samovyvoz' ) );
        wp_insert_term( 'Доставка почтой', 'delivery', array( 'slug' => 'dostavka-pochtoy' )  );
        wp_insert_term( 'Курьерская доставка', 'delivery', array( 'slug' => 'kuryerskaya-dostavka' ) );

        wp_insert_term( 'Обрабатывается', 'status', array( 'slug' => 'obrabotka' ) );
        wp_insert_term( 'Отправлен', 'status', array( 'slug' => 'otpravlen' ) );
        wp_insert_term( 'Отклонен', 'status', array( 'slug' => 'otklonen' ) );
    }
}