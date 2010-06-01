<?php
/*
Plugin Name: Metabox Header Color
Plugin URI: http://trepmal.com/plugins/metabox-header-color/
Description: Change the color for metabox headers
Author: Kailey Lampert
Version: 1.4
Author URI: http://kaileylampert.com/
*/
/*
    Copyright (C) 2010  Kailey Lampert

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$KL_metaboxheadercolor = new KL_metaboxheadercolor();

class KL_metaboxheadercolor {

	function KL_metaboxheadercolor() {
		add_action('admin_menu', array(&$this, 'menu'));
		register_activation_hook(__FILE__,  array(&$this, 'activate'));
		register_uninstall_hook(__FILE__,  array(&$this, 'uninstall'));
	}

	function activate() { add_option('kl-metabox-header-color',array('bg'=>'#9df','tx'=>'#666','sh'=>'#fff')); }
	function uninstall() { delete_option('kl-metabox-header-color'); }

	function menu() {
		$page = add_submenu_page('options-general.php', 'Metabox Header Color', 'Metabox Header Color', 'administrator', __FILE__, array(&$this, 'page'));
		add_action('admin_print_scripts-'.$page, array(&$this, 'scripts'));
		add_action('admin_print_styles-'.$page, array(&$this, 'styles'));
	}
	
	function scripts() {
		$plugin_path = '/'.PLUGINDIR.'/'.plugin_basename(dirname(__FILE__));
		wp_enqueue_script('jquery');
		wp_register_script('jquerycolorpicker',$plugin_path.'/js/colorpicker.js','jquery');
		wp_enqueue_script('jquerycolorpicker');
		wp_register_script('klmetaboxheadercolorinit',$plugin_path.'/js/init.js','jquerycolorpicker');
		wp_enqueue_script('klmetaboxheadercolorinit');
	}
	function styles() {
		$plugin_path = '/'.PLUGINDIR.'/'.plugin_basename(dirname(__FILE__));
		wp_register_style('jquerycolorpicker',$plugin_path.'/css/colorpicker.css','jquery');
		wp_enqueue_style('jquerycolorpicker');
	}
	function page() {
		if (isset($_POST['submitted'])) {
			
			if (is_array($_POST['hex_code'])) {
				check_admin_referer('kl-metabox-header-color_save');
				update_option('kl-metabox-header-color',$_POST['hex_code']);
			}
				
			/* this little block just allows the colors to be viewable after saving 
				since the actual options aren't updated till after the stylesheet loads */
			extract(get_option('kl-metabox-header-color'));
			echo '<style type="text/css">';
			echo '.widget .widget-top, .postbox h3, .stuffbox h3 { background:'.$bg.' ; color:'.$tx.'; text-shadow: 0 1px 0 '.$sh.'; } ';
			echo '</style>';
		
		}
		echo '<div class="wrap">';
		
		echo '<h2>'.__('Choose Metabox Header Color').'</h2>';


		$color = get_option('kl-metabox-header-color');
echo '<div class="metabox-holder">
	<div class="postbox ">
	<h3 class="hndle"><span>'.__('Preview changes here').'</span></h3>
	<div class="inside">';

		extract(get_option('kl-metabox-header-color'));
		echo '<form method="post" style="padding:10px;">';
		wp_nonce_field('kl-metabox-header-color_save');
		
		echo '<p><label for="hex_code_bg">Background Color (hex) code: </label><input type="text" name="hex_code[bg]" id="hex_code_bg" value="'.$bg.'" class="cpick" /></p>';
		echo '<p><label for="hex_code_tx">Text Color (hex) code: </label><input type="text" name="hex_code[tx]" id="hex_code_tx" value="'.$tx.'" class="cpick"  /></p>';
		echo '<p><label for="hex_code_sh">Shadow Color (hex) code: </label><input type="text" name="hex_code[sh]" id="hex_code_sh" value="'.$sh.'" class="cpick"  /></p>';
		echo '<p><input type="hidden" name="submitted" /><input type="submit" id="save" value="'.__('Save').'"/></p>';
		echo '</form>';

echo '</div></div></div>';
		echo '<p>Settings will be preserved if the plugin is deactivated. Settings will be removed if plugin is deleted.</p>';
		echo '<p>The colorpicker is by <a href="http://www.eyecon.ro/colorpicker/">eyecon</a></p>';
		echo '</div>';
	}// end function

	
}//end class
function metaboxheadercolor() {
	extract(get_option('kl-metabox-header-color'));
	echo '<style type="text/css">';
	echo '.widget .widget-top, .postbox h3, .stuffbox h3, .ui-sortable .postbox h3 { background:'.$bg.' ; color:'.$tx.' ; text-shadow: 0 1px 0 '.$sh.' ; } ';
	echo '</style>';
}
add_action('admin_head', 'metaboxheadercolor');


?>