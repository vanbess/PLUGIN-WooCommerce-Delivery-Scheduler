<?php

  /* INSERTS DELIVERY POST TYPE AND ATTACHES CUSTOM DELIVERY META */
  add_action('woocommerce_thankyou', 'sbds_insert_delivery', 10, 1);
  function sbds_insert_delivery($order_id) {

      $del_fname      = get_post_meta($order_id, 'delivery_first_name', true);
      $del_lname      = get_post_meta($order_id, 'delivery_last_name', true);
      $del_contact_no = get_post_meta($order_id, 'delivery_contact_no', true);
      $del_address_1  = get_post_meta($order_id, 'delivery_address_1', true);
      $del_address_2  = get_post_meta($order_id, 'delivery_address_2', true);
      $del_city_town  = get_post_meta($order_id, 'delivery_city_town', true);
      $del_suburb     = get_post_meta($order_id, 'delivery_suburb', true);
      $del_date       = get_post_meta($order_id, 'delivery_date', true);
      $del_time       = get_post_meta($order_id, 'delivery_time', true);

      $del_args = [
          'post_type'   => 'deliveries',
          'post_status' => 'publish',
          'post_title'  => 'Delivery for Order #' . $order_id,
          'meta_input'  => [
              'del_order_no'   => $order_id,
              'del_date'       => $del_date,
              'del_time'       => $del_time,
              'del_fname'      => $del_fname,
              'del_lname'      => $del_lname,
              'del_contact_no' => $del_contact_no,
              'del_add_line_1' => $del_address_1,
              'del_add_line_2' => $del_address_2,
              'del_city_town'  => $del_city_town,
              'del_suburb'     => $del_suburb,
              'del_status'     => 'Booked for delivery'
          ]
      ];

      $delivery_inserted = wp_insert_post($del_args);

      if ($delivery_inserted):
          update_post_meta($order_id, 'delivery_id', $delivery_inserted);
      endif;
  }
  