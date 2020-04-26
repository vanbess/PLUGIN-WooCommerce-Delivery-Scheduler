<?php
  /* INSERT ORDER DELIVERY DATA */
  add_action('woocommerce_checkout_update_order_meta', 'sbds_delivery_data');
  function sbds_delivery_data($order_id) {

      /* first name */
      if (!empty($_POST['delivery_first_name'])):
          update_post_meta($order_id, 'delivery_first_name', sanitize_text_field($_POST['delivery_first_name']));
      endif;

      /* last name */
      if (!empty($_POST['delivery_last_name'])):
          update_post_meta($order_id, 'delivery_last_name', sanitize_text_field($_POST['delivery_last_name']));
      endif;

      /* contact no */
      if (!empty($_POST['delivery_contact_no'])):
          update_post_meta($order_id, 'delivery_contact_no', sanitize_text_field($_POST['delivery_contact_no']));
      endif;

      /* address 1 */
      if (!empty($_POST['delivery_address_1'])):
          update_post_meta($order_id, 'delivery_address_1', sanitize_text_field($_POST['delivery_address_1']));
      endif;

      /* address 2 */
      if (!empty($_POST['delivery_address_2'])):
          update_post_meta($order_id, 'delivery_address_2', sanitize_text_field($_POST['delivery_address_2']));
      endif;

      /* city or town */
      if (!empty($_POST['delivery_city_town'])):
          update_post_meta($order_id, 'delivery_city_town', sanitize_text_field($_POST['delivery_city_town']));
      endif;

      /* suburb */
      if (!empty($_POST['delivery_suburb'])):
          update_post_meta($order_id, 'delivery_suburb', sanitize_text_field($_POST['delivery_suburb']));
      endif;

      /* delivery date */
      if (!empty($_POST['delivery_date'])):
          update_post_meta($order_id, 'delivery_date', sanitize_text_field($_POST['delivery_date']));
      endif;

      /* delivery time */
      if (!empty($_POST['delivery_time'])):
          update_post_meta($order_id, 'delivery_time', sanitize_text_field($_POST['delivery_time']));
      endif;
  }