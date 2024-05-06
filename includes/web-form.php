<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WebForm {

    public function initialize() {
        $this->contact_us_create_table();
        include_once MY_PLUGIN_PATH . 'includes/web-form-rest.php';
        include_once MY_PLUGIN_PATH . 'includes/web-form-shortcode.php';
        include_once MY_PLUGIN_PATH . 'includes/web-form-assets.php';
        include_once MY_PLUGIN_PATH . 'includes/admin/web-form-admin.php';
    }

    // Function to create the database table on plugin activation
    public function contact_us_create_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'contact_us_leads'; // Custom table name
        $charset_collate = $wpdb->get_charset_collate(); // Get charset and collate
        
        // SQL to create the table
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
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

        // Check for dbDelta errors
        $db_errors = $wpdb->last_error;
        if (!empty($db_errors)) {
            error_log('Database error: ' . $db_errors);
        }
    }
}

// Create the class instance once at the end
$webForm = new WebForm();
$webForm->initialize();
