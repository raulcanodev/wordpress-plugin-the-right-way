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

            $MV_Slider_Post_Type = new MV_Slider_Post_Type();
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
    }
}

if (class_exists('MV_Slider')) {
    register_activation_hook(__FILE__, array('MV_Slider', 'activate'));
    register_deactivation_hook(__FILE__, array('MV_Slider', 'deactivate'));
    register_uninstall_hook(__FILE__, array('MV_Slider', 'uninstall'));

    $mv_slider = new MV_Slider();
}