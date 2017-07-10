<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TT_Install
{
    public static function install() {
        TT_Post_Type::register_taxonomies();
        TT_Post_Type::register_post_types();
        TT_Post_Type::insert_terms();
        self::create_roles();
    }

    /**
     * Create roles and capabilities.
     */
    public static function create_roles() {
        global $wp_roles;

        if ( ! class_exists( 'WP_Roles' ) ) {
            return;
        }

        if ( ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
        }

        // Buyer role
        add_role( 'buyer', 'Покупатель', array() );

        // Seller role ( clone subscriber + add MEDIA!!! )
        $subscriber = $wp_roles->get_role( 'subscriber' );
        $subscriber->capabilities[ 'upload_files'] = true;
        add_role( 'seller', 'Продавец', $subscriber->capabilities );

        $admin_capabilities = self::get_core_admin_capabilities();

        foreach ( $admin_capabilities as $cap_admin_group ) {
            foreach ( $cap_admin_group as $admin_cap ) {
                $wp_roles->add_cap( 'administrator', $admin_cap );
            }
        }

        $seller_capabilities = self::get_core_seller_capabilities();

        foreach ( $seller_capabilities as $cap_seller_group ) {
            foreach ( $cap_seller_group as $seller_cap ) {
                $wp_roles->add_cap( 'seller', $seller_cap );
            }
        }
    }

    /**
     * Get capabilities for Test Task Plugin - these are assigned to seller.
     */
    private static function get_core_admin_capabilities() {
        $capabilities = array();
        $capability_types = array( 'product', 'order' );

        foreach ( $capability_types as $capability_type ) {
            $capabilities[ $capability_type ] = array(
                // Post types
                "edit_{$capability_type}",
                "read_{$capability_type}",
                "delete_{$capability_type}",
                "edit_{$capability_type}s",
                "edit_others_{$capability_type}s",
                "publish_{$capability_type}s",
                "read_private_{$capability_type}s",
                "delete_{$capability_type}s",
                "delete_private_{$capability_type}s",
                "delete_published_{$capability_type}s",
                "delete_others_{$capability_type}s",
                "edit_private_{$capability_type}s",
                "edit_published_{$capability_type}s",

                // Terms
                "manage_{$capability_type}_terms",
                "edit_{$capability_type}_terms",
                "delete_{$capability_type}_terms",
                "assign_{$capability_type}_terms",
            );
        }
        return $capabilities;
    }

    private static function get_core_seller_capabilities() {
        $capabilities = array();
        $capability_types = array( 'product' );

        foreach ( $capability_types as $capability_type ) {
            $capabilities[ $capability_type ] = array(
                // Post types
                "edit_{$capability_type}",
                "read_{$capability_type}",
                "delete_{$capability_type}",
                "edit_{$capability_type}s",
                "publish_{$capability_type}s",
                "delete_{$capability_type}s",
                "delete_published_{$capability_type}s",
                "edit_published_{$capability_type}s",

                // Terms
                "assign_{$capability_type}_terms",
            );
        }
        return $capabilities;
    }

    /**
     * tt_plugin remove_roles function
     */
    public static function remove_roles() {
        global $wp_roles;

        if ( ! class_exists( 'WP_Roles' ) ) {
            return;
        }

        if ( ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
        }

        $admin_capabilities = self::get_core_admin_capabilities();

        foreach ( $admin_capabilities as $cap_group ) {
            foreach ( $cap_group as $cap ) {
                 $wp_roles->remove_cap( 'administrator', $cap );
            }
        }

        $seller_capabilities = self::get_core_seller_capabilities();

        foreach ( $seller_capabilities as $cap_group ) {
            foreach ( $cap_group as $cap ) {
                $wp_roles->remove_cap( 'seller', $cap );
            }
        }

        remove_role( 'buyer' );
        remove_role( 'seller' );
    }
}