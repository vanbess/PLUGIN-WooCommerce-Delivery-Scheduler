<?php
  /**
   * Plugin Name:       Silverback WC Delivery Scheduler
   * Description:       Allows for the scheduling of deliveries on the WooCommerce checkout page.
   * Version:           1.0.0
   * Requires at least: 5.2
   * Requires PHP:      7.2
   * Author:            Werner C. Bessinger
   * Author URI:        https://silverbackdev.co.za
   * License:           GPL v2 or later
   * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
   */
  /* prevent direct access */
  if (!defined('ABSPATH')):
      exit;
  endif;

  /* globals */
  define('SBDS_Path', plugin_dir_path(__FILE__));
  define('SBDS_Url', plugin_dir_url(__FILE__));

  /* check if ACF is defined; bail if false, else load core class */
  if (!class_exists('acf')):
      add_action('admin_notices', 'sbds_error');
      function sbds_error() {
          ?>
          <div class="error notice">
            <p>Advanced Custom Fields Pro is required for Silverback WC Delivery Scheduler to work properly. Please visit https://www.advancedcustomfields.com/pro/ to purchase and install.</p>
          </div>
          <?php
      }
  else:
      require SBDS_Path . 'classes/SBDS_Core.php';
      require SBDS_Path . 'cpts/sbds-deliveries.php';
      require SBDS_Path . 'functions/sbds-update-order-delivery-data.php';
      require SBDS_Path . 'functions/sbds-insert-delivery.php';
      require SBDS_Path . 'functions/sbds-custom-delivery-columns.php';
  endif;
?>
  