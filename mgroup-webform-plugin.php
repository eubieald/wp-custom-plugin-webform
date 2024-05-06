<?php
/**
 * Plugin Name: Mgroup Webform
 * Description: A basic webform.
 * Author: Eubie Aluad
 * Version: 1.0
 * Text Domain: mgroup-webform
 */

if (!defined('ABSPATH')) {
    exit;
}

if( !class_exists('MgroupWebformPlugin') )
{
            class MgroupWebformPlugin {

                  public function __construct()
                  {
                        define('MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ));
                        define('MY_PLUGIN_URL', plugin_dir_url( __FILE__ ));
                  }

                  public function initialize()
                  {
                        include_once MY_PLUGIN_PATH . 'includes/web-form.php';
                  }


            }

            $mgroupWebformPlugin = new MgroupWebformPlugin;
            $mgroupWebformPlugin->initialize();

}
