<?php
/*
Plugin Name: Snat's Hostname Detector
Description: This plugin is designed that if you was using WordPress on more then one server that by just viewing the source code (or in the footer) you will be able to see which server the page was loaded from.
Version: 2.0
Author: Snat
Author URI: https://snat.co.uk/
License: GPLv2 or later
*/

function display_server_hostname_comment() {
  echo wp_kses_post("\n<!-- Server Hostname: " . gethostname() . " -->\n");
}

function display_server_hostname_footer() {
  echo wp_kses_post('<div style="text-align:center;">');
  echo wp_kses_post('Server Hostname: ' . gethostname());
  echo wp_kses_post('</div>');
}

// Add an option for Snat's Server Detector
function snats_plugins_page() {
  ?>
  <div class="wrap">
    <h1>Hostname Detector</h1>
    <p>Welcome to Snat's Hostname Detector settings.</p>
    <form method="post" action="options.php">
      <?php
        settings_fields('snats_server_detector');
        do_settings_sections('snats_server_detector');
        submit_button('Save Changes');
      ?>
    </form>
  </div>
  <?php
}

function snats_server_detector_init() {
  register_setting('snats_server_detector', 'snats_server_detector_settings');
  add_settings_section(
    'snats_server_detector_section',
    '',
    '',
    'snats_server_detector'
  );
  add_settings_field(
    'snats_server_detector_field',
    'Display Server Hostname:',
    'snats_server_detector_field_callback',
    'snats_server_detector',
    'snats_server_detector_section'
  );
}

function snats_server_detector_field_callback() {
  $options = get_option('snats_server_detector_settings');
  $selected_option = isset($options['display_type']) ? $options['display_type'] : 'comment';
  ?>
  <select name="snats_server_detector_settings[display_type]">
    <option value="comment" <?php selected($selected_option, 'comment'); ?>>As HTML comment within the code</option>
    <option value="footer" <?php selected($selected_option, 'footer'); ?>>As HTML at the bottom of the site</option>
  </select>
  <?php
}

add_action('admin_init', 'snats_server_detector_init');

// Display server hostname based on user option
$options = get_option('snats_server_detector_settings');
$display_type = isset($options['display_type']) ? $options['display_type'] : 'comment';
if ($display_type == 'comment') {
  add_action('wp_footer', 'display_server_hostname_comment');
} else {
  add_action('wp_footer', 'display_server_hostname_footer');
}

// Add a submenu item under "Settings"
function snats_plugins_menu() {
  add_submenu_page(
    'options-general.php',
    "Snat's Hostname Detector",
    "Snat's Hostname Detector",
    'manage_options',
    'snats-hostname-detector',
    'snats_plugins_page'
  );
}

add_action('admin_menu', 'snats_plugins_menu');
