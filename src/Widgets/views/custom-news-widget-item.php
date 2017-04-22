<?php
/**
 * custom-news-widget-item.php
 *
 * HTML for a custom news widget news item.
 *
 * @since 1.0.0
 */
?>
<div id="<?php the_ID(); ?>" class="custom-news-entry-content">
	<?php the_title( '<h3 class="news-title">', '</h3>' ); ?>
	<?php if ( has_post_thumbnail() ): ?>
		<?php the_post_thumbnail( 'custom-news' ); ?>
	<?php endif; ?>
    <h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <div class="news-excerpt">
		<?php the_excerpt(); ?>
    </div>
    <div class="read-more"><a href="<?php the_permalink(); ?>">Click here to learn more.</a></div>
</div>