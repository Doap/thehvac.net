/* Tabs on Options page */

jQuery(function() {
	jQuery( "#tabs" ).tabs({ cookie: {expires: 1}});
});
jQuery(window).load(function() {
	jQuery('.color-group').each(function(){
		var ID = '#'+jQuery(this).attr('id')
		var temp = jQuery.cookie('show_'+jQuery(this).attr('id'));
		temp = Number(temp)
		if( temp){
			jQuery(ID+" div.color,hr").show();
			jQuery(ID+" .color-heading").removeClass('hidden');		
			
		}else{
			jQuery(ID+" div.color,hr").hide();
			jQuery(ID+" .color-heading").addClass('hidden');
		}
		
	});
});

jQuery(function() {
jQuery('.color-heading a').click(function () {
	var groupID = jQuery(this).parent().parent().attr('id');
	if (jQuery("#"+groupID+" div.color,#"+groupID+" hr").is(":hidden")) {
		jQuery("#"+groupID+" div.color,#"+groupID+" hr").slideDown("slow");
		jQuery(this).parent().removeClass('hidden');
		jQuery.cookie('show_'+groupID,1);

	} else {
		jQuery("#"+groupID+" div.color,#"+groupID+" hr").hide();
		jQuery(this).parent().addClass('hidden');
		jQuery.cookie('show_'+jgroupID,0);
	}
	});
});

jQuery(function() {
	jQuery('#expand').click(function () {
		if (jQuery("div.color,hr").is(":hidden")) {
			jQuery("div.color,hr").slideDown("fast");
			jQuery('.color-heading').removeClass('hidden');
			jQuery(this).html("[-] Collapse All")
			jQuery('.color-group').each(function(){
				jQuery.cookie('show_'+jQuery(this).attr('id'),1);
				console.log(jQuery(this).attr('id'))
			});

		}
		else{
			jQuery("div.color,hr").hide();
			jQuery('.color-heading').addClass('hidden');
			jQuery(this).html("[+] Expand All")
			jQuery('.color-group').each(function(){
				jQuery.cookie('show_'+jQuery(this).attr('id'),0);
			});

		}
	});
});
/* Radio button options */
jQuery(document).ready(function(){
	

	
	jQuery('input:radio').click(function() {
		
		var radioID = jQuery(this).parent().attr('id');
	/*	jQuery('#'+radioID+' input').next().find( 'img' ).css('background','#fdd2cf')

		jQuery('#'+radioID).find(':checked').next().find( 'img' ).css('background','red')
		
		jQuery('#'+radioID+' input').next().find( 'img' ).removeClass('selected');

		jQuery('#'+radioID).find(':checked').next().find( 'img' ).addClass('selected');
		
		*/

		jQuery('#'+radioID+' input').next().removeClass('selected');

		jQuery('#'+radioID).find(':checked').next().addClass('selected');
	
	});	
	
	jQuery('.image_upload_button').each(function(){

		var clickedObject = jQuery(this);
		var clickedID = jQuery(this).attr('id');
		var actionURL = jQuery(this).parent().find('.ajax_action_url').val();

		new AjaxUpload(clickedID, {
			  action: actionURL,
			  name: clickedID, // File upload name
			  data: { // Additional data to send
					action: 'swift_ajax_uploader_action',
					type: 'upload',
					data: clickedID },
			  autoSubmit: true, // Submit file after selection
			  responseType: false,
			  onChange: function(file, extension){},
			  onSubmit: function(file, extension){
					clickedObject.text('Uploading'); // change button text, when user selects file	
					this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
					interval = window.setInterval(function(){
						var text = clickedObject.text();
						if (text.length < 13){	clickedObject.text(text + '.'); }
						else { clickedObject.text('Uploading'); } 
					}, 200);
			  },
			  onComplete: function(file, response) {

				window.clearInterval(interval);
				clickedObject.text('Upload Image');	
				this.enable(); // enable upload button

				// If there was an error
				if(response.search('Upload Error') > -1){
					var buildReturn = '<span class="upload-error">' + response + '</span>';
					jQuery(".upload-error").remove();
					clickedObject.parent().after(buildReturn);

				}
				else{

					var previewSize = clickedObject.parent().find('.image_preview_size').attr('value');

					var buildReturn = '<img style="max-width:'+previewSize+'px;" class="swift_image_preview" id="image_'+clickedID+'" src="'+response+'" alt="" />';

					jQuery(".upload-error").remove();
					jQuery("#image_" + clickedID).remove();	
					clickedObject.parent().after(buildReturn);
					jQuery('img#image_'+clickedID).fadeIn();
					clickedObject.next('span').fadeIn();
					clickedObject.parent().find('.uploaded_url').val(response);
				}
			  }
			});

		});

		//AJAX Remove (clear option value)
		jQuery('.image_reset_button').click(function(){

			var clickedObject = jQuery(this);
			var clickedID = jQuery(this).attr('id');
			var theID = jQuery(this).attr('title');	
			var actionURL = jQuery(this).parent().find('.ajax_action_url').val();
			
			var ajax_url = actionURL;

			var data = {
				action: 'swift_ajax_uploader_action',
				type: 'image_reset',
				data: theID
			};

			jQuery.post(ajax_url, data, function(response) {
				var image_to_remove = jQuery('#image_' + theID);
				var button_to_hide = jQuery('#reset_' + theID);
				image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
				button_to_hide.fadeOut();
				clickedObject.parent().find('.uploaded_url').val('');				
			});

			return false; 

		});
		
		 jQuery('#body_bg').bind('colorpicked', function () {
		      alert(jQuery(this).val());
		    });
});


/* Sortable and draggable */
function update_input(optionName, test){
	var output = '';
    test.find('input').each(function() {     
        output = output+jQuery(this).val()+',';
    });
    output = output.substring(0, output.length - 1);
	jQuery('input#'+optionName).val(output);
	console.log(output)
};

jQuery(function() {
	jQuery( ".sortable" ).each(function(){
		
		/* trying to save changes when the text widget is updated */
		jQuery(this).find('input').change( function(){
			console.log(jQuery(this).parent().parent().attr('ID'))
			jQuery(this).parent().parent().sortable('refresh')
		});
		
		jQuery(this).sortable({
			update : function () { 
				var optionName = jQuery(this).attr('ID');
				update_input(optionName,jQuery(this));
			},
		
			create : function () { 
				var optionName = jQuery(this).attr('ID');
				update_input(optionName,jQuery(this));
			},
		
			receive: function(e, ui) { sortableIn = 1; },
		
			over: function(e, ui) { sortableIn = 1; },
		
			out: function(e, ui) { sortableIn = 0; },
		
			beforeStop: function(e, ui) {
				if (sortableIn == 0) { 
					ui.item.remove(); 
				} 
				var optionName = jQuery(this).attr('ID');
				update_input(optionName,jQuery(this));
			}	
			
	    });	
		
	});

	jQuery( ".draggable li" ).each(function(){
		jQuery(this).draggable({
			connectToSortable: ".sortable",
			helper: "clone",
			revert: "invalid"
		});
	});
	
	jQuery( ".sortable-container ul,.sortable-container li" ).disableSelection();
	
	/* Enable selection on input fields */
	jQuery(".sortable").sortable({
		stop: function () {
			// enable text select on inputs
			jQuery(".sortable").find("input")
			.bind('mousedown.ui-disableSelection selectstart.ui-disableSelection', function(e) {
				e.stopImmediatePropagation();
			});
		}
	}).disableSelection();
});

function confirmation() {
	var answer = confirm("Reset will delete the options in other tabs on this page. Are you sure you want to proceed?")
	if(answer){
		var answer = confirm("Are you really sure?")
	}
	if(answer)
		return true;
	else
		return false;
}

function confirm_color_import() {
	var answer = confirm("Import will overwrite your current color scheme. Are you sure you want to proceed.")
	if(answer){
		var answer = confirm("Are you really sure?")
	}
	if(answer)
		return true;
	else
		return false;
}

jQuery(function() {
	jQuery( "#slider-range" ).slider({
		range: true,
		min: 0,
		max: 100,
		step: 0.1,
		values: [ jQuery('#content_width').val(), parseInt(jQuery('#content_width').val())+parseInt(jQuery('#sb1_width').val()) ],
		slide: function( event, ui ) {
					var content = jQuery( "#slider-range" ).slider( "values", 0 )
					var sb1 = jQuery( "#slider-range" ).slider( "values", 1 ) - jQuery( "#slider-range" ).slider( "values", 0 )
					var sb2 = 100 - jQuery( "#slider-range" ).slider( "values", 1 )
					var sb = 100 - jQuery( "#slider-range" ).slider( "values", 0 )
					wrapper = jQuery('#wrapper_width').val()/100;
					/*
					console.log(Math.round(content).toFixed(2))
					content = Math.round(content).toFixed(2)
					sb = Math.round(sb).toFixed(2)
					sb1 = Math.round(sb1).toFixed(2)
					sb2 = Math.round(sb2).toFixed(2)
					*/
					'Content width is '+content+'% {'+content*wrapper+'}px'
					jQuery('#content-width').html('Content width is <strong>'+content+'% {'+parseInt(content*wrapper)+'px}</strong>')
					jQuery('#sb-width').html('Sidebar width is <strong>'+sb+'% {'+parseInt(sb*wrapper)+'px}</strong>')
					jQuery('#sb1-width').html('Sidebar 1 width is <strong>'+sb1+'% {'+parseInt(sb1*wrapper)+'px}</strong>')
					jQuery('#sb2-width').html('Sidebar 2 width is <strong>'+sb2+'% {'+parseInt(sb2*wrapper)+'px}</strong>')
					jQuery('#content_width').val(content)
					jQuery('#sb1_width').val(sb1)
					//alert(( "$" + jQuery( "#slider-range" ).slider( "values", 0 ) +" - $" + jQuery( "#slider-range" ).slider( "values", 1 ) ))
		}
	});
	
	/*
	 * JS for Google WEB fonts
	 */
	jQuery(document).on('click','span.remove',function(){	
		remove_font = jQuery(this).attr('data');
		console.log(remove_font);
		jQuery('#li_'+remove_font).remove();
		jQuery('#input_'+remove_font).remove();
	});
	
	WebFont.load({
					google: {
			      		families: font_list_start,
			    	}
			  	});
			  		
	var data = {
		action: 'font_scroll',
		font_number: 0,
		sample: jQuery("#sample_text").val()
	};
	jQuery( '#infinite_scroll' ).scroll(function(){
			data['sample']= jQuery("#sample_text").val();
			var height = jQuery('#infinite_scroll')[0].scrollHeight;
			var position = jQuery('#infinite_scroll').scrollTop()+240
			if((height-position)<3){		
				data['font_number'] = jQuery('#infinite_scroll').children('li').length;	
				var families = [];
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#infinite_scroll').append( response );
					jQuery('li',jQuery('<div>'+response+'</div>')).each(function(){
						families.push(jQuery(this).attr('data'));
					});
					WebFont.load({
			    		google: {
			      			families: families
			    		}
			  		});
				});				
			}		
	});		
	jQuery(document).on('click','#infinite_scroll li',function(){
		var font;
		font = jQuery(this).attr('data')
		jQuery('#font_preview').css('font-family',font)
		jQuery('#addfont').text('Add '+ font)
		jQuery('#addfont').attr('data',font)
	});	
	
	jQuery('#addfont').click(function(){
		//jQuery('#selected_fonts').append(jQuery('#addfont').attr('data'))
		font = jQuery('#addfont').attr('data');
		for_blogname = jQuery('#font_optimization #blogname').is(':checked')
		for_tagline = jQuery('#font_optimization #tagline').is(':checked')
		san_font=font.replace(' ', '_')
		li = '<li id="li_'+san_font+'"  style="font-family:'+font+'" class="btn"><strong>'+font+'</strong><br><span>'
		if(for_blogname && for_tagline){
			li = li+'For blogname and tagline only'
		}else{
			if(for_blogname)
				li = li+'For blogname only'
			if(for_tagline)
				li = li+'For tagline only'
		}
		if( !for_blogname && !for_tagline){
			li = li+'Load entire font'
		}
		li = li+'</span><span data="'+san_font+'"class="remove"></li>'
		input = '<input type="hidden" id="input_'+san_font+'" name="swift_design_options[swift_gfonts][]" value="'+font+','+for_blogname+','+for_tagline+'">'
		jQuery('#selected_fonts').append(li+input)
	})
	jQuery('span.remove').click(function(){	
		remove_font = jQuery(this).attr('data')
		console.log(remove_font)
		jQuery('#li_'+remove_font).remove()
		jQuery('#input_'+remove_font).remove()
	})

});

//-->
