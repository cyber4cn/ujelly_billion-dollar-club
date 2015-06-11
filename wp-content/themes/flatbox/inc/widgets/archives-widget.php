<?php
/**
 * Plugin Name: Archives List
 */

class flatbox_archives_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function flatbox_archives_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'flatbox_archives_widget', 'description' => __('Displays a list of monthly archives, categories or pages in two columns.', 'flatbox') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'flatbox_archives_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'flatbox_archives_widget', __('FlatBox: Archives / Categories / Pages List', 'flatbox'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$type = $instance['type'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		?>

        	<div class="archive-list">

			<?php
				if($type == 'pages') {
					$page_s = explode('</li>',wp_list_pages('title_li=&echo=0&depth=1&style=none'));
				}elseif ($type == 'categories'){
					$page_s = explode('</li>',wp_list_categories('show_count=0&title_li=&echo=0&depth=-1'));
				}else {
                    $page_s = explode('</li>',wp_get_archives('type=monthly&echo=0'));
				}
				$page_n = count($page_s) - 1;
				$page_col = round($page_n / 2);
        $page_left = '';
        $page_right = '';
					for ($i=0;$i<$page_n;$i++){
					 if ($i<$page_col){
					  $page_left = $page_left.''.$page_s[$i].'</li>';
					 }
					 elseif ($i>=$page_col){
					  $page_right = $page_right.''.$page_s[$i].'</li>';
					 }
					}
					?>
					<ul class="archive-left">
					<?php echo $page_left; ?>
					</ul>
					<ul class="archive-right">
					<?php echo $page_right; ?>
					</ul>
				</div>

		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['type'] = $new_instance['type'];

		return $instance;
	}


	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Archives', 'flatbox'), 'type' => 'archives');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title','flatbox') ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:90%;" />
		</p>


		<!-- Type -->
		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type','flatbox') ?>:</label>
			<select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>" class="widefat type" style="width:100%;">
				<option value='archives' <?php if ('archives' == $instance['type']) echo 'selected="selected"'; ?>><?php _e('archives','flatbox') ?></option>
				<option value='categories' <?php if ('categories' == $instance['type']) echo 'selected="selected"'; ?>><?php _e('categories','flatbox') ?></option>
				<option value='pages' <?php if ('pages' == $instance['type']) echo 'selected="selected"'; ?>><?php _e('pages','flatbox') ?></option>
			</select>
		</p>


	<?php
	}
}

?>