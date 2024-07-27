<?php

if ( !class_exists( 'MV_Slider_Post_Type' )) {
	class MV_Slider_Post_Type
	{
		function __construct()
		{
			add_action( 'init', array( $this, 'create_post_type' ));
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ));
			add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
		}
		public function create_post_type(){
			register_post_type(
				'mv-slider',
				array(
					'label' => 'Slider',
					'description'=> 'Sliders',
					'labels'=> array(
						'name' => 'Sliders',
						'singular_name' => 'Slider',
					),
					'public' => true,
					'supports' => array('title', 'editor', 'thumbnail', 'page-attributes'),
					'hierarchical' => true, // Hierarchical causes parent/child relationship (Default is false)
					'show_ui' => true, 
					'show_in_menu' => true, 
					'menu_position' => 5, // Set the position in the menu bar 5 means below Posts
					'show_in_admin_bar' => true, // Show in the admin bar on the top (Default is true)
					'show_in_nav_menus' => true, // Show in Appearance -> Menus (Default is true)
					'can_export' => true, // Tools -> Export (Default is true)
					'exclude_from_search' => false, // Exclude from Search result (Default is false)
					'publicly_queryable' => true, // Queryable by front end (Default is true)
					'show_in_rest' => true, /* Show in REST API (Default is false) (It's useful for pulling data from other site in JSON)
					* it also enables the block editor (The new post editor) for this post type
					*/
					'menu_icon' => 'dashicons-images-alt2', // Set the icon for the custom post type
					// 'register_meta_box_cb' => array( $this, 'add_meta_boxes' ), // You can add it here or use add_action
				)
			);
		}
		// Meta boxes are the boxes that appear on the post edit screen
		public function add_meta_boxes(){
			add_meta_box(
				'mv_slider_meta_box',
				'Link Options',
				array( $this, 'add_inner_meta_boxes' ),
				'mv-slider',
				'normal', // normal, side, advanced (Default is advanced) This is for the position of the meta box
				'high' // high, core, default, low (Default is default) This is for the priority of the meta box
			);
		}
		public function add_inner_meta_boxes( $post ){
			require_once ( MV_SLIDER_PATH . 'views/mv-slider_metabox.php' );
		}

		public function save_post( $post_id ){
			if (isset($_POST['action']) && $_POST['action'] == 'editpost') {
				$old_link_text = get_post_meta($post_id, 'mv_slider_link_text', true);
				$new_link_text = $_POST['mv_slider_link_text'];
				$old_link_url = get_post_meta($post_id, 'mv_slider_link_url', true);
				$new_link_url = $_POST['mv_slider_link_url'];

				update_post_meta($post_id, 'mv_slider_link_text', $new_link_text, $old_link_text);
				update_post_meta($post_id, 'mv_slider_link_url', $new_link_url, $old_link_url);
			}
		}
	}
}
