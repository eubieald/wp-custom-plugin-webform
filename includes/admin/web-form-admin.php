<?php
// Add a new menu item to the WordPress admin for viewing leads
function contact_us_add_admin_menu() {
    add_menu_page(
        'Leads', // Page title
        'Leads', // Menu title
        'manage_options', // Capability required
        'contact-us-leads', // Menu slug
        'contact_us_display_leads_page', // Function to display content
        'dashicons-admin-generic', // Icon
        20 // Position in the menu
    );
}

add_action('admin_menu', 'contact_us_add_admin_menu');

// Function to display the leads page in the admin
function contact_us_display_leads_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_us_leads';
    
    // Get all leads from the database, ordered by the newest first
    $leads = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    
    // Display the leads in a table format
    ?>
    <div class="wrap">
        <h1>Leads</h1>
        <table class="widefat striped mgroup-webform-leads-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Service Required</th>
                    <th>Date Submitted</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $lead) : ?>
                    <tr>
                        <td><?php echo esc_html($lead->name); ?></td>
                        <td class="ta-left"><?php echo esc_html($lead->email); ?></td>
                        <td><?php echo esc_html($lead->phone); ?></td>
                        <td class="ta-left"><?php echo esc_html($lead->service_required); ?></td>
                        <td><?php echo esc_html($lead->created_at); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
