<?php

/*
 * Plugin Name:       Test Task Plugin
 * Description:       The plugin is test task
 * Version:           1.0.0
 * Author:            Roman Piatyntsev
 * Author URI:        https://test.kruto.biz/
 * Text Domain:       ttp_locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Test_Task {

    private static $_instance;

    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    private function __construct() {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();
    }

    private function define_constants() {
        $this->define( 'TT_DIR', plugin_dir_path( __FILE__ ) );
        $this->define( 'TT_URL', plugin_dir_url( __FILE__ ) ) ;
    }

    private function includes() {
        require_once TT_DIR . 'includes/config/class-tt-auto-loader.php';
    }

    private function init_hooks() {
        register_activation_hook( __FILE__, array( 'TT_Install', 'install' ) );
        ( new TT_Manager() )->run();
    }

    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }
}

Test_Task::get_instance();