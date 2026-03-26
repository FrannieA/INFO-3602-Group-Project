<?php

/**
 * Custom template tags for this theme
 *
 * @package recipes_blog
 */

 if ( ! function_exists( 'recipes_blog_posted_on_single' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time on single posts.
     */
    function recipes_blog_posted_on_single() {
        if ( get_theme_mod( 'recipes_blog_single_post_hide_date', true ) ) {
                $recipes_blog_time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
            if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                $recipes_blog_time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }

            $recipes_blog_time_string = sprintf(
                $recipes_blog_time_string,
                esc_attr( get_the_date( DATE_W3C ) ),
                esc_html( get_the_date() ),
                esc_attr( get_the_modified_date( DATE_W3C ) ),
                esc_html( get_the_modified_date() )
            );

            // Get the user-selected icon from theme mod
            $recipes_blog_post_date_icon = get_theme_mod('recipes_blog_post_date_icon', 'far fa-clock');

            // Output post date with dynamic icon
            $recipes_blog_posted_on = '<span class="post-date">
                <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">
                    <i class="' . esc_attr( $recipes_blog_post_date_icon ) . '"></i> ' . $recipes_blog_time_string . '
                </a>
            </span>';
    
            echo $recipes_blog_posted_on; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            return;
        }
    }
endif;

if ( ! function_exists( 'recipes_blog_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function recipes_blog_posted_on() {
        if ( get_theme_mod( 'recipes_blog_post_hide_date', true ) ) {
            $recipes_blog_time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
            if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                $recipes_blog_time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
            }
    
            $recipes_blog_time_string = sprintf(
                $recipes_blog_time_string,
                esc_attr( get_the_date( DATE_W3C ) ),
                esc_html( get_the_date() ),
                esc_attr( get_the_modified_date( DATE_W3C ) ),
                esc_html( get_the_modified_date() )
            );

            // Get the user-selected icon from theme mod
            $recipes_blog_post_date_icon = get_theme_mod('recipes_blog_post_date_icon', 'far fa-clock');

            // Output post date with dynamic icon
            $recipes_blog_posted_on = '<span class="post-date">
                <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">
                    <i class="' . esc_attr( $recipes_blog_post_date_icon ) . '"></i> ' . $recipes_blog_time_string . '
                </a>
            </span>';
    
            echo $recipes_blog_posted_on; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            return;
        }
    }
endif;

if ( ! function_exists( 'recipes_blog_posted_by_single' ) ) :
    /**
     * Prints HTML with meta information for the current author on single posts.
     */
    function recipes_blog_posted_by_single() {
        if ( get_theme_mod( 'recipes_blog_single_post_hide_author', true ) ) {
            // Get the custom author icon from the Customizer
            $recipes_blog_post_author_icon = get_theme_mod( 'recipes_blog_post_author_icon', 'fas fa-user' );

            $recipes_blog_byline = '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">
                <i class="' . esc_attr( $recipes_blog_post_author_icon ) . '"></i> ' . esc_html( get_the_author() ) . '
            </a>';

            echo '<span class="post-author">' . $recipes_blog_byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            return;
        }
    }
endif;

if ( ! function_exists( 'recipes_blog_posted_by' ) ) :
    /**
     * Prints HTML with meta information for the current author.
     */
    function recipes_blog_posted_by() {
        if ( get_theme_mod( 'recipes_blog_post_hide_author', true ) ) {
            // Get the custom author icon from the Customizer
            $recipes_blog_post_author_icon = get_theme_mod( 'recipes_blog_post_author_icon', 'fas fa-user' );

            $recipes_blog_byline = '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">
                <i class="' . esc_attr( $recipes_blog_post_author_icon ) . '"></i> ' . esc_html( get_the_author() ) . '
            </a>';

            echo '<span class="post-author">' . $recipes_blog_byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            return;
        }
    }
endif;

if ( ! function_exists( 'recipes_blog_posted_comments_single' ) ) :
    /**
     * Prints HTML with meta information for the current comment count on single posts.
     */
    function recipes_blog_posted_comments_single() {
        if ( get_theme_mod( 'recipes_blog_single_post_hide_comments', true ) ) {
            $recipes_blog_comment_count = get_comments_number();
            $recipes_blog_comment_text  = sprintf(
                /* translators: %s: comment count */
                _n( '%s Comment', '%s Comments', $recipes_blog_comment_count, 'recipes-blog' ),
                number_format_i18n( $recipes_blog_comment_count )
            );

           // Get the custom comments icon from the Customizer, defaulting to 'fas fa-comments'
           $recipes_blog_post_comments_icon = get_theme_mod( 'recipes_blog_post_comments_icon', 'fas fa-comments' );

           echo '<span class="post-comments">
               <i class="' . esc_attr( $recipes_blog_post_comments_icon ) . '"></i> ' . esc_html( $recipes_blog_comment_text ) . '
           </span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
           return;
        }
    }
endif;

if ( ! function_exists( 'recipes_blog_posted_comments' ) ) :
    /**
     * Prints HTML with meta information for the current comment count.
     */
    function recipes_blog_posted_comments() {
        if ( get_theme_mod( 'recipes_blog_post_hide_comments', true ) ) {
            $recipes_blog_comment_count = get_comments_number();
            $recipes_blog_comment_text  = sprintf(
                /* translators: %s: comment count */
                _n( '%s Comment', '%s Comments', $recipes_blog_comment_count, 'recipes-blog' ),
                number_format_i18n( $recipes_blog_comment_count )
            );

            // Get the custom comments icon from the Customizer, defaulting to 'fas fa-comments'
            $recipes_blog_post_comments_icon = get_theme_mod( 'recipes_blog_post_comments_icon', 'fas fa-comments' );

            echo '<span class="post-comments">
                <i class="' . esc_attr( $recipes_blog_post_comments_icon ) . '"></i> ' . esc_html( $recipes_blog_comment_text ) . '
            </span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            return;
        }
    }
endif;

if ( ! function_exists( 'recipes_blog_posted_time_single' ) ) :
    /**
     * Prints HTML with meta information for the current post time on single posts.
     */
    function recipes_blog_posted_time_single() {
        if ( get_theme_mod( 'recipes_blog_single_post_hide_time', true ) ) {
            // Get the custom post time icon from the Customizer, defaulting to 'fas fa-clock'
            $recipes_blog_post_time_icon = get_theme_mod( 'recipes_blog_post_time_icon', 'fas fa-clock' );

            $recipes_blog_posted_on = sprintf(
                /* translators: %s: post time */
                esc_html__( 'Posted at %s', 'recipes-blog' ),
                '<a href="' . esc_url( get_permalink() ) . '"><time datetime="' . esc_attr( get_the_time( 'c' ) ) . '">' . esc_html( get_the_time() ) . '</time></a>'
            );

            echo '<span class="post-time"><i class="' . esc_attr( $recipes_blog_post_time_icon ) . '"></i> ' . $recipes_blog_posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            return;
        }
    }
endif;

if ( ! function_exists( 'recipes_blog_posted_time' ) ) :
    /**
     * Prints HTML with meta information for the current post time.
     */
    function recipes_blog_posted_time() {
        if ( get_theme_mod( 'recipes_blog_post_hide_time', true ) ) {
            // Get the custom post time icon from the Customizer, defaulting to 'fas fa-clock'
            $recipes_blog_post_time_icon = get_theme_mod( 'recipes_blog_post_time_icon', 'fas fa-clock' );
            
            $recipes_blog_posted_on = sprintf(
                /* translators: %s: post time */
                esc_html__( 'Posted at %s', 'recipes-blog' ),
                '<a href="' . esc_url( get_permalink() ) . '"><time datetime="' . esc_attr( get_the_time( 'c' ) ) . '">' . esc_html( get_the_time() ) . '</time></a>'
            );

            echo '<span class="post-time"><i class="' . esc_attr( $recipes_blog_post_time_icon ) . '"></i> ' . $recipes_blog_posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            return;
        }
    }
endif;

	/**
	 * Prints HTML with meta information for the categories.
	 */

if ( ! function_exists( 'recipes_blog_categories_single_list' ) ) :
    function recipes_blog_categories_single_list( $with_background = false ) {
        if ( is_singular( 'post' ) ) {
            $recipes_blog_hide_category = get_theme_mod( 'recipes_blog_single_post_hide_category', true );

            if ( $recipes_blog_hide_category ) {
                $recipes_blog_categories = get_the_category();
                $recipes_blog_separator  = '';
                $recipes_blog_output     = '';
                if ( ! empty( $recipes_blog_categories ) ) {
                    foreach ( $recipes_blog_categories as $recipes_blog_category ) {
                        $recipes_blog_output .= '<a href="' . esc_url( get_category_link( $recipes_blog_category->term_id ) ) . '">' . esc_html( $recipes_blog_category->name ) . '</a>' . $recipes_blog_separator;
                    }
                    echo trim( $recipes_blog_output, $recipes_blog_separator );
                }
            }
        }
    }
endif;

if ( ! function_exists( 'recipes_blog_categories_list' ) ) :
    function recipes_blog_categories_list( $with_background = false ) {
        $recipes_blog_hide_category = get_theme_mod( 'recipes_blog_post_hide_category', true );

        if ( $recipes_blog_hide_category ) {
            $recipes_blog_categories = get_the_category();
            $recipes_blog_separator  = '';
            $recipes_blog_output     = '';
            if ( ! empty( $recipes_blog_categories ) ) {
                foreach ( $recipes_blog_categories as $recipes_blog_category ) {
                    $recipes_blog_output .= '<a href="' . esc_url( get_category_link( $recipes_blog_category->term_id ) ) . '">' . esc_html( $recipes_blog_category->name ) . '</a>' . $recipes_blog_separator;
                }
                echo trim( $recipes_blog_output, $recipes_blog_separator );
            }
        }
    }
endif;

if ( ! function_exists( 'recipes_blog_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the tags and comments.
	 */
	function recipes_blog_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() && is_singular() ) {
			$recipes_blog_hide_tag = get_theme_mod( 'recipes_blog_post_hide_tags', true );

			if ( $recipes_blog_hide_tag ) {
				/* translators: used between list items, there is a space after the comma */
				$recipes_blog_tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'recipes-blog' ) );
				if ( $recipes_blog_tags_list ) {
					/* translators: 1: list of tags. */
					printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'recipes-blog' ) . '</span>', $recipes_blog_tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'recipes-blog' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'recipes_blog_post_thumbnail' ) ) :
    /**
     * Display the post thumbnail.
     */
    function recipes_blog_post_thumbnail() {
        // Return early if the post is password protected, an attachment, or does not have a post thumbnail.
        if ( post_password_required() || is_attachment() ) {
            return;
        }

        // Display post thumbnail for singular views.
        if ( is_singular() ) :
            // Check theme setting to hide the featured image in single posts.
            if ( get_theme_mod( 'recipes_blog_single_post_hide_feature_image', false ) ) {
                return;
            }
            ?>
            <div class="post-thumbnail">
                <?php 
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail(); 
                } else {
                    // URL of the default image
                    $recipes_blog_default_image_url = get_template_directory_uri() . '/resource/img/default.png';
                    echo '<img src="' . esc_url( $recipes_blog_default_image_url ) . '" alt="' . esc_attr( get_the_title() ) . '">';
                }
                ?>
            </div><!-- .post-thumbnail -->
        <?php else :
            // Check theme setting to hide the featured image in non-singular posts.
            if ( !get_theme_mod( 'recipes_blog_post_hide_feature_image', true ) ) {
                return;
            }
            ?>
            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
                <?php
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail(
                        'post-thumbnail',
                        array(
                            'alt' => the_title_attribute(
                                array(
                                    'echo' => false,
                                )
                            ),
                        )
                    );
                } else {
                    // URL of the default image
                    $recipes_blog_default_image_url = get_template_directory_uri() . '/resource/img/default.png';
                    echo '<img src="' . esc_url( $recipes_blog_default_image_url ) . '" alt="' . esc_attr( get_the_title() ) . '">';
                }
                ?>
            </a>
        <?php endif; // End is_singular().
    }
endif;


if ( ! function_exists( 'wp_body_open' ) ) :
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;