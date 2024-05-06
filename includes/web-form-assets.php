<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('wp_enqueue_scripts', array('WebFormAssets', 'load_assets'));
add_action('wp_footer', 'WebFormAssets::inject_inline_scripts');
add_action('admin_enqueue_scripts', 'WebFormAssets::enqueue_admin_table_styles'); // Add this line

class WebFormAssets {
    // Register action for loading assets
    public static function load_assets() {
        wp_enqueue_style(
            'web-form-css',
            plugin_dir_url(__FILE__) . '../css/style.css',
            array(),
            '1.0.0',
            'all'
        );

        // Enqueue jQuery from CDN
        wp_enqueue_script(
            'jquery',
            'https://code.jquery.com/jquery-3.6.0.min.js',
            array(),
            '3.6.0',
            true // Load in footer
        );
    }

    // Register action for injecting inline scripts in the footer
    public static function inject_inline_scripts() {
        ?>
        <script>
            jQuery(document).ready(function($) {
                $('#web-form').on('submit', function(e) {
                    e.preventDefault();
                    const form = $(this);
                    const formData = form.serialize();
                    const nonce = form.find('input[name="_wpnonce"]').val();

                    $.ajax({
                        method: 'post',
                        url: '<?php echo get_rest_url(null, 'mgroup-web-form/v1/submit-form'); ?>',
                        headers: {
                            'X-WP-Nonce': nonce
                        },
                        data: formData,
                        success: function(response) {
                            $('.form-wrapper').html('<p class="response-message">' + response + '</p>');
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
        <?php
    }

    // Method to enqueue admin table styles
    public static function enqueue_admin_table_styles() {
        // Enqueue CSS file for admin table styling
        wp_enqueue_style(
            'admin-table-styles',
            plugin_dir_url(__FILE__) . '../css/admin/style-admin.css',
            array(),
            '1.0.0',
            'all'
        );
    }
}
