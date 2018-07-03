<?php

/*

Plugin Name: Post icon

Plugin URI: https://github.com/UlianaLiubimska/post-icon

Description: A simple plugin to add icon to post titles.

Author: Uliana Liubimska

Version: 1.0

*/

define( 'PI_PATH', plugin_dir_path( __FILE__ ) );

if ( is_admin() ) {

	require_once( PI_PATH . 'dashicons.php' );
	require_once( PI_PATH . 'admin-page.php' );
}

/**
 *  Add icon to the title in frontend
 */
class Post_Icon
{
	
	function __construct()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_style' ) );

		add_filter( 'the_title', array( $this, 'show_icon' ) );
	}

	public static function frontend_style()
	{

		wp_enqueue_style( 'frontend-style', plugins_url( 'css/frontend-style.css', __FILE__ ) );

	}
	public static function show_icon( $title, $id = null )
	{

		if ( !is_admin() ) {

			if ( get_option('enable_plagin') ) {

				if ($id == null) {

					global $post;

					$id = $post->ID;

				}

				if ( in_array($id, get_option('checked_posts') ) ) {

					$checked_dashicon = get_option("selected_icon");

					if ( 'before' == get_option('icon_position') ) {

						$title = '<span class="dashicons  dashicons-'.$checked_dashicon.'"></span> '.$title;

					} else {

						$title = $title.' <span class="dashicons  dashicons-'.$checked_dashicon.'"></span>';

					}

				}
			}

		}

		return $title;

	}
}

new Post_Icon;