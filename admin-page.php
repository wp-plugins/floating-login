<?php
//Admin options page

// create custom plugin settings menu
add_action('admin_menu', 'fl_create_menu');
add_action( 'admin_init', 'register_mysettings' );
function fl_create_menu() {
	//create new top-level menu
	add_options_page('Floating Login Settings', 'Floating Login Settings', 'activate_plugins', __FILE__, 'fl_settings_page');
}
function register_mysettings() {
	//register our settings
	register_setting( 'fl-settings-group', 'fl_login_url' );
	register_setting( 'fl-settings-group', 'fl_login_landing_url' );
	register_setting( 'fl-settings-group', 'fl_register_url' );
	register_setting( 'fl-settings-group', 'fl_profile_url' );
	register_setting( 'fl-settings-group', 'fl_logout_url');
	register_setting( 'fl-settings-group', 'fl_logout_landing_url');
	register_setting( 'fl-settings-group', 'fl_bg_color' );
	register_setting( 'fl-settings-group', 'fl_border_color' );
	register_setting( 'fl-settings-group', 'fl_text_color' );
	register_setting( 'fl-settings-group', 'fl_border_width' );
	register_setting( 'fl-settings-group', 'fl_register_display');
	register_setting( 'fl-settings-group', 'fl_profile_display');
	register_setting( 'fl-settings-group', 'fl_hover_color');
	register_setting( 'fl-settings-group', 'fl_float_position');
	register_setting( 'fl-settings-group', 'fl_profile_text');
}
function fl_settings_page() {
	wp_enqueue_script( 'fl_admin_script', plugins_url('jquery.js', __FILE__), array( 'wp-color-picker' ) );
	wp_enqueue_style( 'wp-color-picker' );
?>
<div class="wrap">
<h2>Floating Login Settings</h2>

<form name="fl_options" method="post" action="options.php">
	<?php $register_display= get_option('fl_register_display'); 
	$profile_display= get_option('fl_profile_display'); 
    settings_fields( 'fl-settings-group' ); 
    do_settings_sections( 'fl-settings-group' ); ?>
    <table class="form-table">
   		<tr valign="top"><th><h3>Config</h3></th></tr>
        <tr valign="top">
        	<th scope="row">Login URL</th>
        	<td><input type="text" name="fl_login_url" value="<?php echo get_option('fl_login_url');?>" style="width:400px;"/></td>
        	<td>Replace the default login URL (this must be an absolute link i.e. http://)
        </tr>
        <tr valign="top">
            <th scope="row">Login Landing Page</th>
            <td>
            <select name="fl_login_landing_url">
            <option name="fl_login_landing_url_home" <?php if(get_option('fl_login_landing_url')=="home" || get_option('fl_login_landing_url')==""){?>selected<?php }?>value="home">Home Page</option>
            <option name="fl_login_landing_url_profile" <?php if(get_option('fl_login_landing_url')=="profile"){?>selected<?php }?> value="profile">Profile Page</option>
            <option name="fl_login_landing_url_current" <?php if(get_option('fl_login_landing_url')=="current"){?>selected<?php }?> value="current">Current Page</option>
            </select>
            </td>
            <td>Change the login Landing Page (Where you go after you login with the element)(this must be an absolute link i.e. http://)<br />
            This will only take affect if Login URL is empty.
        </tr>
        <tr valign="top">
            <th scope="row">Logout URL</th>
            <td><input type="text" name="fl_logout_url" value="<?php echo get_option('fl_logout_url');?>" style="width:400px;"/></td>
            <td>Replace the default logout URL (this must be an absolute link i.e. http://)
        </tr>
        <tr valign="top">
            <th scope="row">Logout Landing Page URL</th>
            <td>
            <select name="fl_logout_landing_url">
            <option name="fl_logout_landing_url_home" <?php if(get_option('fl_logout_landing_url')=="home" || get_option('fl_logout_landing_url')==""){?>selected<?php }?>value="home">Home Page</option>
            <option name="fl_logout_landing_url_profile" <?php if(get_option('fl_logout_landing_url')=="profile"){?>selected<?php }?> value="profile">Login Page</option>
            <option name="fl_logout_landing_url_current" <?php if(get_option('fl_logout_landing_url')=="current"){?>selected<?php }?> value="current">Current Page</option>
            </select>
            </td>
            <td>Change the logout Landing Page (Where you go after you logout with the element)(this must be an absolute link i.e. http://)<br />
            This will only take affect if Logout URL is empty.
        </tr>
            <tr valign="top">
            <th scope="row">Disable register button</th>
            <td><input type="checkbox" name="fl_register_display" value = "display_register" <?php if ($register_display == true){ ?> checked=true <?php } ?> /></td>
            <td>Select to stop showing the register button in the element</td>
        </tr>
              
        <tr valign="top" class="fl_user_reg_url_row">
            <th scope="row">User Registration URL</th>
            <td><input type="text" name="fl_register_url" value="<?php echo get_option('fl_register_url'); ?>" style="width:400px;"/></td>
            <td>Replace the Registration URL (this must be an absolute link i.e. http://)</td>
        </tr>  
        
        <tr valign="top">
            <th scope="row">Disable Profile button</th>
            <td><input type="checkbox" name="fl_profile_display" value = "display_profile" <?php if ($profile_display == true){ ?> checked=true <?php } ?> /></td>
            <td>Select to stop showing the profile button in the element</td>
        </tr>
              
        <tr valign="top" class="fl_user_pro_url_row">
            <th scope="row">User Profile URL</th>
            <td><input type="text" name="fl_profile_url" value="<?php echo get_option('fl_profile_url'); ?>" style="width:400px;"/></td>
            <td>Replace the Profile URL (this must be an absolute link i.e. http://)</td>
        </tr>
        <tr valign = "top">
        	<th scope="row">Profile Link Text</th>
            <td>
        	<select name="fl_profile_text">
            	<option name="fl_profile_text_profile" <?php if(get_option('fl_profile_text')=="profile" || get_option('fl_profile_text')==""){?>selected<?php }?>value="profile">Profile</option>
            	<option name="fl_profile_text_username" <?php if(get_option('fl_profile_text')=="username"){?>selected<?php }?> value="username">Username</option> 
            </select>
            </td>
        </tr>
        <tr valign="top"><th><h3>Styling</h3></th></tr>
        <tr valign = "top">
        	<th>Element Position</th>
            <td>
        	<select name="fl_float_position">
            	<option name="fl_float_position_tr" <?php if(get_option('fl_float_position')=="tr" || get_option('fl_float_position')==""){?>selected<?php }?>value="tr">Top-right</option>
            	<option name="fl_float_position_tl" <?php if(get_option('fl_float_position')=="tl"){?>selected<?php }?> value="tl">Top-left</option> 
                <option name="fl_float_position_br" <?php if(get_option('fl_float_position')=="br"){?>selected<?php }?> value="br">Bottom-right</option> 
                <option name="fl_float_position_bl" <?php if(get_option('fl_float_position')=="bl"){?>selected<?php }?> value="bl">Bottom-left</option> 
            </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Background Colour</th>
            <td><input type="text" class="color-field" name="fl_bg_color" value="<?php echo get_option('fl_bg_color'); ?>" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row">Border Colour</th>
            <td><input type="text" class="color-field" name="fl_border_color" value="<?php echo get_option('fl_border_color'); ?>" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row">Text Colour</th>
            <td><input type="text" class="color-field" name="fl_text_color" value="<?php echo get_option('fl_text_color'); ?>" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row">Hover Colour</th>
            <td><input type="text" class="color-field" name="fl_hover_color" value="<?php echo get_option('fl_hover_color'); ?>" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row">Border Width</th>
            <td><input type="text" name="fl_border_width" value="<?php echo get_option('fl_border_width'); ?>" /></td>
        </tr>
    </table>
    <br />
    <b> If you like this plugin (or even if you don't) please leave a review <a href="https://wordpress.org/support/view/plugin-reviews/floating-login">here</a>.</b>
    <?php submit_button(); ?>
</form>
</div>
<?php } 
?>