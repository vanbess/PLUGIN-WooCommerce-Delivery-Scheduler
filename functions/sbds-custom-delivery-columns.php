<?php

  /* CUSTOM COLUMNS FOR DELIVERY POST TYPE IN BACKEND */

  /* insert custom columns */
  add_filter('manage_deliveries_posts_columns', 'sbds_insert_custom_post_columns');
  function sbds_insert_custom_post_columns($columns) {
      unset($columns['date']);
      unset($columns['title']);

      $columns['del_order_no']       = 'Order #';
      $columns['del_contact_person'] = 'Contact person';
      $columns['del_contact_no']     = 'Contact number';
      $columns['del_address']        = 'Delivery address';
      $columns['del_time_slot']      = 'Time slot';
      $columns['del_date']           = 'Delivery date';
      $columns['del_status']         = 'Delivery status';

      return $columns;
  }

  /* add data to custom columns */
  add_action('manage_deliveries_posts_custom_column', 'sbds_custom_column_data', 10, 2);
  function sbds_custom_column_data($column, $post_id) {

      switch ($column):

          /* order no */
          case 'del_order_no':
              echo get_post_meta($post_id, 'del_order_no', true);
              break;

          /* contact person */
          case 'del_contact_person':
              echo get_post_meta($post_id, 'del_fname', true) . ' ' . get_post_meta($post_id, 'del_lname', true);
              break;

          /* contact no */
          case 'del_contact_no':
              echo get_post_meta($post_id, 'del_contact_no', true);
              break;

          /* delivery address */
          case 'del_address':
              echo get_post_meta($post_id, 'del_add_line_1', true) . '<br>';
              if (get_post_meta($post_id, 'del_add_line_2', true)):
                  echo get_post_meta($post_id, 'del_add_line_2', true) . '<br>';
              endif;
              echo get_post_meta($post_id, 'del_city_town', true) . '<br>';
              echo get_post_meta($post_id, 'del_suburb', true);
              break;

          /* time slot */
          case 'del_time_slot':
              echo get_post_meta($post_id, 'del_time', true);
              break;

          /* del date */
          case 'del_date':
              echo date('j F Y', strtotime(get_post_meta($post_id, 'del_date', true)));
              break;
          
          /* del status */
          case 'del_status':
              echo get_post_meta($post_id, 'del_status', true);
              break;
      endswitch;
  }
  