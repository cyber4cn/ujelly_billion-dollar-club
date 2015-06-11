<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {
	// Test data
	$color_scheme = array(
		'default'     => __('default', 'flatbox'),
		'light'   	  => __('light', 'flatbox'),
		'blue'        => __('blue', 'flatbox'),
		'coffee'      => __('coffee', 'flatbox'),
		'ectoplasm'   => __('ectoplasm', 'flatbox'),
		'midnight'    => __('midnight', 'flatbox'),
		'ocean'       => __('ocean', 'flatbox'),
		'sunrise'     => __('sunrise', 'flatbox'),
	);
	$radio = array("0" => __('No', 'flatbox'),"1" => __('Yes', 'flatbox'));
	$meta_defaults = array(
		'content'   => '1',
		'thumbnail' => '1',
		'date'      => '1',
		'author'    => '1',
		'comments'  => '1',
		'categories'=> '1',
		'tags'      => '1',
	);
	// Multicheck Array
	$meta_data = array(
		'content'      => __('Display excerpt', 'flatbox'),
		'thumbnail'      => __('Display thumbnail', 'flatbox'),
		'date'      => __('Display date', 'flatbox'),
		'author'    => __('Display author', 'flatbox'),
		'comments'  => __('Display comments', 'flatbox'),
		'categories'  => __('Display categories', 'flatbox'),
		'tags'  => __('Display tags', 'flatbox'),
	);
	$single_defaults = array(
		'thumbnail' => '1',
		'author-bio'      => '1',
		'related-posts'    => '1'
	);
	$single_data = array(
		'thumbnail'      => __('Display thumbnail', 'flatbox'),
		'author-bio'      => __('Display author bio', 'flatbox'),
		'related-posts'    => __('Display related posts', 'flatbox'),
	);
	
	// Typography Defaults
        $typography_defaults = array(
                'size' => '14px',
                'face' => 'Open Sans',
                'style' => 'normal',
                'color' => '#6B6B6B' );

        // Typography Options
        $typography_options = array(
                'sizes' => array( '6','10','12','14','15','16','18','20','24','28','32','36','42','48' ),
                'faces' => array(
													'arial'     => 'Arial',
													'verdana'   => 'Verdana, Geneva',
													'trebuchet' => 'Trebuchet',
													'georgia'   => 'Georgia',
													'times'     => 'Times New Roman',
													'tahoma'    => 'Tahoma, Geneva',
													'Open Sans' 	=> 'Open Sans',
													'palatino'  => 'Palatino',
													'helvetica' => 'Helvetica',
													'Helvetica Neue' => 'Helvetica Neue'
				),
                'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
                'color' => true
        );
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images/';
	
	$radio = array("0" => __('No', 'flatbox'),"1" => __('Yes', 'flatbox'));

	$options = array();
	$options[] = array(
		'name' => __('Basic Settings', 'flatbox'),
		'type' => 'heading');
	$options[] = array(
			'name'      => __('Color scheme', 'flatbox'),
			'desc'      => __('General color scheme.', 'flatbox'),
			'id'        => 'theme_color',
			'std'       => 'default',
			'type'      => 'select',
			'class'     => 'mini',
			'options'   => $color_scheme
		);
		
	$options[] = array(
		'name' => "Theme Layout",
		'desc' => "You can choose your theme layout",
		'id' => "theme_layout",
		'std' => "right-col-fixed",
		'type' => "images",
		'options' => array(
			'one-col-fixed' => $imagepath . '1col.png',
			'left-col-fixed' => $imagepath . '2cl.png',
			'right-col-fixed' => $imagepath . '2cr.png')
	);
	
	$options[] = array( 
        'name'  => __('Custom logo image', 'flatbox'),
        'desc'  => __('You can upload custom image for your website logo (optional).', 'flatbox'),
        'id'    => 'logo_image',
        'type'  => 'upload'
    );    

    $options[] = array( 
        'name'  => __('Custom favicon', 'flatbox'),
        'desc'  => __('Small 16x16px pictures you see beside URL in browser\'s address bar. Image should be named <b>favicon.ico</b>', 'flatbox'),
        'id'    => 'favicon',
        'type'  => 'upload'
    );
	
	$options[] = array(
		'name'      => __('Archive display options', 'flatbox'),
		'id'        => 'meta_data',
		'std'       => $meta_defaults,
		'type'      => 'multicheck',
		'options'   => $meta_data,
    );
	
	$options[] = array(
		'name'      => __('Single display options', 'flatbox'),
		'id'        => 'single_data',
		'std'       => $single_defaults,
		'type'      => 'multicheck',
		'options'   => $single_data,
    );
	
	$options[] = array( 
		'name'		=> __('Enable the users to set color scheme in the front end', 'flatbox'),
		'id'		=> 'set_scheme',
        'desc'		=> __('Setting to "Yes" will show the seting options in the front end.','flatbox'),
		'std' 		=> 1,
		'type' 		=> 'radio',
		'options'	=> $radio
	);
	$options[] = array( 'name' => __('Typography', 'flatbox'),
							'type' => 'heading');

		$options[] = array( 'name' => __('Main Body Text', 'flatbox'),
							'desc' => __('Used in P tags', 'flatbox'),
							'id' => 'main_body_typography',
							'std' => $typography_defaults,
							'type' => 'typography',
							'options' => $typography_options );

		$options[] = array( 'name' => __('Heading Color', 'flatbox'),
							'desc' => __('Color for all headings (h1-h6)', 'flatbox'),
							'id' => 'heading_color',
							'std' => '',
							'type' => 'color');

		$options[] = array( 'name' => __('Link Color', 'flatbox'),
							'desc' => __('Default used if no color is selected', 'flatbox'),
							'id' => 'link_color',
							'std' => '',
							'type' => 'color');

		$options[] = array( 'name' => __('Link:hover Color', 'flatbox'),
							'desc' => __('Default used if no color is selected', 'flatbox'),
							'id' => 'link_hover_color',
							'std' => '',
							'type' => 'color');
	$options[] = array( 'name' => __('Social', 'flatbox'),
							'type' => 'heading');

		$options[] = array(	'name' => __('Add full URL for your social network profiles', 'flatbox'),
        			'desc' => __('Facebook', 'flatbox'),
        			'id' => 'social_facebook',
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

		$options[] = array(	'id' => 'social_twitter',
							'desc' => __('Twitter', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

		$options[] = array(	'id' => 'social_googleplus',
							'desc' => __('Google+', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

		$options[] = array(	'id' => 'social_youtube',
							'desc' => __('Youtube', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

		$options[] = array(	'id' => 'social_linkedin',
							'desc' => __('LinkedIn', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

		$options[] = array(	'id' => 'social_pinterest',
							'desc' => __('Pinterest', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

		$options[] = array(	'id' => 'social_feed',
							'desc' => __('RSS Feed', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

		$options[] = array(	'id' => 'social_tumblr',
							'desc' => __('Tumblr', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

    $options[] = array(	'id' => 'social_flickr',
							'desc' => __('Flickr', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

    $options[] = array(	'id' => 'social_instagram',
							'desc' => __('Instagram', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

    $options[] = array(	'id' => 'social_dribbble',
							'desc' => __('Dribbble', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');

    $options[] = array(	'id' => 'social_skype',
							'desc' => __('Skype', 'flatbox'),
        			'std' => '',
        			'class' => 'mini',
        			'type' => 'text');


		$options[] = array( 'name' => __('Other', 'flatbox'),
							'type' => 'heading');

		$options[] = array( 'name' => __('Custom CSS', 'flatbox'),
							'desc' => __('Additional CSS', 'flatbox'),
							'id' => 'custom_css',
							'std' => '',
							'type' => 'textarea');

	return $options;
}