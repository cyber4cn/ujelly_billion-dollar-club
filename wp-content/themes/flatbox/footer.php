<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package FlatBox
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( is_active_sidebar('prefooter-1') || is_active_sidebar('prefooter-2') || is_active_sidebar('prefooter-3') ) : ?>
            <div id="prefooter">
                <div id="prefooter-inner" class="row">

                <?php if ( is_active_sidebar( 'prefooter-1' ) ) : ?>
                <div <?php flatbox_prefooter_class(); ?> role="complementary">
                    <?php dynamic_sidebar( 'prefooter-1' ); ?>
                </div><!-- #first .widget-area -->
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'prefooter-2' ) ) : ?>
                <div <?php flatbox_prefooter_class(); ?> role="complementary">
                    <?php dynamic_sidebar( 'prefooter-2' ); ?>
                </div><!-- #second .widget-area -->
                <?php endif; ?>

                <?php if ( is_active_sidebar( 'prefooter-3' ) ) : ?>
                <div <?php flatbox_prefooter_class(); ?> role="complementary">
                    <?php dynamic_sidebar( 'prefooter-3' ); ?>
                </div><!-- #third .widget-area -->
                <?php endif; ?>
                                
                </div>
            </div><!-- #prefooter -->
        <?php endif; ?>
		<div class="site-info<?php if(has_nav_menu('footer')) echo' has-footer-menu'; ?>">
			<?php 
				if(has_nav_menu('footer')){
					wp_nav_menu( array( 
						'theme_location'=> 'footer', 
						'container'     => false,
						'menu_class'     => 'footer-nav',
						'menu_id'       => 'footer-nav',
						'fallback_cb'   => 'wp_page_menu' ,
						'depth'         => 1
					) ); 
				}
			?>
			<?php flatbox_footer_info(); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	<p class="back-top" id="backTop"><a href="#top" rel="nofollow"></a></p>
	<?php if(of_get_option('set_scheme') == 1) : ?>
	<input type="checkbox" id="themeSwitchBtn"/>
	<div class="theme-switch" id="themeSwithc">
	<div class="theme-color">
	<p><?php _e( 'Theme Layout', 'flatbox' ); ?></p>
	<ul class="theme-layout clearfix">
	<li class="layout-one-col-fixed" rel="one-col-fixed"></li>
	<li class="layout-left-col-fixed" rel="left-col-fixed"><span></span></li>
	<li class="layout-right-col-fixed current" rel="right-col-fixed"><span></span></li>
	</ul>
	<p><?php _e( 'Color Scheme', 'flatbox' ); ?></p>
	<ul class="theme-scheme clearfix">
	<li class="color-default current" rel="default"></li>
	<li class="color-light" rel="light"></li>
	<li class="color-blue" rel="blue"></li>
	<li class="color-coffee" rel="coffee"></li>
	<li class="color-ectoplasm" rel="ectoplasm"></li>
	<li class="color-midnight" rel="midnight"></li>
	<li class="color-ocean" rel="ocean"></li>
	<li class="color-sunrise" rel="sunrise"></li>
	</ul>
	</div>
	<label class="theme-switch-btn" for="themeSwitchBtn"></label>
	</div>
	<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
