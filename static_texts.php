<?php
/*
Plugin Name: Static Texts
Plugin URI: http://gidd.org/wordpress-plugins/static-texts-wordpress-theme/
Description: Static Texts plugin helps you put short texts on your WordPress site. This can be useful for some kinds of texts such as highlights, feature reviews, welcome/introduction texts, contact information and more. Static Texts can be useful for short messages, video/image embed or any other HTML contents that are not suitable for a post or page.
Version: 1.0.0
Author: Vichet Sen
Author URI: http://gidd.org
License: GPL2 or later
*/


//function to get static contents
function get_static_texts( $post_id ){
	$post 		 = get_post( $post_id );
	$content 	 = '<div class="static-texts text-'. $post_id .'">';
	$content	.= apply_filters( 'the_content', $post->post_content );
	$content	.= '</div>';
	return $content;
}

//post type
add_action('init', 'gidd_static_texts_post_type', 1);
function gidd_static_texts_post_type(){	
	
	if ( current_user_can( 'edit_themes' ) ){

		register_post_type( "static_texts",
		array(
			'labels' => array(
				'name' => __( "Static Texts" ),
				'singular_name' => __( 'Static Texts' ),
				'add_new' => __( "Add Static Texts" ),
				'add_new_item' => __( "Add Static Texts" ),
				'edit_item' => __( "Edit Static Texts" ),
				'view_item' => __( "Read Static Texts" )
			),
			'public' => true,
			'show_ui' => true,
			'exclude_from_search' => true,
			'rewrite' => array('slug' => "static-texts", 'with_front' => false),
			'capability_type' => 'post',
			'show_in_nav_menus' => false,
			'has_archive' => false,
			'menu_position' => 100,
			'taxonomies' => array(),
			'supports' => array("title", "editor") )
		);
		
	}
}

//columns
add_action('manage_posts_custom_column', 'manage_static_texts_columns');
function manage_static_texts_columns( $column ){

	if ( current_user_can( 'edit_themes' ) ){
		global $post;	
		$postid = isset( $post->ID ) ? $post->ID : 0;
		if ("blockcode" == $column){ 
			echo htmlspecialchars( "<?php if( function_exists( 'get_static_texts' ) ){ echo get_static_texts($postid); } ?>" ); 
		}
	}
	
}

//column filters
add_filter( 'manage_edit-static_texts_columns', 'gidd_edit_static_texts_columns' );
function gidd_edit_static_texts_columns( $columns ) {
	
	if ( current_user_can( 'edit_themes' ) ){
		$columns = array(
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title' ),
			'blockcode' => __( 'Template Code' ),
		);
	}
	
	return $columns;
}


/** end */