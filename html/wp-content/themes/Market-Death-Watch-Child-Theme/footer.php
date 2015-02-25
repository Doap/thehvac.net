<?php $options = get_option('mh_options'); ?>
<?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) { ?>
<footer class="footer clearfix">
	<?php if (is_active_sidebar('footer-1')) { ?>
		<div class="col-1-3 footer-widget-area">
			<?php dynamic_sidebar('footer-1'); ?>
		</div>
	<?php } ?>
	<?php if (is_active_sidebar('footer-2')) { ?>
		<div class="col-1-3 footer-widget-area">
			<?php dynamic_sidebar('footer-2'); ?>
		</div>
	<?php } ?>
	<?php if (is_active_sidebar('footer-3')) { ?>
		<div class="col-1-3 footer-widget-area">
			<?php dynamic_sidebar('footer-3'); ?>
		</div>
	<?php } ?>
</footer>
<?php } ?>
<div class="copyright-wrap">
	<p class="copyright"><?php echo 'Copyright &copy; ' . date("Y") . ' | <a href="http://www.doap.com/" rel="nofollow">Doap.com</a>'; ?>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
