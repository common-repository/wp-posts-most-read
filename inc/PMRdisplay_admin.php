<?php wp_reset_query();

global $wpdb;

$page = isset($_GET['page-number']) ? $_GET['page-number'] : 1;

$start = ($page-1)*$this->number_show_admin;

$end = $start+$this->number_show_admin-1;

$total_posts_query = $wpdb->get_results($wpdb->prepare( "SELECT count(*) as cpt FROM $this->table_name ORDER BY view DESC"));

$total_posts = $total_posts_query[0]->cpt;

$total_page = ceil($total_posts/$this->number_show_admin);

$sql_posts_most_read_admin = $wpdb->prepare( "SELECT * FROM $this->table_name ORDER BY view DESC LIMIT $this->number_show_admin OFFSET $start"); ?>

<div id="pmr-postsmostread-div-admin">
 	
 	<table class="widefat">
 		
 		<thead><tr>
 			
 			<th style="width:35px;"><?php echo ucfirst(__('views',$this->plugin_domain));?></th>
 			
 			<th><?php _e('Posts',$this->plugin_domain);?></th>
 			
 		</tr></thead>
	
		<?php if($wpdb->get_row($sql_posts_most_read_admin)>0){ 

			$tab_articles_most_popular_query = $wpdb->get_results($sql_posts_most_read_admin);
			
			foreach ($tab_articles_most_popular_query as $tab_articles_most_popular){ ?>
			
				<tr>
				
					<td><?php echo $tab_articles_most_popular->view;?></td>
				
					<td><a href='<?php echo $tab_articles_most_popular->url;?>' title='<?php echo $tab_articles_most_popular->title;?>' target='_blank' ><?php echo $tab_articles_most_popular->title;?></a></td>
				
				</tr>
				
			<?php } ?>
			
		<?php }else{ ?>
				
			<tr>
			
				<td>0</td>
			
				<td><?php _e('No posts',$this->plugin_domain);?></td>
			
			</tr>
				
		<?php } ?>
	
	</table>
	
	
 	<?php if($total_page>1){ ?>
 	
 		<table id="table-pagination" class="widefat">
 		
 			<thead><tr><th></th></tr></thead>
 	
	 		<tr>
	 		
	 			<td>
	 	
	 				<?php if($page>1){ ?><span class="pagination-prev"><a href="<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_view;?>&page-number=<?php echo $page-1;?>"><<</a></span><?php } ?>
	 	
	 				Pages : 
	 	
	 				<?php for($i=1;$i<=$total_page;$i++){ ?>
	 		
	 					<?php if($i==$page){?>
	 			
	 						<span class="pagination-current"><?php echo $i;?></span>
	 		
	 					<?php }else{?>
	 			
	 						<span class="pagination-link"><a href="<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_view;?>&page-number=<?php echo $i;?>" ><?php echo $i;?></a></span>
	 		
	 					<?php }?>
	 	
	 				<?php }?>
	 	
	 				<?php if($page<$total_page){?><span class="pagination-next"><a href="<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_view;?>&page-number=<?php echo $page+1;?>">>></a></span><?php } ?>
	 	
	 			</td>
	 			
	 		</tr>
	 		
 		</table>
	
	<?php } ?>
	
</div>

