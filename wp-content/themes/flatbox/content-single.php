<?php
/**
 * @package FlatBox
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php flatbox_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	<?php $post_meta = of_get_option( 'single_data' );

    if ( is_array( $post_meta ) ) {
		$display_thumbnail = $post_meta['thumbnail'];
        $display_author_bio = $post_meta['author-bio'];
		$display_related_posts = $post_meta['related-posts'];
    }
    else {
		$display_thumbnail = 1;
        $display_author_bio = 1;
		$display_related_posts = 1;
    }
	?>
	<?php if ( has_post_thumbnail() && !post_password_required() && $display_thumbnail) : ?>
		<div class="entry-thumbnail"><?php the_post_thumbnail(); ?></div>
  <?php endif; ?>
	<div class="entry-content">
	
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'flatbox' ),
				'after'  => '</div>',
			) );
		?>
		<?php if ( get_the_author_meta( 'description' ) && $display_author_bio ) : ?>
			<?php flatbox_part_author_info(); ?>
		<?php endif; ?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'flatbox' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'flatbox' ) );

			if ( ! flatbox_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( '<i class="genericon genericon-tag"></i> %2$s. <i class="genericon genericon-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.', 'flatbox' );
				} else {
					$meta_text = __( '<i class="genericon genericon-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.', 'flatbox' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( '<i class="genericon genericon-category"></i> %1$s  <i class="genericon genericon-tag"></i> %2$s. <i class="genericon genericon-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.', 'flatbox' );
				} else {
					$meta_text = __( '<i class="genericon genericon-category"></i> %1$s. <i class="genericon genericon-link"></i> <a href="%3$s" rel="bookmark">permalink</a>.', 'flatbox' );
				}

			} // end check for categories on this blog

			printf(
				$meta_text,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( '<i class="genericon genericon-edit"></i> Edit', 'flatbox' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
<?php if ( $display_related_posts ) : ?>
<div class="related">
	<?php require get_template_directory() . '/inc/related.php'; ?>
</div>
<?php endif; ?>

