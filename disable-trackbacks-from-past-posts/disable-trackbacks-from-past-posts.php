<?php
/**
 * Plugin Name: Disable Trackbacks From Past Posts
 * Description: This will allow the user to globally disable trackbacks on pass posts. This is a simple utility plugin meant to run once.
 * Version: 0.1.0
 * Author: leadiv
 **/
 
class Disable_Trackbacks_From_Past_Posts {
	public Disable_Trackbacks_From_Past_Posts() {
		if ( !get_option( 'Disable_Trackbacks_From_Past_Posts_flag', false ) ) {
			add_action( 'admin_init', array( $this, 'disable_trackbacks' );
		}
	}
	
	/**
	 * Triggers the constructor without needing to set it to a variable.
	 * @since 0.1.0
	 **/
	public static run() {
		return new Disable_Trackbacks_From_Past_Posts();
	}
	
	/**
	 * Runs the SQL querys needed to disable trackbacks on posts and pages.
	 * @since 0.1.0
	 **/
	public disable_trackbacks() {
		global $wpdb;
		
		$wpdb->query( $wpdb->prepare(
			"
			UPDATE $wpdb->posts 
			SET ping_status='closed' 
			WHERE 
				post_status = 'publish' AND post_type = 'post'
			"
		) );
		
		$wpdb->query( $wpdb->prepare (
			"
			UPDATE $wpdb->posts 
			SET ping_status='closed' 
			WHERE 
				post_status = 'publish' AND post_type = 'page'
			"
		) );
		
		update_option( 'Disable_Trackbacks_From_Past_Posts_flag', true );
	}
}

Disable_Trackbacks_From_Past_Posts::run();