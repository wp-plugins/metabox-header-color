<?php
/*
Plugin Name: Metabox Header Color
Plugin URI: http://trepmal.com/
Description: Change the color for metabox headers
Author: Kailey Lampert
Version: 1.0
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
    }

	function activate() { add_option('kl-metabox-header-color','#99dd44'); }

	function menu() {
		add_submenu_page('options-general.php', 'Metabox Header Color', 'Metabox Header Color', 'administrator', __FILE__, array(&$this, 'page'));
	}

	function page() {
		echo '<div class="wrap">';
		
		echo '<h2>'.__('Choose Metabox Header Color').'</h2>';
		if (isset($_POST['submitted'])) {
			if (update_option('kl-metabox-header-color',$_POST['hex_code']))
				echo '<p>'.__('Saved').'</p>';
			else
				echo '<p>'.__('Could not save, please try again').'</p>';
		}

		echo '<form method="post" enctype="multipart/form-data" id="logoupload">';

		echo '<p><label for="hex_code">Color (hex)code: </label><input type="text" name="hex_code" id="hex_code" value="'.get_option('kl-metabox-header-color').'" /></p>';
			  
		echo '<p><input type="hidden" name="submitted" /><input type="submit" id="save" value="'.__('Save').'"/></p>';

		$color = get_option('kl-metabox-header-color');
		echo '<p>'.__('Currently using').': <span style="padding: 5px 10px;background:'.$color.';color:#000;">'.$color.'</span></p>';

		echo '</form>';
		
		echo '</div>';
	}// end function

	
}//end class
function metaboxheadercolor() {
	echo '<style type="text/css">';
	echo '.widget .widget-top, .postbox h3, .stuffbox h3 { background:'.get_option('kl-metabox-header-color').' !important; } ';
	echo '</style>';
}
add_action('admin_head', 'metaboxheadercolor');


?>