
/*
 * Delayed loading of gravatars
 */
jQuery(window).load(function() {
    jQuery('#comments img[data-gravatar-hash]').each(function(){
	    var hash = jQuery(this).attr('data-gravatar-hash');
	    var img_url = 'http://www.gravatar.com/avatar/'+hash+'?s=64';
	    jQuery(this).attr('src',img_url);
	 });
});