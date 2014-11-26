(function( $ ) {
 
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.color-field').wpColorPicker();
    });
    $(function(){
		$(document.forms["fl_options"]["fl_register_display"]).click(function(){
			if(document.forms["fl_options"]["fl_register_display"].checked == true){
				$(".fl_user_reg_url_row").css("display","none");
			}
			else{
				$(".fl_user_reg_url_row").css("display","table-row");
			}
		});
	});
	$(document).ready(function(){
		if(document.forms["fl_options"]["fl_register_display"].checked == true){
			$(".fl_user_reg_url_row").css("display","none");
		}
	});
	$(function(){
		$(document.forms["fl_options"]["fl_profile_display"]).click(function(){
			if(document.forms["fl_options"]["fl_profile_display"].checked == true){
				$(".fl_user_pro_url_row").css("display","none");
			}
			else{
				$(".fl_user_pro_url_row").css("display","table-row");
			}
		});
	});
	$(document).ready(function(){
		if(document.forms["fl_options"]["fl_profile_display"].checked == true){
			$(".fl_user_pro_url_row").css("display","none");
		}
	});
})( jQuery );