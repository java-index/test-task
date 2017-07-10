<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TT_Manager
{
    private $plugin_slug;
    const VERSION = '1.0.0';

    public function __construct() {
        $this->plugin_slug = 'test-task';
    }

    public function run() {
        TT_Post_Type::init();
        $this->add_hook();
    }

    private function add_hook() {
        add_filter( 'single_template', array( 'TT_Templates', 'get_product_single_template' ) );
        add_filter( 'archive_template', array( 'TT_Templates', 'get_product_archive_template' ) );
        add_action( 'restrict_manage_posts', array( $this, 'add_orders_taxonomies_filter' ) );
        /*
         * load style and script
         */
        add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );

        /*
         * register AJAX handlers
         */
        add_action( 'wp_ajax_insert_order', array( 'TT_Ajax', 'insert_order_ajax' ) );
    }

    public function load_scripts() {
        wp_enqueue_style( 'tt_css', TT_URL . 'assets/css/style.css' );
        wp_enqueue_script( 'tt_script', TT_URL . 'assets/js/script.js', array( 'jquery' ), TT_Manager::VERSION, true );
        wp_localize_script( 'tt_script', 'tt_ajax',
            array(
                'url' => admin_url('admin-ajax.php'),
            )
        );
    }

    public function add_orders_taxonomies_filter() {
        global $typenow;
        $taxonomies = array( 'delivery', 'status' );
        if ( $typenow == 'orders' ) {
            foreach ( $taxonomies as $tax_slug ) {
                $tax_obj = get_taxonomy( $tax_slug );
                $tax_name = $tax_obj->labels->name;
                $terms = get_terms( $tax_slug );
                if ( count ( $terms ) > 0 ) {
                     echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
                     echo "<option value=''>$tax_name (все)</option>";
                     foreach ( $terms as $term ) {
                         echo '<option value='. $term->slug, $_GET[ $tax_slug ] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
                     }
                     echo '</select>';
                 }
             }
        }
    }
}