<?php
/*
 * Plugin Name: RSS and Twitter Subscriber Counter
 * Plugin URI: http://www.gazpo.com
 * Description: A widget to show Feedburner subscribers and twitter followers.
 * Version: 1.0
 * Author: Sami Ch.
 * Author URI: http://gazpo.com
 */

add_action( 'widgets_init', 'max_magazine_subscribers_count_widgets' );

function max_magazine_subscribers_count_widgets() {
	register_widget( 'max_magazine_subscribers_count_widget' );
}

class max_magazine_subscribers_count_widget extends WP_Widget {


	function max_magazine_subscribers_count_widget() {
		$widget_ops = array( 'classname' => 'widget_subscribers', 'description' => __('A widget to show Feedburner subscribers and twitter followers.', 'max-magazine') );
		$this->WP_Widget( 'max_magazine_subscribers_count_widget', __('Max: Subscriber Counter', 'max-magazine'), $widget_ops );
	}
	
	function getTwitFeedburnCount($username, $type){
			
			if($type == "feedburner"){
				$option_name = 'gazpo_feedburner_counter' ;
			} elseif($type == "twitter"){
				$option_name = 'gazpo_twitter_counter' ;
			}
			
			$current_time = time();	
			$last_update_time = get_option("gazpo_social_counter_update_time");
			
			if (empty($last_update_time)){
				$timestamp = strtotime('31-12-2011');	//set an old time.
				update_option('gazpo_social_counter_update_time', $timestamp);			
			}
			
			$difference = ($current_time - $last_update_time) / 86400;	
			
			if ($difference >= 4){   // if difference is 4 days or more
			
				if($type == "feedburner"){
					$feedburner_count = 0;	//set initial value
					$date = date('Y-m-d', strtotime('-4 days')); //average subscribers in last 4 days
					$data = wp_remote_fopen("http://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=".$username."&dates=".$date.",".$date);       				
					if ($data) {
						preg_match('/circulation=\"([0-9]+)\"/',$data, $match);						
						if ($match[1] != 0) {
							$feedburner_count = $match[1];
						}						
					}					
					$total = $feedburner_count; //return subscribers count
				}	
				elseif($type == "twitter"){
					$twitter_count = 0; //set initial value
					$data = wp_remote_fopen ( 'http://twitter.com/users/show/' . $username );
					preg_match('/followers_count>(.*)</',$data,$match);
					if ($match[1] != 0) {
						$twitter_count = $match[1];
					}					
					$total = $twitter_count; //return followers count
				}			
				
				if ( $total > 0 ) {
					update_option($option_name, $total);		
				}
				
				return strval ( $total );
				
			}else{
				$total = get_option ($option_name);
				return strval ( $total );
			} 
		}
		
	function widget( $args, $instance ) {
		extract( $args );
		$feedburner_id = $instance['feedburner_id'];
		$twitter_id = $instance['twitter_id'];

		echo $before_widget;
		$feedburner_count = $this -> getTwitFeedburnCount($feedburner_id, "feedburner");  
		$twitter_count = $this -> getTwitFeedburnCount($twitter_id, "twitter");  ;		
		?>
		
		<div class="widget_social_count">
			<ul>				
				<li class="rss">
					<a href="http://feeds.feedburner.com/<?php echo $feedburner_id; ?>"><?php echo $feedburner_count; ?></a><br>
					<span class="small">subscribers</span>
				</li>
				
				<li class="twitter">
					<a href="http://www.twitter.com/<?php echo $twitter_id; ?>"><?php echo $twitter_count; ?></a><br>
					<span class="small">followers</span>
				</li>
			</ul>
		</div>
		
        <?php
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['feedburner_id'] = $new_instance['feedburner_id'];
		$instance['twitter_id'] = $new_instance['twitter_id'];
		return $instance;
	}

	function form( $instance ) {
	
		$defaults = array(
		'feedburner_id' => "gazpo",
		'twitter_id' => 'gazpodotcom'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'feedburner_id' ); ?>"><?php _e('Feedburner ID:', 'max-magazine') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'feedburner_id' ); ?>" name="<?php echo $this->get_field_name( 'feedburner_id' ); ?>" value="<?php echo $instance['feedburner_id']; ?>" />
		</p>
        
       	<p>
			<label for="<?php echo $this->get_field_id( 'twitter_id' ); ?>"><?php _e('Twitter ID:', 'max-magazine') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_id' ); ?>" name="<?php echo $this->get_field_name( 'twitter_id' ); ?>" value="<?php echo $instance['twitter_id']; ?>" />
		</p>		
	<?php
	}
}
?>