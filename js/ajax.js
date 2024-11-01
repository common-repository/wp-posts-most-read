if(jQuery){ 
	jQuery(document).ready(function() { 
		  
		 jQuery.ajax(  { 
			 
			   url: ""+MyAjax.ajaxurl+"", 
			 
		       type: "POST", 
		        
		       data: {"action":""+MyAjax.action+"","ID_post":""+MyAjax.ID_post+""} 
		 
		 	}
		  
		 );
		  
	}); 
}