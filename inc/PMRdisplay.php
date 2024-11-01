<?php wp_reset_query();

global $wpdb;

$sql_posts_most_read = $wpdb->prepare( "SELECT * FROM $this->table_name ORDER BY view DESC LIMIT $this->number_show" );

if($wpdb->get_row($sql_posts_most_read)>0){ 

	$query_posts_most_read = $wpdb->get_results($sql_posts_most_read);
	
	if($this->widget_view){ 
	
		echo $before_widget;?>

<!-- WP Posts Most Read -->
<div class="widget-text wp_widget_plugin_box">

	<?php }else{?>
	
<!-- WP Posts Most Read -->
<div id="pmr-postsmostread-div">

	<?php } ?>
	
		<?php if($this->title_show==1){ ?>
		
			<?php if($this->widget_view){ 
		
	echo $before_title; } ?>
		
	<span class="pmr-postsmostread-title"><?php _e($this->title_value,$this->plugin_domain);?></span>
			
	<?php if($this->widget_view){ 
		
	echo $after_title; 
	
			} ?>
			
		<?php } ?>
		
	<ul class="alignment-<?php echo  $this->alignment;?>">
		
			<?php if($this->images_show>0 && class_exists('PMRposts')){
				
				foreach ($query_posts_most_read as $tab_posts_most_read){ 
					
					if($this->widget_view){
						
						$postsmostread = new PMRposts;
						
						$image_post = $postsmostread->PMR_get_image_by_postID($tab_posts_most_read->id_post);
						
					}else{	
					
						$image_post = $this->PMR_get_image_by_postID($tab_posts_most_read->id_post);
					
					}?>
					
		<li>
					
			<a href='<?php echo $tab_posts_most_read->url;?>' title='<?php echo $tab_posts_most_read->title;?>'>
					
				<img style="width:<?php echo $this->images_width;?>px;" src='<?php echo $image_post;?>' alt='<?php echo $tab_posts_most_read->title;?>' />
					
			</a>
					
					<?php if($this->images_show==2){ ?>
						
			<a href='<?php echo $tab_posts_most_read->url;?>' title='<?php echo $tab_posts_most_read->title;?>'> 
			
						<?php $views_word = $tab_posts_most_read->view==1 ? __("view",$this->plugin_domain) : __("views",$this->plugin_domain);?>
					
				<?php echo $this->view_show==1 ? $tab_posts_most_read->title." (".$tab_posts_most_read['view']." ".$views_word.")" : $tab_posts_most_read->title;?>
						
			</a>
					<?php } ?>
					
		</li>
						
				<?php }
				
			}else{
			
				foreach ($query_posts_most_read as $tab_posts_most_read){ ?>
			
		<li>
		
			<a href='<?php echo $tab_posts_most_read->url;?>' title='<?php echo $tab_posts_most_read->title?>'>
			
				<?php echo $tab_posts_most_read->title;?>
				
			</a>
	
					<?php $views_word = $tab_posts_most_read->view==1 ? __("view",$this->plugin_domain) : __("views",$this->plugin_domain);
						
				echo  $this->view_show==1 ? " (".$tab_posts_most_read->view." ".$views_word.")" : "";?>
					
		</li> 	
					
			<?php } 
			
			}?>
		
	</ul>
		
	<?php if($this->widget_view){ ?>
		
</div>
<!-- WP Posts Most Read -->	
	
<?php echo $after_widget; 
	
	}else{ ?>
		
</div>
<!-- WP Posts Most Read -->	
	
	<?php } ?>
	
<?php }elseif(isset($page_admin)){?>

	<div id="pmr-postsmostread-div" class="nothing-shown">
	
		<?php _e('Nothing shown',$this->plugin_domain);?>
	
	</div>

<?php } ?>		