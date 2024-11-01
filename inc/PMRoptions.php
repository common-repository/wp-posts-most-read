<div class="wrap" id="amp-div-admin">
  
  	<?php /********************************************************************** Head ***********************************/ ?> 
  	
  	<?php $this->PMR_head_div("settings");?>
	 
	
	<?php /********************************************************************** As article ******************************************/ ?> 
	<div class="preview-wp-postsmostread">
	
		<h2><?php  _e("Preview",$this->plugin_domain);?></h2>
		
		<?php $page_admin = $this->plugin_page_view;
		
		include( 'PMRdisplay.php'); ?>
		
	</div>
		
	
	<?php /********************************************************************** Show number of view form ********************************/ ?> 	
	<div class="option-div">
	
		<h2><?php _e("Display title",$this->plugin_domain);?></h2>

		<div class="descr-option"><?php _e("You have the possibility to display or not the title of the list.",$this->plugin_domain);?></div>
		
		<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>' method='POST'>
		
			<select name='<?php echo $this->plugin_opt_title;?>'>
		
				<option value='0' <?php if($this->title_show==0) echo "selected"; ?> ><?php  _e("No",$this->plugin_domain);?></option>
		
				<option value='1' <?php if($this->title_show==1) echo "selected"; ?> ><?php  _e("Yes",$this->plugin_domain);?></option>
		
			</select>
		
			<input type='submit' value='<?php  _e("Save",$this->plugin_domain);?>' />
		
		</form>
		
		<?php if($this->title_show==1){ ?>
			
			<h2><?php _e("Title ",$this->plugin_domain);?></h2>
			
			<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>' method='POST'>
			
				<input type='text' name='<?php echo $this->plugin_opt_title_value;?>' value='<?php _e($this->title_value); ?>' > 
			
				<input type='submit' value='<?php  _e("Save",$this->plugin_domain);?>' />
			
			</form>
			
		<?php } ?>
		
	</div>	
	
	
	<?php /********************************************************************** Choose number of view ***********************************/ ?> 
	<div class="option-div">
	
		<h2><?php _e("Number of article to display",$this->plugin_domain);?> (20 max.)</h2>
				
		<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>' method='POST'>
		
			<input type='text' name='<?php echo $this->plugin_opt_nb;?>' value='<?php  echo $this->number_show; ?>' > 
		 
		 	<input type='submit' value='<?php  _e("Save",$this->plugin_domain);?>' />
		
		</form>
	
	</div>	
	
	
	<?php /********************************************************************** Show number of view form ********************************/ ?> 	
	<div class="option-div">
	
		<h2><?php _e("Display number of views?",$this->plugin_domain);?></h2>
				
		<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>' method='POST'>
		
			<select name='<?php echo $this->plugin_opt_view;?>'>
		
				<option value='0' <?php if($this->view_show==0) echo "selected"; ?> ><?php  _e("No",$this->plugin_domain);?></option>
		
				<option value='1' <?php if($this->view_show==1) echo "selected"; ?> ><?php  _e("Yes",$this->plugin_domain);?></option>
		
			</select>
		
			<input type='submit' value='<?php  _e("Save",$this->plugin_domain);?>' />
		
		</form>
		
	</div>	
	
	
		<?php /********************************************************************** Vertical or horizontal? ********************************/ ?> 	
	<div class="option-div">
	
		<h2><?php _e("Alignment vertical or horizontal?",$this->plugin_domain);?></h2>

		<div class="descr-option"><?php _e("You have the choice to display your list in horizontal way or in vertical way.",$this->plugin_domain);?></div>
		
		<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>' method='POST'>
		
			<select name='<?php echo $this->plugin_opt_alignment;?>'>
		
				<option value='0' <?php if($this->alignment==0) echo "selected"; ?> ><?php  _e("Vertical",$this->plugin_domain);?></option>
		
				<option value='1' <?php if($this->alignment==1) echo "selected"; ?> ><?php  _e("Horizontal",$this->plugin_domain);?></option>
		
			</select>
		
			<input type='submit' value='<?php  _e("Save",$this->plugin_domain);?>' />
		
		</form>
		
	</div>	
	
	
	<?php /********************************************************************** Display images ********************************/ ?> 	
	<div class="option-div">
	
		<h2><?php _e("Display images?",$this->plugin_domain);?></h2>
				
		<div class="descr-option"><?php _e("You have the possibility to display the thumbnail of posts. With or without the title posts.",$this->plugin_domain);?></div>
		
		<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>' method='POST'>
		
			<select name='<?php echo $this->plugin_opt_images;?>'>
		
				<option value='0' <?php if($this->images_show==0) echo "selected"; ?> ><?php  _e("No",$this->plugin_domain);?></option>
		
				<option value='1' <?php if($this->images_show==1) echo "selected"; ?> ><?php  _e("Display without posts title",$this->plugin_domain);?></option>

				<option value='2' <?php if($this->images_show==2) echo "selected"; ?> ><?php  _e("Display with posts title",$this->plugin_domain);?></option>
				
			</select>
		
			<input type='submit' value='<?php  _e("Save",$this->plugin_domain);?>' />
		
		</form>
		
		<?php if($this->images_show>0){ ?>
		
			<h2><?php _e("Images width",$this->plugin_domain);?> (150px max.)</h2>
			
			<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>' method='POST'>
		
				<input type='text' name='<?php echo $this->plugin_opt_images_width;?>' value='<?php  echo $this->images_width; ?>' > px
			
				<input type='submit' value='<?php  _e("Save",$this->plugin_domain);?>' />
		
			</form>
		
		<?php } ?>
		
	</div>	
	
	
	<?php /********************************************************************** Choose ajax method to count *****************************/ ?> 
	<div class="option-div" id="ajax-method">
	
		<h2><?php _e("Use AJAX to Count?",$this->plugin_domain);?></h2>
		
		<div class="descr-option"><?php _e("If you use a plugin such as WP Super Cache, choose yes. If you have doubts, leave to No.",$this->plugin_domain);?></div>
				
		<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>' method='POST'>
		
			<select name='<?php echo $this->plugin_opt_ajax;?>'>
		
				<option value='0' <?php if($this->ajax_method==0) echo "selected"; ?> ><?php  _e("No",$this->plugin_domain);?></option>
		
				<option value='1' <?php if($this->ajax_method==1) echo "selected"; ?> ><?php  _e("Yes",$this->plugin_domain);?></option>
		
			</select>
		 
		 	<input type='submit' value='<?php  _e("Save",$this->plugin_domain);?>' />
		
		</form>
	
	</div>	
  
  
  	<?php /********************************************************************** Reset options *****************************/ ?> 
	<div class="option-div" style="background: #eee;">
	
		<h2><?php _e("Default options?",$this->plugin_domain);?></h2>
		
		<div class="descr-option"><?php _e("Reset all options you have recorded and display the list with defaults options.",$this->plugin_domain);?></div>
				
		<form action='<?php bloginfo('siteurl');?>/wp-admin/options-general.php?page=<?php echo $this->plugin_page_option;?>' method='POST' onsubmit="return confirm('<?php _e("Are you sure? If you want to go back to defaults options, click yes.",$this->plugin_domain);?>')">
		 
		 	<input name='reset-options' type='submit' value='<?php  _e("Back to default options",$this->plugin_domain);?>' />
		
		</form>
	
	</div>	
	
	
	<?php /********************************************************************** Code to Insert ******************************************/ ?>
	<div class="option-div" id="html-box">
	
		<h2><?php _e("Code to insert in your theme to show the list",$this->plugin_domain);?></h2>

		<div class="descr-option"><?php _e("You have the possibility to display the list anywhere in your template. Just copy-paste this code.",$this->plugin_domain);?></div>
		
		<p>
			
			<code><?php $class_name = get_class();?>
		
			global $<?php echo $class_name;?>; if(method_exists('<?php echo $class_name;?>','<?php echo $this->plugin_display_method;?>')) $<?php echo $class_name;?>-><?php echo $this->plugin_display_method;?>();
		
			</code>
		
		</p>
		
	</div>	
	
	
	<?php /********************************************************************** Code to Insert ******************************************/ ?>
	<div class="option-div" id="html2-box">
	
		<h2><?php _e("Information about HTML structure for you template css",$this->plugin_domain);?></h2>
	
		<div class="descr-option"><?php _e("If you want to modify the css style of the list, we give you the html structure to help you to modify it.",$this->plugin_domain);?></div>
		
		<p>
			
			<code> 
				&lt;div id="pmr-postsmostread-div"&gt;<br />
				&nbsp;&nbsp;&lt;span class="pmr-postsmostread-title"&gt;<b><?php _e("Title",$this->plugin_domain);?></b>&lt;/span&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&lt;ul class="alignement-0"&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;li&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;a&gt;<b><?php _e("Link",$this->plugin_domain);?></b>&lt;/a&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;/li&gt;<br />
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;.....<br />
				&nbsp;&nbsp;&lt;/ul&gt;<br />
				&lt;/div&gt;
			</code>
		
		</p>
		
		<i><?php _e("Class of",$this->plugin_domain);?> <b>ul</b> <?php _e("is",$this->plugin_domain);?> <b>alignement-1</b> <?php _e("if you choose horizontal alignment option",$this->plugin_domain);?></i>
	
	</div>	
			 
</div>


<?php /********************************************************************** Copyright ******************************************/ ?>
<div class="wrap" id="copyrigth">

	<?php $this->PMR_author_div();?>

</div>

