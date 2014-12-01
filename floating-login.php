<?php
/*
	Plugin Name: Floating login
	Plugin URI: http://www.inspired-plugins.com/
	Description: Displays a login/register floating element
	Version: 1.1.1
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
    <tr valign="top">
   
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
	global $post;
	if(get_post_meta($post ->ID, 'fl_login_display',true)!="on"){
		?><style>
			.fl_login_a:hover,
			.fl_login_a:hover{
				color: <?php echo get_option('fl_hover_color'); ?>!important;	
			}
		</style><?php
		/** Logout /profile element**/
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
				<?php if(get_option('fl_profile_display') != "display_profile"){ //if the register link is enabled?>
				<div class="login-float-login" >
				<a style="color:<?php echo get_option('fl_text_color');?>"
					href="<?php if(get_option('fl_profile_url') != ""){ //if user has entered a link
						echo (get_option('fl_profile_url'));
					} else{//otherwise use default link
						echo( get_edit_user_link());
					};?>" 
					title="Profile"
					class="fl_login_a">Profile</a>
				</div>
				<p style="color:<?php echo get_option('fl_text_color'); ?>;";
				class="login-float-login">/</p> <!-- Seperator -->
				<?php } ?>
				<div class="login-float-login" >
				<a style="color:<?php echo get_option('fl_text_color'); //Logout link?>"
					href="<?php
					if(get_option('fl_logout_url') != ""){echo (get_option('fl_logout_url'));} else {
						if(get_option('fl_logout_landing_url') == "" || get_option('fl_logout_landing_url') == "home"){
							echo (wp_logout_url(home_url()));
						} 
						else if(get_option('fl_logout_landing_url') == "current"){
							echo(wp_logout_url(get_permalink()));
						}
						else {
							echo(wp_logout_url());
						}
					}?>" 
					title="Logout"
					class="fl_login_a">Logout</a>
				</div>
			</div>
		
		<?php
		}
		/** login / register element **/
		else{
			$login_url = get_option('fl_login_url');
			$register_url = get_option('fl_register_url');
			$register_display = get_option('fl_register_display');
			$login_landing = get_option('fl_login_landing_url');
			?>
			<div class="login-float-container"
			style="background-color:<?php echo get_option('fl_bg_color'); ?>;
			border-color:<?php echo get_option('fl_border_color'); ?>;
			border-width:<?php echo get_option('fl_border_width'); ?>;">
			
				<div class="login-float-login" > 
					<a style="color:<?php echo get_option('fl_text_color');?>"
					class="fl_login_a" href=" <?php 
					if (empty($login_url)) {//if empty use default login link
						if ($login_landing == "" || $login_landing == "home"){
							echo  wp_login_url(home_url());
						}
						else if(get_option("fl_login_landing_url")=="current"){
							echo wp_login_url(get_permalink());
						}
						else{
							echo wp_login_url();
						}
					}
					else{//otherwise use given link
						echo get_option('fl_login_url');
					}?>"> Log-in</a>
				</div>
				
				<?php if ($register_display !== "display_register"){ //if register link is enabled?>
				<p style="color:<?php echo get_option('fl_text_color'); ?>;";
				 class="login-float-login">/</p>
				<div class="login-float-register" >
					<a class="fl_login_a" style="color:<?php echo get_option('fl_text_color'); ?>;";
					href=" <?php if (empty($register_url)) {echo wp_registration_url();} // if  reg link is empty then just use default wordpress link
				
					else {
							echo get_option('fl_register_url'); //otherwise use given link
						}					
						?>"> Register </a>
					   <?php } ?> 
				</div>
			</div>
			<?php
		}
	}
}
add_action('add_meta_boxes', 'fl_meta_box');
function fl_meta_box(){
add_meta_box('fl_meta', 'Floating Login Options', 'fl_meta', "" , 'side');
}
function fl_meta(){
	global $post;
	?>Disable Floating Login on this page <input type="checkbox"  name="fl_disable" <?php if (get_post_meta($post ->ID,'fl_login_display',true)=="on"){ ?> checked <?php } ?>/><?php
}
add_action('save_post','save_fl_meta');
function save_fl_meta(){
	global $post;
	update_post_meta($post ->ID, 'fl_login_display', $_POST['fl_disable']);
}
