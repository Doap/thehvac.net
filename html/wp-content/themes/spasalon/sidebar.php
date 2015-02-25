<?php if(is_active_sidebar('sidebar-primary')){ ?>
<div class="span4" id="sidebar">	
   <?php if (  !dynamic_sidebar('sidebar-primary') ) : ?> 
	   					  
	<?php endif;?>
</div>
<?php } ?>