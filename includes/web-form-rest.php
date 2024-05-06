<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('rest_api_init', array('WebFormREST', 'register_rest_api')); // Static callback

class WebFormREST {
    public static function register_rest_api() { // Static method
        register_rest_route(
            'mgroup-web-form/v1',
            'submit-form',
            array(
                'methods' => 'POST',
                'callback' => array(__CLASS__, 'handle_contact_form_submission'), // Static callback
                'permission_callback' => '__return_true', // Allow public access
            )
        );
    }

    public static function handle_contact_form_submission($request) {
        global $wpdb;
    
        // Get the form data from the request
        $params = $request->get_params();
    
        // Check nonce
        $nonce = isset($params['_wpnonce']) ? $params['_wpnonce'] : '';
        if (!wp_verify_nonce($nonce, 'wp_rest')) {
            return new WP_REST_Response('Invalid nonce', 401);
        }
    
        // Extract form data
        $name = isset($params['name']) ? sanitize_text_field($params['name']) : '';
        $email = isset($params['email']) ? sanitize_email($params['email']) : '';
        $phone = isset($params['phone']) ? sanitize_text_field($params['phone']) : '';
        $service_required = isset($params['service-required']) ? sanitize_text_field($params['service-required']) : '';
    
        // Insert data into custom table
        $table_name = $wpdb->prefix . 'contact_us_leads'; // Adjust table name as needed
        $data = array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'service_required' => $service_required,
            'created_at' => current_time('mysql'),
        );
        $insert_result = $wpdb->insert($table_name, $data);
    
        // Check for errors
        if ($wpdb->last_error) {
            return new WP_REST_Response('Error: ' . $wpdb->last_error, 500); // Return database error
        }
    
        // Return response
        if ($insert_result) {
            return new WP_REST_Response('Thank you for your submission! Rest assured we will get back to you shortly.', 200);
        } else {
            return new WP_REST_Response('Failed to submit the form. Please try again later.', 500); // Return generic error
        }
    }
    
}


