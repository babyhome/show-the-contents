<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( !class_exists( 'STC_SHOW_CONTENTS') ) :

	class STC_SHOW_CONTENTS {

		public function __construct() {


			add_action( 'wp_enqueue_scripts', array( $this, 'stc_enqueue_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'stc_enqueue_admin' ) );
			add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );

			add_action( 'plugins_loaded', array( $this, 'stc_text_domain' ) );

			register_activation_hook( __FILE__, array( $this, 'stc_activated' ) );
        	register_deactivation_hook( __FILE__, array( $this, 'stc_deactivation' ) );

		}







		public function stc_text_domain() {
			
			// $local 	= apply_filters( 'plugin_locale', get_locale(), 'stc' );
			
			load_plugin_textdomain( 'stc', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );

		}


		public function stc_enqueue_scripts() {

			$plugin_url 	= plugin_dir_url( __FILE__ );

			wp_enqueue_script( 'jquery' );

			// Register JS
			wp_enqueue_script( 'stc_scripts', plugins_url( '/assets/js/frontend-scripts.js', __FILE__ ), array( 'jquery' ) );
			wp_enqueue_script( 'imagesloaded.js', plugins_url( '/assets/js/imagesloaded.pkgd.min.js', __FILE__), array( 'jquery' ) );
			wp_enqueue_script( 'font-awesome-script', plugins_url( '/assets/fontawesome/js/fontawesome.min.js', __FILE__ ), array( 'jquery' ) );

			wp_enqueue_style( 'font-awesome-all', STC_URI . 'assets/fontawesome/css/all.min.css' );
			wp_enqueue_style( 'font-awesome', STC_URI . 'assets/fontawesome/css/fontawesome.min.css' );
			// wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.0.4/css/all.css'); 
			// Register CSS
			wp_enqueue_style( 'stc-style', STC_URI . '/assets/css/style.css' );
			
		}

		
		public function stc_enqueue_admin() {

			$screen 	= get_current_screen();

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-sortable');
			
			wp_enqueue_script( 'stc_admin_js', plugins_url( 'assets/js/scripts-new.js', __FILE__ ), array( 'jquery' ) );
            wp_localize_script( 'stc_admin_js', 'stc_ajax', array( 'stc_ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

			wp_enqueue_script( 'stc_color_picker', plugins_url( '/assets/js/color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );



			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'select2' );
			
			wp_enqueue_style( 'select2', STC_URI . 'assets/css/select2.min.css' );
			wp_enqueue_style( 'font-awesome-5', STC_URI . 'assets/css/fontawesome.min.css' );


			wp_enqueue_style(   'post-skin', STC_URI . 'assets/css/post-skin.css');
			wp_enqueue_style(   'post_grid_admin_style', STC_URI . 'assets/css/style-new.css');


		}


		public function stc_activated() {

			do_action( 'stc_activation' );
		}


		public function stc_deactivation() {

			do_action( 'stc_deactivation' );
		}

	}

endif;

new STC_SHOW_CONTENTS();