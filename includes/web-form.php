<?php

if (!defined('ABSPATH')) {
      die('You cannot be here');
}

if( !class_exists('WebForm') )
{
            class WebForm {
                public function __construct() {
                  register_activation_hook(__FILE__, array($this, 'contact_us_create_table'));
                }

                public function initialize()
                  {
                    include_once MY_PLUGIN_PATH . 'includes/web-form-rest.php';
                    include_once MY_PLUGIN_PATH . 'includes/web-form-shortcode.php';
                    include_once MY_PLUGIN_PATH . 'includes/web-form-assets.php';
                    include_once MY_PLUGIN_PATH . 'includes/admin/web-form-admin.php';  
                  }

                
                  // Function to create the database table on plugin activation
                function contact_us_create_table() {
                  global $wpdb;
                  $table_name = $wpdb->prefix . 'contact_us_leads'; // Custom table name
                  $charset_collate = $wpdb->get_charset_collate(); // Get charset and collate
                  
                  // SQL to create the table
                  $sql = "CREATE TABLE $table_name (
                      id INT AUTO_INCREMENT,
                      name VARCHAR(255),
                      email VARCHAR(255),
                      phone VARCHAR(255),
                      service_required VARCHAR(255),
                      created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                      PRIMARY KEY (id)
                  ) $charset_collate;";
                  
                  require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); // Include required upgrade functions
                  dbDelta($sql); // Create the table if it doesn't exist
                }
              }
            $webForm = new WebForm;
            $webForm->initialize();
}