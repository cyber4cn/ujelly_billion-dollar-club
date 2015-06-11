<?php
/**
 * @package FlatBox
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
	<?php if(is_single()): ?>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	<?php else: ?>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	<?php endif; ?>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php flatbox_posted_on(); ?>
		</div><!-- .entry-meta -->		
		<?php endif; ?>
	</header><!-- .entry-header -->
	<?php $post_meta = of_get_option( 'meta_data' );

    if ( is_array( $post_meta ) ) {
		$display_excerpt = $post_meta['content'];
		$display_thumbnail = $post_meta['thumbnail'];
        //$display_author = $post_meta['author'];
        //$display_date = $post_meta['date'];
        $display_comments = $post_meta['comments'];
		$display_categories = $post_meta['categories'];
		$display_tags = $post_meta['tags'];
    }
    else {
		$display_excerpt = 1;
		$display_thumbnail = 1;
        //$display_author = 1;
        //$display_date = 1;
        $display_comments = 1;
		$display_categories = 1;
		$display_tags = 1;
    }
	?>
  <?php if ( has_post_thumbnail() && ! post_password_required() &&  $display_thumbnail ) : ?>
    <div class="entry-thumbnail"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'flatbox' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_post_thumbnail(); ?></a></div>
  <?php endif; ?>
	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
  <?php if( $display_excerpt) { ?>
	<div class="entry-summary"><?php the_excerpt(); ?></div>
	<?php } else { ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'flatbox' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'flatbox' ),
				'after'  => '</div>',
			) );
		?>
	</div>
  <?php }?>
	<!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'flatbox' ) );
				if ( $categories_list && flatbox_categorized_blog() && $display_categories) :
			?>
			<span class="cat-links">
				<?php printf( __( '<i class="genericon genericon-category"></i> %1$s', 'flatbox' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'flatbox' ) );
				if ( $tags_list && $display_tags) :
			?>
			<span class="tags-links">
				<?php printf( __( '<i class="genericon genericon-tag"></i> %1$s', 'flatbox' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) && $display_comments ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( '<i class="genericon genericon-comment"></i> 0', 'flatbox' ), __( '<i class="genericon genericon-comment"></i> 1', 'flatbox' ), __( '<i class="genericon genericon-comment"></i> %', 'flatbox' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( '<i class="genericon genericon-edit"></i> Edit', 'flatbox' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
