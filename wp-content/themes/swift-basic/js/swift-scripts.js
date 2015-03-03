/*
 * Delayed loading of gravatars
 */
jQuery(window).load(function() {
    jQuery('img[data-gravatar-hash]').each(function(){
	    var hash = jQuery(this).attr('data-gravatar-hash');
	    var img_url = 'http://www.gravatar.com/avatar/'+hash;
	    jQuery(this).attr('src',img_url);
	 });
});


/* Image width in the posts can be max 550px */
	jQuery(window).load(function() {
		jQuery('article .wp-caption img').each(function() {
			current_width 			= jQuery(this).width();
			current_resized_width 	= jQuery(this).attr('width');
			current_height 			= jQuery(this).height();
			content_width 			= jQuery('#content').width() - 40;
			

			aspect_ratio = current_width/current_height;
			if(current_width > content_width && current_resized_width>content_width) {
				jQuery(this).removeAttr('width');
				jQuery(this).removeAttr('height');
			
				new_height = content_width/aspect_ratio;
				jQuery(this).width(content_width+'px');
				jQuery(this).height(new_height);
				jQuery(this).addClass( 'resized aligncenter' )

			}
		});
	});
	
	/* Image width in the posts can be max 550px */
	jQuery(window).load(function() {
		jQuery('.wp-caption').each(function() {
			jQuery(this).removeAttr('width');
			current_width = jQuery(this).width();
			current_height = jQuery(this).height();
			content_width=jQuery('#content').width()-30-10;
			
			
			aspect_ratio = current_width/current_height;
			if(current_width > content_width+10) {
				new_height = (content_width+10)/aspect_ratio;
				jQuery(this).width(content_width+10+'px');
				jQuery(this).addClass( 'resized aligncenter' )

			}
		});
	});

	jQuery(window).load(function() {
		jQuery('article img').each(function() {
			current_width 			= jQuery(this).width();
			padding_border_width 	= jQuery(this).outerWidth() - current_width;
			current_resized_width 	= jQuery(this).attr('width');
			current_height 			= jQuery(this).height();
			content_width 			= jQuery('#content').width() - 20 - padding_border_width;
			
			aspect_ratio = current_width/current_height;
			if(current_width > content_width && current_resized_width>content_width) {
				jQuery(this).removeAttr('width');
			jQuery(this).removeAttr('height');
			
				new_height = content_width/aspect_ratio;
				jQuery(this).width(content_width+'px');
				jQuery(this).height(new_height);
				jQuery(this).addClass( 'resized aligncenter' )

			}
		});
	});
	
/*	-----------------------------------------------------------------------------------*/

	jQuery(function($) {
		
	/*-----------------------------------------------------------------------------------
	  Tabs shortcode
	-----------------------------------------------------------------------------------*/
		
		if ( jQuery( '.shortcode-tabs').length ) {	
			
			jQuery( '.shortcode-tabs').each( function () {
			
				var tabCount = 1;
			
				jQuery(this).children( '.tab').each( function ( index, element ) {
				
					var idValue = jQuery(this).parents( '.shortcode-tabs').attr( 'id' );
				
					var newId = idValue + '-tab-' + tabCount;
				
					jQuery(this).attr( 'id', newId );
					
					jQuery(this).parents( '.shortcode-tabs').find( 'ul.tab_titles').children( 'li').eq(index).find( 'a').attr( 'href', '#' + newId );
					
					tabCount++;
				
				});
			
				var thisID = jQuery(this).attr( 'id' );
			
				jQuery(this).tabs( { fx: { opacity: 'toggle', duration: 200 } } );
			
			});


		} // End IF Statement
		
	/*-----------------------------------------------------------------------------------
	  Toggle shortcode
	-----------------------------------------------------------------------------------*/
		
		if ( jQuery( '.shortcode-toggle').length ) {	
			
			jQuery( '.shortcode-toggle').each( function () {
				
				var toggleObj = jQuery(this);
				
				toggleObj.closedText = toggleObj.find( 'input[name="title_closed"]').attr( 'value' );
				toggleObj.openText = toggleObj.find( 'input[name="title_open"]').attr( 'value' );
				
				// Add logic for the optional excerpt text.
				if ( toggleObj.find( 'a.more-link.read-more' ).length ) {
					toggleObj.readMoreText = toggleObj.find( 'a.more-link.read-more' ).text();
					toggleObj.readLessText = toggleObj.find( 'a.more-link.read-more' ).attr('readless');
					toggleObj.find( 'a.more-link.read-more' ).removeAttr('readless');
					
					toggleObj.find( 'a.more-link' ).click( function () {
						
						var moreTextObj = jQuery( this ).next( '.more-text' );
						
						moreTextObj.animate({ opacity: 'toggle', height: 'toggle' }, 300).css( 'display', 'block' );
						moreTextObj.toggleClass( 'open' ).toggleClass( 'closed' );
						
						if ( moreTextObj.hasClass( 'open') ) {
						
							jQuery(this).text(toggleObj.readLessText);
						
						} // End IF Statement
						
						if ( moreTextObj.hasClass( 'closed') ) {
						
							jQuery(this).text(toggleObj.readMoreText);
						
						} // End IF Statement
						
						return false;
					});
				}
				
				toggleObj.find( 'input[name="title_closed"]').remove();
				toggleObj.find( 'input[name="title_open"]').remove();
				
				toggleObj.find( 'h4.toggle-trigger a').click( function () {
				
					toggleObj.find( '.toggle-content').animate({ opacity: 'toggle', height: 'toggle' }, 300);
					toggleObj.toggleClass( 'open' ).toggleClass( 'closed' );
					
					if ( toggleObj.hasClass( 'open') ) {
					
						jQuery(this).text(toggleObj.openText);
					
					} // End IF Statement
					
					if ( toggleObj.hasClass( 'closed') ) {
					
						jQuery(this).text(toggleObj.closedText);
					
					} // End IF Statement
					
					return false;
				
				});
						
			});


		} // End IF Statement
		
	}); // jQuery()
	

/* Load the Share Buttons */
jQuery(window).load(function(){
    var shareCode = jQuery('#share-post').html();
    jQuery('div.share').html(shareCode);
    
    /* digg button */
    (function() {
        var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'http://widgets.digg.com/buttons.js';
        s1.parentNode.insertBefore(s, s1);
      })();
});

/* add arrow to the drop down */
function Mx_nav(){
    jQuery(".nav li ul").prev().addClass('add-arrow')
    jQuery(".nav li ul li ul").prev().removeClass('add-arrow').addClass('add-arrow-right')
}   
jQuery(window).load(function(){                   
	    Mx_nav();
});
/* Responsive nav and widgets */
function swift_640_mobile(){
	jQuery(function ($){
		if(window.outerWidth<640){
			$('.pull,.pull_w').remove()
			/* Hide the nav and widgets to start with */
			$('.nav,.widget').hide()
			jQuery(window).load(function(){
				$('.add-arrow').removeClass('add-arrow')
				$('.add-arrow-right').removeClass('add-arrow-right')
			})
			/* Add the menu click area */
			if ($('#above-logo').length && $('#below-logo').length){
				$('#below-logo').prepend('<div class="pull alignleft" data="above-logo">&nbsp;</div>')
				$('#below-logo').prepend('<div class="pull alignright" data="below-logo">&nbsp;</div>')
			}else if($('#above-logo').length){
				$('#branding .div-content').append('<div class="pull alignright" data="above-logo">&nbsp;</div>')
			}else if($('#below-logo').length){
				$('#below-logo').append('<div class="pull alignright" data="below-logo">&nbsp;</div>')
			}
			/* Append a class to nav*/

			$('.pull').click(function(){
				$("#"+$(this).attr("data")+" .nav").slideToggle()
			})	

			/* Now the widgets */
			$('.widget').each(function(){
				title = $(this).find('.widget-title').html();
				if(!title){
					title ="Show";
				}
				id=$(this).attr('ID')
				$(this).before('<div class="pull_w" data="'+id+'">'+title+'</div>')
			});
			jQuery('.pull_w').click(function(){
				jQuery("#"+jQuery(this).attr("data")).slideToggle()
			});
		}else{
			$('.nav,.widget').show()
			$('.pull,.pull_w').remove()
		}
	});
}
jQuery(function ($) {
	$(document).ready(function(){
		swift_640_mobile();
		$(window).resize(function(){
				swift_640_mobile();
		});
	});

});