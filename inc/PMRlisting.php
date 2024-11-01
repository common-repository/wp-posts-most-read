 <div class="wrap" id="amp-div-admin">
  
  	<?php /********************************************************************** Head ***********************************/ ?> 
  	
  	<?php $this->PMR_head_div("listing");?>

  	
	<?php /********************************************************************** Reset number of view ***********************************/ ?> 
	<div class="option-div-reset-count">
	
		<h2><?php _e("Reset number of views",$this->plugin_domain);?></h2>
		
		<?php if(get_option($this->plugin_opt_view_last_reset)){ ?>
		
			<div>Count since : <?php echo date('d/m/Y G:i',get_option($this->plugin_opt_view_last_reset));?></div>
			
		<?php } ?>
		
		<div class="descr-option"><?php _e("You have the possibility to put all count to zero (This action will delete all data recorded)",$this->plugin_domain);?></div>
		
		<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_view;?>' method='POST' onsubmit="return confirm('<?php _e("Are you sure? If you you want reset number of views, click yes.",$this->plugin_domain);?>')">
		
		 	<input type='submit' name='reset-number-views' value='<?php _e("Reset",$this->plugin_domain);?>' />
		
		</form>
	
	</div>	
	
	
	<?php /********************************************************************** 200 ******************************************/ ?>
	<div class="listing">
	
		<!-- <h2><?php //_e("Listing of",$this->plugin_domain);?> <?php //echo $this->number_show_admin;?> <?php //_e("posts",$this->plugin_domain);?> </h2> -->
		
		<?php include( 'PMRdisplay_admin.php');?>
	
	</div>
 
 </div>
 
<?php /********************************************************************** Copyright ******************************************/ ?>

<div class="wrap" id="copyrigth">

	<?php $this->PMR_author_div();?>

</div>
 