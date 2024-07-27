<?php

if ( !class_exists( 'MV_Slider_Post_Type' )) {
	class MV_Slider_Post_Type
	{
		function __construct()
		{
			add_action( 'init', array( $this, 'create_post_type' ));
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
				)
			);
		}
	}
}
