<?php

/**
 * Template part for displaying Video Format
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package recipes_blog
 */

?>
<?php $recipes_blog_readmore = get_theme_mod( 'recipes_blog_readmore_button_text','Read More');?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mag-post-single">
        <?php
			// Get the post ID
			$recipes_blog_post_id = get_the_ID();

			// Check if there are videos embedded in the post content
			$recipes_blog_post = get_post($recipes_blog_post_id);
			$recipes_blog_content = do_shortcode(apply_filters('the_content', $recipes_blog_post->post_content));
			$recipes_blog_embeds = get_media_embedded_in_content($recipes_blog_content);

			if (!empty($recipes_blog_embeds)) {
			    // Loop through embedded media and display videos
			    foreach ($recipes_blog_embeds as $recipes_blog_embed) {
			        // Check if the embed code contains a video tag or specific video providers like YouTube or Vimeo
			        if (strpos($recipes_blog_embed, 'video') !== false || strpos($recipes_blog_embed, 'youtube') !== false || strpos($recipes_blog_embed, 'vimeo') !== false || strpos($recipes_blog_embed, 'dailymotion') !== false || strpos($recipes_blog_embed, 'vine') !== false || strpos($recipes_blog_embed, 'wordPress.tv') !== false || strpos($recipes_blog_embed, 'hulu') !== false) {
			            ?>
			            <div class="custom-embedded-video">
			                <div class="video-container">
			                    <?php echo $recipes_blog_embed; ?>
			                </div>
			                <div class="video-comments">
			                    <?php
			                    // Add your comments section here
			                    comments_template(); // This will include the default WordPress comments template
			                    ?>
			                </div>
			            </div>
			            <?php
			        }
			    }
			}
	    ?>
		<div class="mag-post-detail">
			<div class="mag-post-category">
				<?php recipes_blog_categories_list(); ?>
			</div>
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title mag-post-title">', '</h1>' );
			else :
				if ( get_theme_mod( 'recipes_blog_post_hide_post_heading', true ) ) { 
					the_title( '<h2 class="entry-title mag-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			    }
			endif;
			?>
			<div class="mag-post-meta">
				<?php
				recipes_blog_posted_on();
				recipes_blog_posted_by();
				recipes_blog_posted_comments();
				recipes_blog_posted_time();
				?>
			</div>
			<?php if ( get_theme_mod( 'recipes_blog_post_hide_post_content', true ) ) { ?>
				<div class="mag-post-excerpt">
					<?php the_excerpt(); ?>
				</div>
		    <?php } ?>
			<?php if ( get_theme_mod( 'recipes_blog_post_readmore_button', true ) === true ) : ?>
				<div class="mag-post-read-more">
					<a href="<?php the_permalink(); ?>" class="read-more-button">
						<?php if ( ! empty( $recipes_blog_readmore ) ) { ?> <?php echo esc_html( $recipes_blog_readmore ); ?> <?php } ?>
						<i class="<?php echo esc_attr( get_theme_mod( 'recipes_blog_readmore_btn_icon', 'fas fa-chevron-right' ) ); ?>"></i>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->