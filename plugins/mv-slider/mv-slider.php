<?php

/*
* Plugin Name: MV Slider
* Plugin URI: https://www.raulcano.dev
* Description: MV Slider is a simple and easy to use plugin that allows you to create stunning sliders in no time.
* Version: 1.0
* Requires at least: 3.0
* Author: Raul
* Author URI: https://www.raulcano.dev
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: mv-slider
* Domain Path: /languages
*/

/*
MV Slider is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

MV Slider is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with MV Slider. If not, see {URI to Plugin License}.
*/

// Make sure we don't expose any info if called directly
if (!defined('ABSPATH')) {
    die('What are you doing?');
    exit;
}

if (!class_exists('MV_Slider')) {
    class MV_Slider
    {
        function __construct()
        {
            $this->define_constants();
            $this->include_files(); 

            add_action( 'admin_menu', array( $this, 'add_menu' ) );

            $MV_Slider_Post_Type = new MV_Slider_Post_Type();

            $MV_Slider_Settings = new MV_Slider_Settings();

            $MV_Slider_Shortcode = new MV_Slider_Shortcode();
        }

        public function define_constants()
        {
            define('MV_SLIDER_PATH', plugin_dir_path(__FILE__));
            define('MV_SLIDER_URL', plugin_dir_url(__FILE__));
            define('MV_SLIDER_VERSION', '1.0.0');
        }

        public function include_files()
        {
            require_once MV_SLIDER_PATH . 'post-types/class.mv-slider-cpt.php';
            require_once MV_SLIDER_PATH . 'class.mv-slider-settings.php';
            require_once MV_SLIDER_PATH . 'shortcodes/class.mv-slider-shortcode.php';
        }

        public static function activate()
        {
            update_option('rewrite_rules', '');
        }

        public static function deactivate()
        {
            flush_rewrite_rules();
            unregister_post_type('mv-slider');
        }

        public static function uninstall()
        {
            // Clean up database, remove options, etc.
        }

        public function add_menu(){
            /* 
            * This function add_menu_page() can be changed to others like:
            * add_submenu_page() -> To add a submenu page
            * add_dashboard_page() -> To add a dashboard page
            * add_posts_page() -> To add a posts page
            * add_media_page() -> To add a media page
            * add_links_page() -> To add a links page
            * add_pages_page() -> To add a pages page
            * add_comments_page() -> To add a comments page
            * add_theme_page() -> To add a theme page.
            * add_options_page() -> To add an options page (settings). Etc.
            */
            add_menu_page(
                'MV Slider Options', // The text that will be displayed in the browser title
                'MV Slider', // The text that will be displayed in the menu
                'manage_options', // The capability required to see this menu
                'mv_slider_admin', // The slug of the menu
                array( $this, 'mv_slider_settings_page' ), // The function that will be called to display the page
                'dashicons-images-alt2',
            );
            add_submenu_page(
                'mv_slider_admin', // The slug of the parent menu
                'Manage Slides', // The text that will be displayed in the browser title
                'Manage Slides', // The text that will be displayed in the browser title
                'manage_options', // The capability required to see this menu
                '/edit.php?post_type=mv-slider', // The slug of the menu
                null, // The function that will be called to display the page
                null // The position of the menu -> null will be placed at the bottom
            );
            add_submenu_page(
                'mv_slider_admin',
                'Add New Slide',
                'Add New Slide',
                'manage_options',
                '/post-new.php?post_type=mv-slider',
                null,
                null
            );
        }
        public function mv_slider_settings_page(){
            if ( ! current_user_can( 'manage_options' ) ) {
                return;
            }
            if ( isset( $_GET['settings-updated'] ) ){
                add_settings_error( 'mv_slider_options', 'mv_slider_message', 'Settings saved', 'success' );
            }
            settings_errors( 'mv_slider_options' );
            require ( MV_SLIDER_PATH . 'views/settings-page.php' );
        }
    }
}

if (class_exists('MV_Slider')) {
    register_activation_hook(__FILE__, array('MV_Slider', 'activate'));
    register_deactivation_hook(__FILE__, array('MV_Slider', 'deactivate'));
    register_uninstall_hook(__FILE__, array('MV_Slider', 'uninstall'));

    $mv_slider = new MV_Slider();
}