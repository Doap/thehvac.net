( function( $ ) {
	// Responsive videos
	var all_videos = $( '.entry-content' ).find( 'iframe[src*="player.vimeo.com"], iframe[src*="youtube.com"], iframe[src*="dailymotion.com"],iframe[src*="kickstarter.com"][src*="video.html"], object, embed' );

	all_videos.each( function() {
		var video = $(this),
			aspect_ratio = video.attr( 'height' ) / video.attr( 'width' );

		video
			.removeAttr( 'height' )
			.removeAttr( 'width' );

		if ( ! video.parents( 'object' ).length )
			video.wrap( '<div class="responsive-video-wrapper" style="padding-top: ' + ( aspect_ratio * 100 ) + '%" />' );
	} );

	// Mobile menu
	$( '#header' ).on( 'click', '#mobile-menu a', function() {
		if ( $(this).hasClass( 'left-menu' ) )
			$( 'body' ).toggleClass( 'left-menu-open' );
		else
			$( '#drop-down-search' ).slideToggle( 'fast' );
	} );

	$( '#secondary, #left-nav' ).on( 'click', '.sub-menu-parent > a', function(e) {
		e.preventDefault();
		$(this).toggleClass( 'open' ).parent().find( '.sub-menu:first' ).toggle();
	} );

	var id = ( $( 'body' ).hasClass( 'left-sidebar' ) ) ? $( '#secondary' ) : $( '#left-nav' );
	Harvey.attach( 'screen and (max-width:768px)', {
      	setup: function() {
      		id.addClass( 'offcanvas' );
	      	$( '#site-sub-navigation, #site-navigation' ).prependTo( id ).show();
			$( '#drop-down-search, #header-widgets' ).hide();
      	},
      	on: function() {
      		id.addClass( 'offcanvas' );
	      	$( '#site-sub-navigation, #site-navigation' ).prependTo( id );
			$( '#header-widgets' ).hide();
			$( '#secondary, #left-nav' ).find( '.sub-menu-parent > a' ).removeClass( 'open' );
			$( '#secondary, #left-nav' ).find( '.sub-menu' ).hide();
      	},
      	off: function() {
      		id.removeClass( 'offcanvas' );
      		$( 'body' ).removeClass( 'left-menu-open' );
	      	$( '#secondary, #header-widgets, #site-navigation ul ul, #site-sub-navigation ul ul' ).show();
			$( '#site-navigation, #site-sub-navigation' ).appendTo( '#header .c12' );
			$( '#drop-down-search' ).hide();
      	}
    } );
} )( jQuery );