jQuery(document).ready(function($) {
	// tab js
	$('.nav-tab-wrapper a').click(function(evt) {
		$('.nav-tab-wrapper a').removeClass('nav-tab-active');
		$(this).addClass('nav-tab-active').blur();
		var clicked_group = $(this).attr('href');
		if (typeof(localStorage) != 'undefined' )
		{
			localStorage.setItem("activetab", $(this).attr('href'));
		}
		$('.group').hide();
		$(clicked_group).fadeIn();
		evt.preventDefault();
	});
	
	
});	

	/*Admin options pannal data value*/
	function datasave_home(id) 
	{ 	
		
		var spasalon_settings_save_= "#spasalon_settings_save_"+id;
		var theme_options_home = "#theme_options_home_"+id;
		var success_message_save = "#success_message_save_"+id;
		
		jQuery(spasalon_settings_save_).val("1");        
	    jQuery.ajax({
				   url:'admin.php?page=spa',
				   type:'post',
				   data : jQuery(theme_options_home).serialize(),
				   success : function(data)
					{  //alert('Options data successfully saved');
					   jQuery(success_message_save).show();
					   jQuery(success_message_save).fadeOut(5000);
					}			
				});
	}
	
	/*Admin options value reset */
	function reset_data_home(id) 
	{   
		var spasalon_settings_save_= "#spasalon_settings_save_"+id;
		var theme_options_home = "#theme_options_home_"+id;
		var success_message_reset = "#success_message_reset_"+id;
		 jQuery(spasalon_settings_save_).val("2");
		jQuery.ajax({ 
			   url:'admin.php?page=spa',
			   type:'post',
			  data : jQuery(theme_options_home).serialize(),
		   success : function(data)
			{	//	alert('Options data successfully reset');
				jQuery(success_message_reset).show();
			    jQuery(success_message_reset).fadeOut(5000);
			}		
	   });
	}
  jQuery(function() {
    jQuery( "#accordion" ).accordion({
	heightStyle: "content",
	collapsible: true
	});
  });
	
	