<?php
/*
Plugin Name: WP Disclaimer
Plugin URI: http://wp-disclaimer.horttcore.de/
Description: Users have to accept a disclaimer to register an account
Author: Ralf Hortt
Version: 2.0
Author URI: http://horttcore.de/
*/



/**
 *
 * Security, checks if WordPress is running
 *
 **/
if ( !function_exists('add_action') ) :
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
endif;



/**
* WP DISCLAIMER
*/
if ( !class_exists( 'WP_DISCLAIMER' ) ) :
	
	class WP_Disclaimer
	{



		/**
		 * Construct
		 *
		 * @author Ralf Hortt
		 */
		function __construct()
		{
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'admin_menu', array( $this, 'add_menu' ) );
			add_action( 'register_form', array( $this, 'registration_form' ) );
			add_action( 'registration_errors', array( $this, 'check_registration' ) );
			add_shortcode( 'DISCLAIMER', array( $this, 'shortcode_disclaimer' ) );
		}



		/**
		 * Add menu entry
		 *
		 * @access public
		 * @return void
		 * @author Ralf Hortt
		 **/
		public function add_menu()
		{
			add_options_page(__('Disclaimer', 'wp-disclaimer'), __('Disclaimer', 'wp-disclaimer'), 'promote_users', 'wp-disclaimer', array( $this, 'management' ) );
		}



		/**
		 * Checks if the disclaimer is checked
		 *
		 * @access public
		 * @return void
		 * @author Ralf Hortt
		 **/
		public function check_registration( $error )
		{
			if ( 'accept' != $_POST['disclaimer_accept'] ) :
				$error_msg = '<strong>' . __('ERROR:', 'wp-disclaimer') . '</strong> ';
				$error_msg.= __('You have to accept the disclaimer to register an account', 'wp-disclaimer');
				$error->add( 'error', apply_filters( 'wp-disclaimer-error', $error_msg ) );
				return $error;
			else :
				return $error;
			endif;
		}



		/**
		 * Plugin Init
		 *
		 * @access public
		 * @return void
		 * @author Ralf Hortt
		 **/
		public function init()
		{
			load_plugin_textdomain( 'wp-disclaimer', false, 'wp-disclaimer' );
		}



		/**
		 * Extend the login form
		 *
		 * @access public
		 * @return void
		 * @author Ralf Hortt
		 **/
		public function registration_form()
		{
			?>
			<p class="disclaimer" style="margin: 0 0 15px">
				<label for="disclaimer"><?php _e( 'Disclaimer', 'wp-disclaimer' ); ?></label><br>
				<textarea name="disclaimer" id="disclaimer" style="width: 270px; height: 100px; resize: vertical"><?php WP_Disclaimer::the_disclaimer() ?></textarea><br>
				<input name="disclaimer_accept" value="accept" id="disclaimer_accept" type="checkbox" /> <label for="disclaimer_accept"> <?php _e( 'Accecpt Disclaimer', 'wp-disclaimer' ); ?></label>
			</p>
			<?php
		}



		/**
		 * Your disclaimer text
		 *
		 * @access public
		 * @static
		 * @param boolean $nl2br Convert new lines to breaks; default true
		 * @return string Disclaimer Text
		 * @author Ralf Hortt
		 **/
		public static function get_disclaimer( $nl2br = TRUE )
		{
			$disclaimer = get_option('wp-disclaimer');
			return ( TRUE === $nl2br ) ? apply_filters( 'wp-disclaimer', nl2br( $disclaimer ) ) : apply_filters( 'wp-disclaimer', stripslashes( $disclaimer ) );
		}



		/**
		 * Management Page
		 *
		 * @access public
		 * @return void
		 * @author Ralf Hortt
		 **/
		public function management()
		{
			if ( $_POST && wp_verify_nonce( $_POST['wp-disclaimer-nonce'], 'save-disclaimer' ) ) :
				update_option( 'wp-disclaimer', apply_filters( 'wp-disclaimer-save', $_POST['wp-disclaimer'] ) );
			endif;

			?>
			<div class="wrap">
				<h2>Disclaimer</h2>
				<form method="post">
					<?php wp_editor( $this->get_disclaimer( FALSE ) , 'wp-disclaimer' ) ?>
					<p class="submit"><button type="submit" class="button button-primary"><?php _e( 'Save changes', 'wp-disclaimer' ) ?></button></p>
					<?php wp_nonce_field( 'save-disclaimer', 'wp-disclaimer-nonce' ) ?>
				</form>
			</div>
			<?php
		}



		/**
		 * Shortcode Funktion
		 *
		 * @access public
		 * @return void
		 * @author Ralf Hortt
		 **/
		public function shortcode_disclaimer()
		{
			return $this->get_disclaimer();
		}



		/**
		 * Template Tag the_disclaimer();
		 *
		 * @access public
		 * @static
		 * @return void
		 * @author Ralf Hortt
		 **/
		public static function the_disclaimer()
		{
			echo WP_Disclaimer::get_disclaimer();
		}



	}

	$WP_Disclaimer = new WP_Disclaimer();
	
endif;