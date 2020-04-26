<?php

  function cptui_register_my_cpts_deliveries() {

      /**
       * Post Type: Deliveries.
       */
      $labels = [
          "name"          => __("Deliveries", "sunbow-foods"),
          "singular_name" => __("Delivery", "sunbow-foods"),
      ];

      $args = [
          "label"                 => __("Deliveries", "sunbow-foods"),
          "labels"                => $labels,
          "description"           => "Captures scheduled delivery data",
          "public"                => true,
          "publicly_queryable"    => false,
          "show_ui"               => true,
          "show_in_rest"          => false,
          "rest_base"             => "",
          "rest_controller_class" => "WP_REST_Posts_Controller",
          "has_archive"           => false,
          "show_in_menu"          => true,
          "show_in_nav_menus"     => false,
          "delete_with_user"      => false,
          "exclude_from_search"   => false,
          "capability_type"       => "post",
          "map_meta_cap"          => true,
          "hierarchical"          => false,
          "rewrite"               => ["slug" => "deliveries", "with_front" => true],
          "query_var"             => true,
          "menu_icon"             => "dashicons-backup",
          "supports"              => ["title", "custom-fields"],
      ];

      register_post_type("deliveries", $args);
  }

  add_action('init', 'cptui_register_my_cpts_deliveries');