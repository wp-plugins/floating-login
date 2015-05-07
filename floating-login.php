<?php
/*
	Plugin Name: Floating login
	Plugin URI: http://www.inspired-plugins.com/
	Description: Displays a login/register floating element
	Version: 1.2.2
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
include "admin-page.php";
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
            <?php if (get_option('fl_float_position') == "tr" || get_option('fl_float_position') == "tl" || get_option('fl_float_position') == ""){?>
            border-bottom-right-radius:5px;
			border-bottom-left-radius:5px;
            border-top:none;
				<?php if ( is_admin_bar_showing() ) {?>
					top:32px;
				<?php } 
				else{ ?>
					top:0px;
				<?php }
			}
			else if (get_option('fl_float_position') == "br" || get_option('fl_float_position') == "bl"){?>
                bottom:0px;
                top:inherit;
                border-top-left-radius:5px;
                border-top-right-radius:5px;
                border-bottom:none;
			<?php } 
            if (get_option('fl_float_position') == "bl" || get_option('fl_float_position') == "tl"){?>
				left:100px;
			<?php }
			else if (get_option('fl_float_position') == "br" || get_option('fl_float_position') == "tr" || get_option('fl_float_position') == ""){ ?>
				right:100px;
			<?php }?>
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
					class="fl_login_a"><?php if(get_option('fl_profile_text') == "username"){global $current_user; get_currentuserinfo(); echo $current_user->user_login; ?> <style>.login-float-container{width:200px;} </style><?php } else {?>Profile<?php } ?> </a>
					
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
			border-width:<?php echo get_option('fl_border_width'); ?>;
            <?php if (get_option('fl_float_position') == "tr" || get_option('fl_float_position') == "tl" ||get_option('fl_float_position') == ""){?>
            border-bottom-right-radius:5px;
			border-bottom-left-radius:5px;
            border-top:none;
			top:0px;
			<?php }
			else if (get_option('fl_float_position') == "br" || get_option('fl_float_position') == "bl"){?>
                bottom:0px;
                top:inherit;
                border-top-left-radius:5px;
                border-top-right-radius:5px;
                border-bottom:none;
			<?php } 
            if (get_option('fl_float_position') == "bl" || get_option('fl_float_position') == "tl"){?>
				left:100px;
			<?php }
			else if (get_option('fl_float_position') == "br" || get_option('fl_float_position') == "tr" || get_option('fl_float_position') == ""){ ?>
				right:100px;
			<?php }?>">
			
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
