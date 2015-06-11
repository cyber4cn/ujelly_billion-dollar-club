<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package FlatBox
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
<![endif]-->
<?php if ( of_get_option( 'favicon' ) ) echo '<link rel="shortcut icon" href="'.esc_url( of_get_option( 'favicon' ) ).'" />'; ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site <?php echo of_get_option( 'theme_color'); ?>">
	<header id="masthead" class="site-header" role="banner">
		<div class="site-branding" <?php if ( get_header_image() ) : ?>style="background-image:url(<?php header_image(); ?>); background-repeat:no-repeat; background-position:center top; background-size:100% 100%" <?php endif; ?>>
			<?php if (of_get_option('logo_image')) : ?>
        
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-img"><img src="<?php echo esc_attr( of_get_option('logo_image') ); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
            
			<?php else : ?>

			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			
			<?php endif; ?>
		</div>
		<input type="checkbox" id="primary-menu"/>
		<nav id="site-navigation" class="main-navigation" role="navigation">
			<label for="primary-menu"  class="menu-toggle"><?php _e( 'Menu', 'flatbox' ); ?></label>
			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'flatbox' ); ?></a>

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
	<div id="content" class="site-content <?php echo of_get_option( 'theme_layout'); ?>">
