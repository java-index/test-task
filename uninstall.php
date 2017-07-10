<?php

if ( ! defined('WP_UNINSTALL_PLUGIN') ) {
    exit;
}

global $wpdb;

include_once( plugin_dir_path( __FILE__ ) . '/includes/config/class-tt-install.php' );
TT_Install::remove_roles();

// Delete term taxonomies
foreach ( array( 'delivery', 'status' ) as $taxonomy ) {
    $wpdb->delete(
        $wpdb->term_taxonomy,
        array(
            'taxonomy' => $taxonomy,
        )
    );
}

wp_cache_flush();