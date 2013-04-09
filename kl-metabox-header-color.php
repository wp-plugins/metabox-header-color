<?php
/*
 * Plugin Name: Metabox Header Color
 * Plugin URI: http://trepmal.com/plugins/metabox-header-color/
 * Description: Change the color for metabox headers
 * Version: 1.6
 * Author: Kailey Lampert
 * Author URI: kaileylampert.com
 * License: GPLv2 or later
 * TextDomain: metabox-header-color
 * DomainPath:
 * Network:
 */

$kl_metaboxheadercolor = new KL_metaboxheadercolor();

class KL_metaboxheadercolor {

	function KL_metaboxheadercolor() {
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );
		add_action( 'admin_head', array( &$this, 'metaboxheadercolor' ) );
		add_action( 'admin_menu', array( &$this, 'menu' ) );
	}

	function activate() {
		add_option( 'kl-metabox-header-color', array( 'bg' => '#9df', 'tx' => '#666', 'sh' => '#fff' ) );
	}

	function metaboxheadercolor() {
		if ( isset( $_POST[ 'hex_code' ] ) && is_array( $_POST[ 'hex_code' ] ) ) {
			// check_admin_referer( 'kl-metabox-header-color_save' );
			if ( ! wp_verify_nonce( $_POST['na_klmhc-save'], 'nn_klmhc-save' ) ) {
				echo '<div class="error"><p>'. __('Nonce verification failed.', 'metabox-header-color' ) .'</p></div>';
			} else {
				update_option( 'kl-metabox-header-color', $_POST[ 'hex_code' ] );
			}
		}

		extract( get_option( 'kl-metabox-header-color' ) );
		?><style type="text/css">
		.widgets-sortables .widget-top,
		.postbox h3,
		.stuffbox h3,
		.ui-sortable .postbox h3 {
			background: <?php echo $bg; ?>;
			color: <?php echo $tx; ?>;
			text-shadow: 0 1px 0 <?php echo $sh; ?>;
		}
		#widget-list .widget-top {
			color: auto;
		}
		</style><?php
	}

	function menu() {
		add_options_page( __( 'Metabox Header Color', 'metabox-header-color' ), __( 'Metabox Header Color', 'metabox-header-color' ), 'administrator', __FILE__, array( &$this, 'page' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'scripts' ) );
	}

	function scripts( $hook ) {
		if ( $hook != 'settings_page_metabox-header-color/kl-metabox-header-color' ) return;
		wp_enqueue_script('wp-color-picker');
		wp_enqueue_style('wp-color-picker');

		wp_enqueue_script( 'klmetaboxheadercolorinit', plugins_url( 'js/init.js', __FILE__ ), array('wp-color-picker') );

	}

	function page() {

		$color = get_option( 'kl-metabox-header-color' );
		?>
		<div class="wrap">
			<h2><?php _e( 'Choose Metabox Header Color', 'metabox-header-color' ); ?></h2>
			<div class="metabox-holder">
				<div class="postbox ">
					<h3 class="hndle"><span><?php _e( 'Preview changes here', 'metabox-header-color' ); ?></span></h3>
					<div class="inside">
						<form method="post" style="padding:10px;">
							<?php
								extract( get_option( 'kl-metabox-header-color' ) );
								wp_nonce_field( 'nn_klmhc-save', 'na_klmhc-save' );
							?>
							<p style="width: 30%; float: left; margin: 0;"><label for="hex_code_bg"><?php _e( 'Background Color:', 'metabox-header-color' ); ?> </label><br />
							<input type="text" name="hex_code[bg]" id="hex_code_bg" value="<?php echo $bg; ?>" class="colorpick" /></p>

							<p style="width: 30%; float: left; margin: 0 2%;"><label for="hex_code_tx"><?php _e( 'Text Color:', 'metabox-header-color' ); ?> </label><br />
							<input type="text" name="hex_code[tx]" id="hex_code_tx" value="<?php echo $tx; ?>" class="colorpick"  /></p>

							<p style="width: 30%; float: left; margin: 0;"><label for="hex_code_sh"><?php _e( 'Shadow Color:', 'metabox-header-color' ); ?> </label><br />
							<input type="text" name="hex_code[sh]" id="hex_code_sh" value="<?php echo $sh; ?>" class="colorpick"  /></p>

							<p style="width: 6%; float: left; margin: 2% 0;"><?php submit_button( __( 'Save', 'metabox-header-color' ), 'primary', 'submit', false ); ?></p>

							<p class="clear"><?php _e( 'Settings will be preserved if the plugin is deactivated. Settings will be removed if plugin is deleted.', 'metabox-header-color' ); ?></p>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php

	} // end function page

} // end class KL_metaboxheadercolor
//eof