<?php
/*
 * Plugin Name: 	WP Posts Most Read
 * Plugin URI:		http://wordpress.org/extend/plugins/wp-posts-most-read/
 * Description: 	Count number of posts views and display a list in a widget
 * Tags: 			Widget, Settings, Images
 * Version: 		1.2
 * Author: 			iziwebavenir
 * Author URI: 		http://www.iziwebavenir.com
 * Date:			28 Feb. 2013
 * License: 		GPL2
 * 
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 * 
 * @package WP Posts Most Read
 * @Version 1.2
 * @author iziwebavenir <iziwebavenir@gmail.com>
 * @copyright Copyright (c) 2013, iziwebavenir
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

global $wp_version;

$exit_msg = 'wp-assets require WordPress 2.6 or newer.  <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';

if (version_compare($wp_version, "2.6", "<")) {

	exit( $exit_msg );

}

if ( !class_exists('PMRposts') ) : 
 	 
	class PMRposts {
		 
		private $plugin_version = "1.2";
	
		private $table_name = "wp_posts_most_read";
	 
		private $plugin_domain = "wp-postsmostread";
		private $plugin_domain_for_ajax = "wp-postsmostread-ajax";
		private $plugin_opt_title = "wp-postsmostread-title";
		private $plugin_opt_title_value = "wp-postsmostread-title-value";
		private $plugin_opt_view = "wp-postsmostread-opt-view";
		private $plugin_opt_view_last_reset = "wp-postsmostread-opt-view-last-reset";
		private $plugin_opt_nb = "wp-postsmostread-opt-number";
		private $plugin_opt_ajax = "wp-postsmostread-opt-ajax";		
		private $plugin_page_view = "wp-postsmostread-view";
		private $plugin_opt_images= "wp-postsmostread-images";
		private $plugin_opt_images_width = "wp-postsmostread-images-width";
		private $plugin_opt_alignment = "wp-postsmostread-alignment";
		private $plugin_page_option = "wp-postsmostread-option";
		
		private $number_show_admin = 100; // number of posts per page
		private $title_show = 1;  
		private $view_show = 1;
		private $number_show = 5;
		private $ajax_method = 0;
		private $images_show = 0;
		private $images_width = 60;
		private $alignment = 0; // 0 = vertical and 1 = horizontal
		private $title_value = "Posts most read"; 
		
		private $plugin_display_method = 'PMR_displaypostsmostread';	
				
		private $plugin_author = "iziwebavenir";
		private $plugin_author_uri = "http://www.iziwebavenir.com";
		private $plugin_author_email = "";
		private $plugin_author_googleplus = "";
		private $plugin_author_website = "http://www.iziwebavenir.com";
		private $plugin_licence = "GPL2";
		private $plugin_licence_uri = "http://www.gnu.org/licenses/old-licenses/gpl-2.0.html";
		
		private $plugin_url;
		
		
		function PMRposts(){
		
			$this->plugin_url = trailingslashit( WP_PLUGIN_URL.'/'. dirname( plugin_basename( __FILE__ ) ) );
				
			add_action('plugins_loaded', array( &$this , 'PMRposts_language' ));

			add_action( 'admin_menu',  array(&$this, 'admin_menu'));
			  
 			add_action( 'wp_enqueue_scripts', array(&$this,'PMRposts_most_read_int_style')); 

 			add_action( 'admin_enqueue_scripts', array(&$this,'PMRposts_most_read_int_style_admin')); 
   
 			$cpt_method = get_option($this->plugin_opt_ajax)!=NULL ? get_option($this->plugin_opt_ajax) : 0;
 			 
 			if($cpt_method==1){ // Ajax method 
 			 	
 				add_action('wp_enqueue_scripts', array( &$this, 'PMRposts_add_ajax_script' ));
 				
 				add_action("wp_ajax_PMRposts_most_read_add_ajax", array(&$this,"PMRposts_most_read_add_ajax"));
 				 
			 	add_action("wp_ajax_nopriv_PMRposts_most_read_add_ajax", array(&$this,"PMRposts_most_read_add_ajax"));
			  
 			}else{

 				add_action( 'wp_head',  array(&$this,'PMRposts_most_read_add'));	
 				
 			}
	 			   
		}
		
		function PMRposts_language(){
		 
			// Load localization file
			load_plugin_textdomain($this->plugin_domain,false,'/'.dirname( plugin_basename( __FILE__ ) ) .'/lang/');
								
		}
		
		function admin_menu(){ //Administration
		
			add_options_page(__('Settings | WP Posts Most Read',$this->plugin_domain),__('Posts Most Read',$this->plugin_domain), 8 , $this->plugin_page_option , array(&$this, 'handle_options'));
		
			add_menu_page( __('Listing | WP Posts Most Read',$this->plugin_domain), __('Posts Most Read',$this->plugin_domain), 'publish_posts', $this->plugin_page_view , array(&$this, 'handle_listing'),  $this->plugin_url . "images/wp-postsmostread-16x16.jpg" );
		
		}
		
		function handle_listing() {
			
			$this->PMR_do_action();
					
			$this->handle_options_plugin();
				
			include( 'inc/PMRlisting.php');
				
		}
		
		function handle_options() {
			
			$this->PMR_do_action();
			
			$this->handle_options_plugin();
				
			include( 'inc/PMRoptions.php');
				
		}
		
		function PMR_do_action(){
			
			if(isset($_POST[$this->plugin_opt_title])){ // Show title?
			
				update_option($this->plugin_opt_title,$_POST[$this->plugin_opt_title]);
			
			}elseif (isset($_POST[$this->plugin_opt_title_value])){ // Title Value
						
					update_option($this->plugin_opt_title_value,$_POST[$this->plugin_opt_title_value]);
							
			}elseif(isset($_POST[$this->plugin_opt_view])){ // Show view?
			
				update_option($this->plugin_opt_view,$_POST[$this->plugin_opt_view]);
			
			}elseif(isset($_POST[$this->plugin_opt_nb])){ // Number of article
			
				if(is_numeric($_POST[$this->plugin_opt_nb]) && $_POST[$this->plugin_opt_nb]>0 && $_POST[$this->plugin_opt_nb]<21){ 
					
					update_option($this->plugin_opt_nb,intval($_POST[$this->plugin_opt_nb]));
					
				}
					
			}elseif(isset($_POST[$this->plugin_opt_images])){ // Show images
			
					update_option($this->plugin_opt_images,$_POST[$this->plugin_opt_images]);
					
			}elseif(isset($_POST[$this->plugin_opt_images_width])){ // Width images
			
					if(is_numeric($_POST[$this->plugin_opt_images_width]) && $_POST[$this->plugin_opt_images_width]>0 && $_POST[$this->plugin_opt_images_width]<151){
						
						update_option($this->plugin_opt_images_width,intval($_POST[$this->plugin_opt_images_width]));
						
					}

			}elseif(isset($_POST[$this->plugin_opt_alignment])){ // Alignment
					
					update_option($this->plugin_opt_alignment,$_POST[$this->plugin_opt_alignment]);
					
			}elseif(isset($_POST[$this->plugin_opt_ajax])){ // Ajax method?
			
				update_option($this->plugin_opt_ajax,$_POST[$this->plugin_opt_ajax]);
			
			}elseif(isset($_POST['reset-number-views'])){ // reset table
			
				$this->PMR_reset_views();
			
			}elseif (isset($_POST['reset-options'])){ // default option
			
				$this->PMR_reset_options();
			
			}
			
		}
		
		function handle_options_plugin() {
		
			$this->title_show = get_option($this->plugin_opt_title)!=NULL ? get_option($this->plugin_opt_title) : $this->title_show;
				
			$this->title_value = get_option($this->plugin_opt_title_value)!=NULL ? get_option($this->plugin_opt_title_value) : $this->title_value;
				
			$this->view_show = get_option($this->plugin_opt_view)!=NULL ? get_option($this->plugin_opt_view) : $this->view_show;
		
			$this->number_show= get_option($this->plugin_opt_nb)!=NULL ? get_option($this->plugin_opt_nb) : $this->number_show;
		
			$this->ajax_method = get_option($this->plugin_opt_ajax)!=NULL ? get_option($this->plugin_opt_ajax) : $this->ajax_method;
		
			$this->images_show = get_option($this->plugin_opt_images)!=NULL ? get_option($this->plugin_opt_images) : $this->images_show;
		
			$this->images_width = get_option($this->plugin_opt_images_width)!=NULL ? get_option($this->plugin_opt_images_width) : $this->images_width;
		
			$this->alignment = get_option($this->plugin_opt_alignment)!=NULL ? get_option($this->plugin_opt_alignment) : $this->alignment;
		
		}
		
		function PMRposts_most_read_int_style(){
		
			wp_enqueue_style($this->plugin_domain,$this->plugin_url.'css/style.css');
		
		}
		
		function PMRposts_most_read_int_style_admin(){
		
			wp_enqueue_style($this->plugin_domain,$this->plugin_url.'css/style_admin.css');
		
		}
		
		function PMRposts_add_ajax_script() {
			
		    if( !is_single() ) return false;
		 
		    wp_enqueue_script( $this->plugin_domain_for_ajax, $this->plugin_url.'js/ajax.js', array( 'jquery'), true);
		    
		    wp_localize_script( $this->plugin_domain_for_ajax, 'MyAjax', array(  'ajaxurl' => admin_url(  '/admin-ajax.php' ) , 
		    															'ID_post' => get_the_ID(),
		    															'action'=>'PMRposts_most_read_add_ajax' ) );
		    	 
		}
		
		function PMRposts_most_read_add_ajax(){
		  
			global $wpdb; 
			
			$ID = $_POST['ID_post'];    
		 
			$this->PMRposts_action($ID);
			   
			die();
				
		}
		
		function PMRposts_most_read_add(){
					
			if(is_single()){ 
 
				$ID = get_the_ID(); 
				
				$this->PMRposts_action($ID);
				  
			}
			
		}
		
		function PMRposts_action($ID){
		 	 
			global $wpdb;  
				
			if(get_post_status($ID)=='publish'){ 
				 
				$title = get_the_title($ID); 
			
				$url = get_permalink($ID);
				
				$table_name = $this->table_name;
				 
				$myrows = $wpdb->get_results( "SELECT view FROM $table_name WHERE id_post = $ID" );
				
				if($myrows[0]->view){
				
					$new_view = $myrows[0]->view + 1;
					
					$wpdb->update( $table_name, array( 'view'=>$new_view , 'title' => "$title" , 'url' => "$url" ) , array('id_post'=>$ID));
					
				}else{
				
					$wpdb->insert( $table_name, array( 'id_post' => $ID, 'view'=>1 , 'title' => "$title" , 'url' => "$url" ) );
					
				}
			
			}
				
		}
		
		function PMR_head_div($page){ ?>
		
			<img class="pmr-logo" src="<?php echo $this->plugin_url;?>/images/wp-postsmostread-100x100.jpg" alt="pmr logo">
				
			<?php if($page=="settings"){ ?>
			 
				<h1 class="amp"><?php _e("Settings | WP Posts Most Read",$this->plugin_domain);?> <span><?php echo $this->plugin_version;?></span></h1>
				
				<div class="descr">
				
					<b><?php _e("Description",$this->plugin_domain);?></b> : <?php _e("You can edit and choose your own settings",$this->plugin_domain);?> <a href="<?php bloginfo('url');?>/wp-admin/admin.php?page=<?php echo $this->plugin_page_view;?>"><?php _e("Go to listing and overview page",$this->plugin_domain);?></a>
					
				</div>
					
			<?php }elseif($page=="listing"){ ?>	
			 	
				<h1 class="amp"><?php _e("Listing | WP Posts Most Read",$this->plugin_domain);?> <span><?php echo $this->plugin_version;?></span></h1>
				
				<div class="descr">
				
					<b><?php _e("Description",$this->plugin_domain);?></b> : <?php _e("Listing of posts most read. You can use a widget (go to the widget page) or insert a code in your template. The code to insert and all settings are available on this page : ",$this->plugin_domain);?> <a href="<?php bloginfo('url');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>"><?php _e("Go to settings page",$this->plugin_domain);?></a>
					
				</div>
				 
			<?php } ?>
		 			 
		<?php }
				
		function PMR_author_div(){ ?>
			
 			<div class="wrap" id="amp-div-admin-author">
 
			<div class="descr-author">
			
				<div class="authorH2"><?php _e("Copyright",$this->plugin_domain);?></div>
					
				<div class="avatar">
				
					<img src="<?php echo $this->plugin_url;?>/images/profil.jpg" alt="profil">
					
				</div>
				
				<div class="authordescr">
									
					<span><?php _e("Author",$this->plugin_domain);?> : </span> <?php if($this->plugin_author_email==""){ echo $this->plugin_author; }else{ ?><a href="mailto:<?php echo $this->plugin_author_email;?>" title="email"></a><?php } ?><br />
				 
					<span><?php echo ucfirst(__("website",$this->plugin_domain));?> : </span> <?php if($this->plugin_author_website==""){ echo "Under construction";}else{ ?><a href="<?php echo $this->plugin_author_website;?>" title="website" target="_blank">See webiste</a><?php } ?><br />
					
					<span><?php _e("Licence",$this->plugin_domain);?> : </span> <a href="<?php echo $this->plugin_licence_uri;?>" title="<?php echo $this->plugin_licence;?>" target="_blank"><?php echo $this->plugin_licence;?></a> <br />
					
					<?php if($this->plugin_author_googleplus!=""){ ?> <a href="<?php echo $this->plugin_author_googleplus;?>" target="_blank" class="to-gplus" title="Google+ : <?php echo $this->plugin_author;?>"><img id="gplus" class="icon-social" src="<?php bloginfo('siteurl');?>/wp-content/plugins/<?php echo $this->plugin_domain;?>/images/icon-google-plus.png" alt="google plus"></a><?php } ?>
					
					Photo head: @iziwebavenir<br />
					
					Photo profil: @Joseph Szabo
					
				</div>
				
			</div>
			
			</div>
			
		<?php }
		
		function PMR_get_image_by_postID($postID){

			if ( has_post_thumbnail($postID) ) {

				$imgArrayThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($postID), 'thumbnail');
				
				$imgThumbUrl = $imgArrayThumbnail[0];
				
			} else {

				$img = get_post_images("post_id=$postID&number=1");
				
				if (false !== $img)
				{
					$imgArrayThumbnail = wp_get_attachment_image_src($img[0]->ID,'thumbnail');
			
					$imgThumbUrl = $imgArrayThumbnail[0];
	
				}else{
			
					$imgThumbUrl = "$this->plugin_url/images/default-post-thumb.jpg";
				
				}
				
			}
				
			return $imgThumbUrl;
			
		}
	
		function PMR_displaypostsmostread() {
		
			$this->handle_options_plugin();
			
			include 'inc/PMRdisplay.php';
			 
		}
		
		function PMR_reset_views(){

			global $wpdb;
			
			$table_name = $this->table_name;
				
			$sql_posts_reset = "DELETE FROM $table_name";
				
			$wpdb->query($wpdb->prepare( $sql_posts_reset) );
			
			update_option($this->plugin_opt_view_last_reset,time());
			
		}
		
		function PMR_reset_options(){
			
			delete_option($this->plugin_opt_title);
			
			delete_option($this->plugin_opt_view);
		
			delete_option($this->plugin_opt_nb);
				
			delete_option($this->plugin_opt_images);
			
			delete_option($this->plugin_opt_images_width);
				
			delete_option($this->plugin_opt_ajax);
				
			delete_option($this->plugin_page_view);
				
			delete_option($this->plugin_page_option);
			
			delete_option($this->plugin_opt_alignment);
			
			delete_option($this->plugin_opt_view_last_reset);
		
		}
		
		function activate() {
	 
			global $wpdb;
			
			$table_name = $this->table_name;
			
			$sql = "CREATE TABLE IF NOT EXISTS `wp_posts_most_read` (
`id_post` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`view` INT( 9 ) UNSIGNED NOT NULL DEFAULT '0',
`title` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`url` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MYISAM ;";
			
			$wpdb->query($wpdb->prepare($sql)) or die(mysql_error());
			
			update_option($this->plugin_opt_view_last_reset,time());
		
		}
		
		function deactivate() {
	 
			$this->PMR_reset_options();
			
		}
		
	}
	
	
else :

	exit ("Class PMRposts already declared!");
	
endif;

if(!isset($PMRposts)){

	$PMRposts = new PMRposts;
	
}

if (isset($PMRposts)){

	register_activation_hook( __FILE__, array(&$PMRposts, 'activate') );
	
	register_deactivation_hook( __FILE__, array(&$PMRposts,'deactivate' ) );

}

if ( !class_exists('PMRpostsWidget') ) :

	// Class based on this webpage http://www.wpexplorer.com/create-widget-plugin-wordpress/ wrote by Remi (http://remicorson.com/)

	class PMRpostsWidget extends WP_Widget {
	
		private $table_name = "wp_posts_most_read";
	 
		private $plugin_domain = "wp-postsmostread";
		private $plugin_domain_for_ajax = "wp-postsmostread-ajax";
		private $plugin_opt_title = "wp-postsmostread-title";
		private $plugin_opt_title_value = "wp-postsmostread-title-value";
		private $plugin_opt_view = "wp-postsmostread-opt-view";
		private $plugin_opt_nb = "wp-postsmostread-opt-number";
		private $plugin_opt_ajax = "wp-postsmostread-opt-ajax";		
		private $plugin_page_view = "wp-postsmostread-view";
		private $plugin_opt_images= "wp-postsmostread-images";
		private $plugin_opt_images_width = "wp-postsmostread-images-width";
		private $plugin_opt_alignment = "wp-postsmostread-alignment";
		private $plugin_page_option = "wp-postsmostread-option";
		
		private $number_show_admin = 100;
		private $title_show = 1;
		private $view_show = 1;
		private $number_show = 5;
		private $ajax_method = 0;
		private $images_show = 0;
		private $images_width = 60;
		private $alignment = 0; // 0 = vertical and 1 = horizontal
		private $title_value = "Posts most read"; 
		 
		private $widget_name = "Posts Most Read";
		private $widget_view = 1;
		
		function PMRpostsWidget() {
			
			$widget_ops = array('classname' => 'PMR_widget_class', 'description' => __('This widget display a list of posts most read.', $this->plugin_domain));
			
			parent::WP_Widget(false, $name = __($this->widget_name, 'wp_widget_plugin'), $widget_ops, $control_ops );
		
		}
		
		function form($instance) {?>
			
			<p>
			
				<?php _e('All settings for this widget are accessible on this page.', $this->plugin_domain); ?> : <br />
				
				<a href="<?php bloginfo('url');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>"><?php _e("Go to settings page",$this->plugin_domain);?></a>
						
			</p>
		
		<?php }
	
		function update($new_instance, $old_instance) {
			
			
		}
	
		function handle_options_plugin() {
		
			$this->title_show = get_option($this->plugin_opt_title)!=NULL ? get_option($this->plugin_opt_title) : $this->title_show;
				
			$this->title_value = get_option($this->plugin_opt_title_value)!=NULL ? get_option($this->plugin_opt_title_value) : $this->title_value;
				
			$this->view_show = get_option($this->plugin_opt_view)!=NULL ? get_option($this->plugin_opt_view) : $this->view_show;
		
			$this->number_show= get_option($this->plugin_opt_nb)!=NULL ? get_option($this->plugin_opt_nb) : $this->number_show;
		
			$this->ajax_method = get_option($this->plugin_opt_ajax)!=NULL ? get_option($this->plugin_opt_ajax) : $this->ajax_method;
		
			$this->images_show = get_option($this->plugin_opt_images)!=NULL ? get_option($this->plugin_opt_images) : $this->images_show;
		
			$this->images_width = get_option($this->plugin_opt_images_width)!=NULL ? get_option($this->plugin_opt_images_width) : $this->images_width;
		
			$this->alignment = get_option($this->plugin_opt_alignment)!=NULL ? get_option($this->plugin_opt_alignment) : $this->alignment;
		
		}
		
		function widget($args, $instance) {
		   
			$this->handle_options_plugin();
			
			extract( $args );
	
			include 'inc/PMRdisplay.php';
			
		}

	}

endif;

if(class_exists('PMRpostsWidget')){
	
	// register widget
	add_action('widgets_init', create_function('', 'return register_widget("PMRpostsWidget");'));

}
