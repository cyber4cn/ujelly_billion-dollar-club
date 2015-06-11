<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package FlatBox
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function flatbox_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'flatbox_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function flatbox_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'flatbox_body_classes' );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function flatbox_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}
	
	global $page, $paged;

	// Add the blog name
	$title .= get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'flatbox' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'flatbox_wp_title', 10, 2 );

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function flatbox_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'flatbox_setup_author' );

/**
 * function to show the footer info, copyright information
 */
function flatbox_footer_info() {
global $flatbox_footer_info;
  printf( __( 'Theme: %1$s by %2$s, Powered by %3$s', 'flatbox' ) ,'FlatBox', '<a href="'. esc_url( __( 'http://www.wpbars.com/', 'flatbox' ) ).'" target="_blank">Wpbars</a>', '<a href="'. esc_url( __( 'https://wordpress.org/', 'flatbox' ) ).'" target="_blank">WordPress</a>');
}

// //Display social links
function flatbox_social(){
    $services = array ('facebook','twitter','googleplus','youtube','linkedin','pinterest','feed','tumblr','flickr','instagram','dribbble','skype');

    echo '<ul class="social">';

    foreach ( $services as $service ) :

        $active[$service] = of_get_option ('social_'.$service);
        if ($active[$service]) { echo '<li><a href="'. esc_url($active[$service]) .'" title="'. __('Follow us on ','flatbox').$service.'" class="social-icon"><div class="genericon genericon-'.$service.'"></div></a></li>';}

    endforeach;
    echo '</ul>';

}

if (!function_exists('get_flatbox_theme_options'))  {
    function get_flatbox_theme_options(){

      echo '<style type="text/css">';
	  if ( of_get_option('link_color')) {
        echo 'a, #infinite-handle span {color:' . of_get_option('link_color') . '}';
      }
      if ( of_get_option('link_hover_color')) {
        echo 'a:hover, a:active, #secondary .widget a:hover {color: '.of_get_option('link_hover_color').';}';
      }
	  
      if ( of_get_option('heading_color')) {
        echo 'h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .entry-title {color: '.of_get_option('heading_color').';}';
      }


      $typography = of_get_option('main_body_typography');
      if ( $typography ) {
        echo '.entry-content {font-family: ' . $typography['face'] . '; font-size:' . $typography['size'] . '; font-weight: ' . $typography['style'] . '; color:'.$typography['color'] . ';}';
      }
      if ( of_get_option('custom_css')) {
        echo of_get_option( 'custom_css', 'no entry' );
      }
        echo '</style>';
    }
}
add_action('wp_head','get_flatbox_theme_options',10);
