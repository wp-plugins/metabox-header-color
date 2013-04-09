jQuery(document).ready(function($){

	cpargs = {
		change: function( event, ui ) {
			jQuery(this).val( ui.color.toString() );
			id = $(this).attr('id');
			if ( id == 'hex_code_bg' ) {
				$('h3.hndle').css({ backgroundColor: $(this).val()  });
			}
			if ( id == 'hex_code_tx' ) {
				$('h3.hndle').css({ color: $(this).val() });
			}
			if ( id == 'hex_code_sh' ) {
				$('h3.hndle').css({ textShadow: '0 1px 0 ' + $(this).val() });
			}
		}
	};

	jQuery('.colorpick').wpColorPicker( cpargs );

});