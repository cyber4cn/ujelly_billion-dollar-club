<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package FlatBox
 */
if ( ! function_exists( 'flatbox_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since FlatBox 1.0
 *
 * @return void
 */
function flatbox_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 4,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'flatbox' ),
		'next_text' => __( 'Next &rarr;', 'flatbox' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<div class="screen-reader-text"><?php _e( 'Posts navigation', 'flatbox' ); ?></div>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;

if ( ! function_exists( 'flatbox_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function flatbox_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="screen-reader-text"><?php _e( 'Post navigation', 'flatbox' ); ?></div>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'flatbox' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link',     'flatbox' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;


if ( ! function_exists( 'flatbox_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function flatbox_posted_on() {

  $time_string = '<span class="posted-on"><i class="genericon genericon-month"></i><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date published" datetime="%3$s">%4$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%5$s">%6$s</time>';
	}
	$time_string .='</a></span>';
	$time_string = sprintf( $time_string,
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

    $author_string = '<span class="byline"> %1$s <span class="author vcard"><a href="%2$s" title="%3$s" rel="author" class="fn">%4$s</a></span></span>';
    
    $author_string = sprintf( $author_string,
        /* translators: this text appears next to author name */
        __( '<i class="genericon genericon-user"></i>', 'flatbox' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'flatbox' ), get_the_author() ) ),
		get_the_author()
    );

    $meta_data = array();

    $post_meta = of_get_option( 'meta_data' );
	
    if ( is_array( $post_meta ) ) {
        $display_author = $post_meta['author'];
        $display_date = $post_meta['date'];
    }
    else {
        $display_author = 1;
        $display_date = 1;
    }

    
    if ( $display_author )
        $meta_data[] = $author_string;

    if ( $display_date )
        $meta_data[] = $time_string;
    
    
    print( implode( '', $meta_data) );
    
}
endif;

function flatbox_part_author_info() {
?>
	<div class="post-author-info">
		<div class="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
		</div><!-- .author-avatar -->
		<div class="author-description">
			<h3 class="author-description-title"><?php printf( esc_attr__( 'About %s', 'flatbox' ), get_the_author() ); ?></h3>
			<p class="author-bio"><?php the_author_meta( 'description' ); ?></p>
			<div class="author-link">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php printf( __( 'View all posts by %s', 'flatbox' ).'<span class="meta-nav">&rarr;</span>', get_the_author() ); ?>
				</a>
			</div><!-- .author-link -->
		</div><!-- .author-description -->
	</div><!-- .post-author-info -->
<?php	
} // flatbox_part_author_info();

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function flatbox_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'flatbox_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'flatbox_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so flatbox_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so flatbox_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in flatbox_categorized_blog.
 */
function flatbox_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'flatbox_categories' );
}
add_action( 'edit_category', 'flatbox_category_transient_flusher' );
add_action( 'save_post',     'flatbox_category_transient_flusher' );
