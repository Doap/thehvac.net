<?php
GLOBAL $swift_design_options;
GLOBAL $swift_is_mobile;
if( $swift_is_mobile->isMobile() || isset( $swift_design_options['sb_position'] ) && $swift_design_options['sb_position'] != 'centered' ):
?>
<div id="sidebar-container">

	<div id="sidebar" class="clearfix">

		<aside class="wsb widget-mas">
			<div class="div-content">
				<?php dynamic_sidebar( 'ws_nonsticky' ); ?>
			</div>
		</aside>
		<div id="sticky">
			<aside class="wsb widget-mas">
				<div class="div-content">
					<?php dynamic_sidebar( 'wst' ); ?>

				</div>
			</aside>

			<aside id="sb1" class="widget-mas">
				<div class="div-content">
					<?php dynamic_sidebar( 'ns1' ); ?>
				</div>
			</aside>

			<aside id="sb2" class="widget-mas">
				<div class="div-content">
					<?php dynamic_sidebar( 'ns2' ); ?>
				</div>
			</aside>

			<div class="clear"></div>
			<aside class="wsb widget-mas">
				<div class="div-content">
					<?php dynamic_sidebar( 'wsb' ); ?>
				</div>
			</aside>
		</div>
	</div>
	<!-- /#sidebar -->
</div>
<!-- /#sidebar-container -->
<div class="clear"></div>

</div>
<!-- /#left -->
<?php
else:
?>
<aside id="sb1">
	<div class="div-content">
		<?php dynamic_sidebar( 'ns1' ); ?>
	</div>
</aside>
</div>
<!--  /#left -->
<aside id="sb2">
	<div class="div-content">
		<?php dynamic_sidebar( 'ns2' ); ?>
	</div>
</aside>
<?php
endif;
?>
<?php swift_after_main() ?>

</div>
<!-- /#main -->
