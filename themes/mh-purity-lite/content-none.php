<div class="entry sb-widget">
<?php if (is_search()) { ?>
	<div class="box">
		<p><?php echo __('Sorry, but nothing matched your search terms. Please try again with different keywords.', 'mhp'); ?></p>
		<?php get_search_form(); ?>
	</div>
<?php } else { ?>
	<div class="box">
		<p><?php echo __('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mhp'); ?></p>
		<?php get_search_form(); ?>
	</div>
<?php } ?>
</div>