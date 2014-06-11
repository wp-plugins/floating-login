<?php
/*
	Plugin Name: Floating login
	Plugin URI: http://www.inspired-plugins.com/
	Description: Displays a login/register floating element
	Version: 1.0.8
	Author: Inspired Information Services
	Author URI: www.inspired-is.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

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
	register_setting( 'fl-settings-group', 'fl_register_url' );
	register_setting( 'fl-settings-group', 'fl_bg_color' );
	register_setting( 'fl-settings-group', 'fl_border_color' );
	register_setting( 'fl-settings-group', 'fl_text_color' );
	register_setting( 'fl-settings-group', 'fl_border_width' );
	register_setting( 'fl-settings-group', 'fl_register_display');
	register_setting( 'fl-settings-group', 'fl_login_external');
	register_setting( 'fl-settings-group', 'fl_register_external');

}

function fl_settings_page() {
?>
<div class="wrap">
<h2>Floating Login Settings</h2>

<form method="post" action="options.php">
	<?php $register_display= get_option('fl_register_display'); 
	$login_external= get_option('fl_login_external'); 
	$register_external= get_option('fl_register_external');
    settings_fields( 'fl-settings-group' ); 
    do_settings_sections( 'fl-settings-group' ); ?>
    <table class="form-table">
    <tr valign="top">
   
        <th scope="row">External Login URL</th>
        <td><input type="checkbox" name="fl_login_external" value = "login_external" <?php if ($login_external == true){ ?> checked=true <?php } ?> /></td>
        <td>Tick this if the login page you are linking to is not part of this site, be sure to include http:// in your url</td>
        </tr> 
   
        <tr valign="top">
        <th scope="row">Login URL Suffix</th>
        <td><input type="text" name="fl_login_url" value="<?php echo get_option('fl_login_url');?>" /></td>
        <td>The URL for your login page, will automatically append to your site URL</td>
        </tr>
        
        <tr valign="top">
        <th scope="row">External Registration URL</th>
        <td><input type="checkbox" name="fl_register_external" value = "register_external" <?php if ($register_external == true){ ?> checked=true <?php } ?> /></td>
        <td>Tick this if the registration page you are linking to is not part of this site, be sure to include http:// in your url</td>
        </tr> 
        
        <tr valign="top">
        <th scope="row">Disable register button</th>
        <td><input type="checkbox" name="fl_register_display" value = "display_register" <?php if ($register_display == true){ ?> checked=true <?php } ?> /></td>
        <td>Select to stop showing the register button in the element</td>
        </tr>
              
        <tr valign="top">
        <th scope="row">User Registration URL Suffix</th>
        <td><input type="text" name="fl_register_url" value="<?php echo get_option('fl_register_url'); ?>" /></td>
        <td>The URL for your registration page, will automatically append to your site URL</td>
        </tr>       
        
        <tr valign="top">
        <th scope="row">Background Colour</th>
        <td><input type="text" name="fl_bg_color" value="<?php echo get_option('fl_bg_color'); ?>" /></td>
        <td>To return any of these fields to default, Just erase the data in them and save.</td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Border Colour</th>
        <td><input type="text" name="fl_border_color" value="<?php echo get_option('fl_border_color'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Text Colour</th>
        <td><input type="text" name="fl_text_color" value="<?php echo get_option('fl_text_color'); ?>" /></td>
        </tr>
        
        <tr valign="top">
        <th scope="row">Border Width</th>
        <td><input type="text" name="fl_border_width" value="<?php echo get_option('fl_border_width'); ?>" /></td>
        </tr>
        
    </table>
    
    <?php submit_button(); ?>
    <a href=mailto:enquiries@inspired-plugins.com><div class="button button-primary">Email Us</div></div></a>

</form>
</div>
<?php } 
//login/register/logout floating box 
add_action( 'wp_enqueue_scripts', 'safely_add_stylesheet' );

/**
* Add stylesheet to the page
*/
function safely_add_stylesheet() {
	wp_enqueue_style( 'floating-login', plugins_url('style.css', __FILE__) );
}


add_action('wp_head', 'floating_login', 20 );
function floating_login() { 
	/** Logout element **/
    if ( is_user_logged_in() ) { ?>
    	<div class="login-float-container"
        style="background-color:<?php echo get_option('fl_bg_color'); ?>; 
        border-color:<?php echo get_option('fl_border_color'); ?>;
        border-width:<?php echo get_option('fl_border_width'); ?>;
        top:<?php if ( is_admin_bar_showing() ) {
    		?>32px<?php
			} else{ ?>
            0px 
            <?php } ?>
            ">
			<div class="login-float-login" >
            <a style="color:<?php echo get_option('fl_text_color');?>"
				href="<?php echo wp_logout_url( home_url() ); ?>" 
                title="Logout">Logout</a>
			</div>
		</div>
    
<?php
    }
/** login / register element **/
	else{
		$login_url = get_option('fl_login_url');
		$register_url = get_option('fl_register_url');
		$register_display = get_option('fl_register_display');
		$login_external= get_option('fl_login_external'); 
		$register_external= get_option('fl_register_external');
		?>
    	 <div class="login-float-container"
         style="background-color:<?php echo get_option('fl_bg_color'); ?>;
         border-color:<?php echo get_option('fl_border_color'); ?>;
         border-width:<?php echo get_option('fl_border_width'); ?>;">
			<div class="login-float-login" > 
   				<a style="color:<?php echo get_option('fl_text_color');?>"
				href=" <?php if (empty($login_url)) {echo site_url(). '/wp-admin';}
				else{
					if ($login_external == "login_external"){
						echo get_option('fl_login_url'); 
					}
					else {
               		echo site_url(). "/" . get_option('fl_login_url');}}?>"> Log-in</a>
			</div>
            
            <?php if ($register_display !== "display_register"){ ?>
        	<p style="color:<?php echo get_option('fl_text_color'); ?>;";
             class="login-float-login">/</p>
       		<div class="login-float-register" >
   				<a style="color:<?php echo get_option('fl_text_color'); ?>;";
                href=" <?php if (empty($register_url)) {echo site_url(). '/wp-login.php?action=register&redirect_to=';}
			
				else if
					 ($register_external === "register_external"){
						echo get_option('fl_register_url'); 
					}
					
					else{
					echo site_url(). "/" .get_option('fl_register_url'); 
					}
					
					?>"> Register </a>
                   <?php } ?> 
			</div>
            <?php   ?>
		</div>
    <?php
			}

	}