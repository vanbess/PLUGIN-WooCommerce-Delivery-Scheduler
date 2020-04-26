<?php

  /**
   * Renders backend and frontend display of delivery scheduler
   *
   * @author Werner C. Bessinger
   */
  class SBDS_Core {
      /**
       * Init class
       */
      public static function init() {
          self::sbds_front();
          self::sbds_back();
          add_action('wp_ajax_check_available_slots', [__CLASS__, 'check_available_slots']);
          add_action('wp_ajax_no_priv_check_available_slots', [__CLASS__, 'check_available_slots']);
      }

      /**
       * Render front-end HTML
       */
      public static function sbds_front() {

          /* delivery first name */
          add_action('woocommerce_before_order_notes', 'delivery_first_name');
          function delivery_first_name($checkout) {
              ?>

              <!-- delivery data cont -->
              <div id="delivery_data_cont" class="mb-4">
                <!-- del heading -->
                <h3 id="del_heading">Specify delivery time and info</h3>

                <p class="alert shadow-sm" style="background: #003471; color: white; margin-top: 15px;">
                  Please specify a delivery address and contact person for your order. Your billing details are used by default, but you can specify different delivery info below if required.
                </p>

                <!-- additional input classes -->
                <script type="text/javascript">
                      jQuery(function ($) {
                         $('select#delivery_time').addClass('form-control');
                      });
                </script>

                <?php
                woocommerce_form_field('delivery_first_name', array(
                    'label'       => 'Contact person',
                    'type'        => 'text',
                    'required'    => true,
                    'placeholder' => 'First name',
                    'default'     => WC()->customer->get_first_name(),
                ), $checkout->get_value('delivery_first_name'));
            }

            /* delivery last name */
            add_action('woocommerce_before_order_notes', 'delivery_last_name');
            function delivery_last_name($checkout) {
                woocommerce_form_field('delivery_last_name', array(
                    'type'        => 'text',
                    'required'    => true,
                    'placeholder' => 'Last name',
                    'default'     => WC()->customer->get_last_name(),
                ), $checkout->get_value('delivery_last_name'));
            }

            /* delivery contact no */
            add_action('woocommerce_before_order_notes', 'delivery_contact_no');
            function delivery_contact_no($checkout) {
                woocommerce_form_field('delivery_contact_no', array(
                    'type'     => 'tel',
                    'label'    => 'Contact number',
                    'required' => true,
                    'default'  => WC()->customer->get_billing_phone(),
                ), $checkout->get_value('delivery_contact_no'));
            }

            /* address 1 */
            add_action('woocommerce_before_order_notes', 'delivery_address_1');
            function delivery_address_1($checkout) {
                woocommerce_form_field('delivery_address_1', array(
                    'type'        => 'text',
                    'label'       => 'Delivery address',
                    'required'    => true,
                    'placeholder' => 'House number and street name',
                    'default'     => WC()->customer->get_billing_address_1(),
                ), $checkout->get_value('delivery_address_1'));
            }

            /* address 2 */
            add_action('woocommerce_before_order_notes', 'delivery_address_2');
            function delivery_address_2($checkout) {
                woocommerce_form_field('delivery_address_2', array(
                    'type'        => 'text',
                    'required'    => false,
                    'placeholder' => 'Apartment, suite, unit etc. (optional)',
                    'default'     => WC()->customer->get_billing_address_2(),
                ), $checkout->get_value('delivery_address_2'));
            }

            /* city or town */
            add_action('woocommerce_before_order_notes', 'delivery_city_town');
            function delivery_city_town($checkout) {
                woocommerce_form_field('delivery_city_town', array(
                    'type'        => 'text',
                    'label'       => 'Town / City',
                    'required'    => true,
                    'placeholder' => 'City or town',
                    'default'     => WC()->customer->get_billing_city(),
                ), $checkout->get_value('delivery_city_town'));
            }

            /* suburb */
            add_action('woocommerce_before_order_notes', 'delivery_suburb');
            function delivery_suburb($checkout) {
                woocommerce_form_field('delivery_suburb', array(
                    'type'        => 'text',
                    'label'       => 'Suburb',
                    'required'    => true,
                    'placeholder' => 'Suburb or extension'
                ), $checkout->get_value('delivery_suburb'));
            }

            /* delivery date */
            add_action('woocommerce_before_order_notes', 'delivery_date');
            function delivery_date($checkout) {
                woocommerce_form_field('delivery_date', array(
                    'type'     => 'date',
                    'label'    => 'Delivery date',
                    'required' => true,
                ), $checkout->get_value('delivery_date'));
            }

            /* delivery time */
            add_action('woocommerce_before_order_notes', 'delivery_time');
            function delivery_time($checkout) {

                if (get_field('del_start', 'option')):
                    $time_from = strtotime(get_field('del_start', 'option'));
                else:
                    $time_from = strtotime('13:00');
                endif;

                if (get_field('del_end', 'option')):
                    $time_to = strtotime(get_field('del_end', 'option'));
                else:
                    $time_to = strtotime('17:00');
                endif;

                $hours_difference = abs($time_from - $time_to) / 3600;
                $counter          = 0;
                $options          = ['' => 'Please select...'];
                ?>

                <?php
                while ($counter <= $hours_difference):
                    $options[date('H:', $time_from + (3600 * $counter)) . '00'] = date('H:', $time_from + (3600 * $counter)) . '00';
                    $counter++;
                endwhile;

                woocommerce_form_field('delivery_time', array(
                    'type'     => 'select',
                    'label'    => 'Delivery time',
                    'required' => true,
                    'options'  => $options
                ), $checkout->get_value('delivery_time'));
                ?>
              </div>

              <!-- styles front -->
              <style>
                p#delivery_first_name_field {
                    width: 48%;
                    float: left;
                    margin-right: 20px;
                }

                p#delivery_last_name_field {
                    width: 48%;
                    float: left;
                    margin-top: 40px;
                }

                p#delivery_contact_no_field {
                    clear: both;
                }

                p#delivery_date_field {
                    width: 48%;
                    float: left;
                    margin-right: 20px;
                }

                p#delivery_time_field {
                    width: 48%;
                    float: left;
                }

                div#delivery_data_cont {
                    overflow: auto;
                }
                span#del_date_msg, span#del_time_msg {
                    display: block;
                    margin-top: 10px;
                    font-weight: 500;
                    font-size: 14px;
                }
              </style>

              <?php $ajax_url = admin_url('admin-ajax.php'); ?>

              <!-- js to check available time slots -->
              <script type="text/javascript">
                    jQuery(document).ready(function ($) {

                       /* ajax url */
                       var ajax_url = '<?php echo $ajax_url; ?>';

                       /* delivery date message container */
                       $('p#delivery_date_field').append('<span id="del_date_msg" class="text-center"></span>');

                       /* delivery time message container */
                       $('p#delivery_time_field').append('<span id="del_time_msg" class="text-center"></span>');

                       $('#delivery_date').on('change', function () {

                          $('#del_time_msg').text('');
                          $('#delivery_time').val('');

                          var del_date = $(this).val();
                          var data = {
                             'action': 'check_available_slots',
                             'del_date': del_date
                          };
                          $.post(ajax_url, data, function (response) {
                             $('#del_date_msg').text(response);
                          });
                       });

                       $('#delivery_time').on('change', function () {
                          var del_time = $(this).val();
                          var selected_date = $('#delivery_date').val();
                          var data = {
                             'action': 'check_available_slots',
                             'del_time': del_time,
                             'selected_date': selected_date
                          };
                          $.post(ajax_url, data, function (response) {
                             $('#del_time_msg').text(response);
                          });
                       });
                    });
              </script>

              <?php
          }
      }

      /**
       * Render backend HTML etc
       */
      public static function sbds_back() {
          if (function_exists('acf_add_options_page')) {

              acf_add_options_page(array(
                  'page_title' => 'Delivery Scheduler Settings',
                  'menu_title' => 'Delivery Settings',
                  'menu_slug'  => 'delivery-scheduler-settings',
                  'position'   => 8,
                  'capability' => 'edit_posts',
                  'redirect'   => false,
              ));
          }
      }

      /**
       * Get available slots via ajax
       */
      public static function check_available_slots() {

          /* DELIVERY DATE SELECTED */
          if (!empty($_POST['del_date'])):

              /* get delivery date */
              $del_date = $_POST['del_date'];

              /* get delivery day of the week */
              $del_day = date('l', strtotime($del_date));

              /* get current date */
              $current_date = date('Y-m-d');

              /* if delivery date older than current date, bail */
              if ($del_date < $current_date):
                  echo 'Please select today\'s date or later!';
                  wp_die();
              endif;

              /* get defined delivery days in settings */
              $defined_del_days = get_field('del_days', 'option');

              /* count defined delivery days */
              $def_days_count = count($defined_del_days);

              /* if selected day is in defined day list, echo confirmation message */
              if (in_array($del_day, $defined_del_days)):
                  echo 'We can deliver on this day and date. Please specify a delivery time slot.';
              else:
                  echo 'Sorry, we only deliver on ';
                  $counter = 1;
                  foreach ($defined_del_days as $day) :
                      if ($counter < $def_days_count):
                          echo $day . 's, ';
                      else:
                          echo 'and ' . $day . 's.';
                      endif;
                      $counter++;
                  endforeach;
              endif;
              wp_die();

          endif;

          /* DELIVERY TIME SELECTED */
          if (!empty($_POST['del_time'])):

              $del_time      = $_POST['del_time'];
              $selected_date = $_POST['selected_date'];

              if ($selected_date == ''):
                  echo 'Please select a delivery date first!';
                  wp_die();
              else:

                  $max_slots     = get_field('max_slots', 'option');
                  $counted_slots = 1;

                  $deliveries = new WP_Query([
                      'post_type'      => 'deliveries',
                      'posts_per_page' => -1,
                      'meta_key'       => 'del_date',
                      'meta_value'     => $selected_date
                  ]);

                  if ($deliveries->have_posts()):
                      while ($deliveries->have_posts()) :
                          $deliveries->the_post();

                          $booked_time = get_field('del_time');

                          if ($booked_time == $del_time):
                              $counted_slots++;
                          endif;

                      endwhile;
                      wp_reset_postdata();

                      if ($counted_slots < $max_slots):
                          echo 'We have delivery slots open for this time slot.';
                      else:
                          echo 'Sorry, we are fully booked for this time slot. Please choose a different time.';
                      endif;
                  else:
                      echo 'We have delivery slots open for this time slot.';
                  endif;
                  wp_die();
              endif;
          endif;
      }
  }

  SBDS_Core::init();