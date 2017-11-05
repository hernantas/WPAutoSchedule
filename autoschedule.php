<?php
    /*
    Plugin Name: Auto Scheduling
    Plugin URI: https://www.hernantas.com/autoschedule
    Description: a plugin to automatically set your post schedule
    Version: 1.0
    Author: Zulfikar Raditya Hernanta
    Author URI: https://www.hernantas.com
    License: MIT
    */

    define( 'AutoSchedule\PLUGIN_PATH' , plugin_dir_path(__FILE__) );
    define( 'AutoSchedule\PLUGIN_URL' , plugin_dir_url(__FILE__) );

    require(\AutoSchedule\PLUGIN_PATH . 'functions/plugins.php');
    require(\AutoSchedule\PLUGIN_PATH . 'functions/setting_page.php');

    $plugin = new \AutoSchedule\Plugins();
?>