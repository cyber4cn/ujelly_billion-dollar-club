<?php
/**
 * FlatBox functions and definitions
 *
 * @package FlatBox
 */
define("TPLDIR", get_template_directory_uri());
/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! function_exists( 'flatbox_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function flatbox_setup() {
	
	global $content_width;
	
	if ( ! isset( $content_width ) ) {
		$content_width = 640; /* pixels */
	}
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on FlatBox, use a find and replace
	 * to change 'flatbox' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'flatbox', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( 'editor-style.css' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'flatbox' ),
		'footer' => __( 'Footer Menu', 'flatbox' )
	) );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'flatbox_custom_background_args', array(
		'default-color' => 'E4E4E4',
		'default-image' => '',
	) ) );

	// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
	) );
}
endif; // flatbox_setup
add_action( 'after_setup_theme', 'flatbox_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function flatbox_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'flatbox' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Prefooter Area One', 'flatbox' ),
		'id'            => 'prefooter-1',
        'description'   => 'Widget area above the footer.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );    

	register_sidebar( array(
		'name'          => __( 'Prefooter Area Two', 'flatbox' ),
		'id'            => 'prefooter-2',
        'description'   => 'Widget area above the footer.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );    

	register_sidebar( array(
		'name'          => __( 'Prefooter Area Three', 'flatbox' ),
		'id'            => 'prefooter-3',
        'description'   => 'Widget area above the footer.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );
	
    register_widget( 'flatbox_archives_widget' );
	register_widget( 'flatbox_social_widget' );
}
add_action( 'widgets_init', 'flatbox_widgets_init' );

include( get_template_directory() . '/inc/widgets/archives-widget.php' );
require_once(get_template_directory() . '/inc/widgets/social-widget.php');

function flatbox_prefooter_class() {
	$count = 0;

	if ( is_active_sidebar( 'prefooter-1' ) )
		$count++;

	if ( is_active_sidebar( 'prefooter-2' ) )
		$count++;

	if ( is_active_sidebar( 'prefooter-3' ) )
		$count++;
		
	$class = '';

    if ( $count == 2 ) {
        $class = 'one-half';
    } else if ( $count == 3 ) {
        $class = 'one-third';
	}
    
	if ( $class )
		echo 'class="' . $class . '"';
}

/**
 * Enqueue scripts and styles.
 */
function flatbox_scripts() {
	wp_enqueue_style( 'flatbox-style', get_stylesheet_uri());
	wp_enqueue_style( 'flatbox-icofont', get_template_directory_uri() . '/genericons.css');
	//wp_enqueue_script( 'flatbox-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'flatbox-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	if ( of_get_option( 'set_scheme' ) == 1 ) {
		wp_enqueue_script( 'skin', get_template_directory_uri() . '/js/skin.js', array( 'jquery' ), '1.0', true );
	}
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'flatbox_scripts' );

/**
 * Options Framework
 */
if ( ! function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework.php';
}

// Theme Options sidebar
add_action( 'optionsframework_after','flatbox_options_display_sidebar' );

function flatbox_options_display_sidebar() { ?>
	<div id="optionsframework-sidebar">
		<div class="metabox-holder">
			<div class="postbox">
				<h3><?php _e('Support','flatbox') ?></h3>
					<div class="inside">
                        <p><?php _e('The best way to contact me with <b>support questions</b> and <b>bug reports</b> is via the','flatbox') ?> <a href="http://wordpress.org/support/theme/flatbox"><?php _e('WordPress support forums','corpo') ?></a>.</p>
                        <p><?php _e('If you like this theme, I\'d appreciate if you could ','flatbox') ?>
                        <a href="http://wordpress.org/support/view/theme-reviews/flatbox"><?php _e('rate FlatBox at WordPress.org','flatbox') ?></a><br /><b><?php _e('Thanks!','flatbox'); ?></b></p>
					</div>
			</div>
		</div>
	</div>
<?php }
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
