<?php
/**
 * sponsor-panels-widget-item,.php
 *
 * HTML for a sponsor panels widget item.
 *
 * @since 1.0.0
 */
?>
<div id="<?php the_ID(); ?>" class="sponsor-panel <?php echo $level; ?>-sponsor">
    <a href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ): ?>
			<?php the_post_thumbnail( 'sponsor-panel-logo' ); ?>
		<?php endif; ?>
		<?php the_title( '<h3 class="sponsor-name">', '</h3>' ); ?>
    </a>
</div>