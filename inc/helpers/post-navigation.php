<?php
/**
 * Post navigation helpers
 *
 * @package vogue
 * @since 1.0.0
 */

if ( ! function_exists( 'presscore_get_next_post_link' ) ) :

	function presscore_get_next_post_link( $link_text = '', $link_class = '', $dummy = '' ) {
		$post_link = get_next_post_link( '%link', $link_text );
		if ( $post_link ) {
			return str_replace( 'href=', 'class="'. esc_attr( $link_class ) . '" href=', $post_link );
		}

		return $dummy;
	}

endif;

if ( ! function_exists( 'presscore_get_previous_post_link' ) ) :

	function presscore_get_previous_post_link( $link_text = '', $link_class = '', $dummy = '' ) {
		$post_link = get_previous_post_link( '%link', $link_text );
		if ( $post_link ) {
			return str_replace( 'href=', 'class="'. esc_attr( $link_class ) . '" href=', $post_link );
		}

		return $dummy;
	}

endif;

if ( ! function_exists( 'presscore_get_post_back_link' ) ) :

	function presscore_get_post_back_link( $text = '' ) {
		$url = apply_filters( 'presscore_post_back_link_url', presscore_config()->get( 'post.navigation.back_button.url' ) );
		if ( $url ) {
			return '<a class="back-to-list" href="' . esc_url( $url ) . '">' . $text . '</a>';
		}

		return '';
	}

endif;

if ( ! function_exists( 'presscore_new_post_navigation' ) ) :

	function presscore_new_post_navigation( $args = array() ) {
		if ( ! in_the_loop() ) {
			return '';
		}

		$defaults = array(
			'prev_src_text'          => __( 'Previous post:', 'the7mk2' ),
			'next_src_text'          => __( 'Next post:', 'the7mk2' ),
			'in_same_term'       => false,
			'excluded_terms'     => '',
			'taxonomy'           => 'category',
			'screen_reader_text' => __( 'Post navigation', 'the7mk2' ),
		);
		$args = wp_parse_args( $args, $defaults );

		$config = presscore_config();
		$output = '';

		if ( $config->get( 'post.navigation.arrows.enabled' ) ) {
			$prev_text = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;" xml:space="preserve"><path class="st0" d="M11.4,1.6c0.2,0.2,0.2,0.5,0,0.7c0,0,0,0,0,0L5.7,8l5.6,5.6c0.2,0.2,0.2,0.5,0,0.7s-0.5,0.2-0.7,0l-6-6c-0.2-0.2-0.2-0.5,0-0.7c0,0,0,0,0,0l6-6C10.8,1.5,11.2,1.5,11.4,1.6C11.4,1.6,11.4,1.6,11.4,1.6z"/></svg>' .
			             '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'the7mk2' ) . '</span>' .
			             '<span class="screen-reader-text">' . esc_html( $args['prev_src_text'] ) . '</span>' .
			             '<span class="post-title h4-size">%title</span>';

			// We use opposite order.
			$prev_link = get_previous_post_link(
				'%link',
				$prev_text,
				$args['in_same_term'],
				$args['excluded_terms'],
				$args['taxonomy']
			);
			$prev_link = str_replace( '<a', '<a class="nav-previous"', $prev_link );

			if ( ! $prev_link ) {
				$prev_link = '<span class="nav-previous disabled"></span>';
			}

			$output .= $prev_link;
		}

		if ( $config->get( 'post.navigation.back_button.enabled' ) ) {
			$output .= presscore_get_post_back_link( '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;" xml:space="preserve"><path d="M1,2c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1H2C1.4,5,1,4.6,1,4V2z M6,2c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1H7C6.4,5,6,4.6,6,4V2z M11,2c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1h-2c-0.6,0-1-0.4-1-1V2z M1,7c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1H2c-0.6,0-1-0.4-1-1V7z M6,7c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1H7c-0.6,0-1-0.4-1-1V7z M11,7c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1h-2c-0.6,0-1-0.4-1-1V7z M1,12c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1H2c-0.6,0-1-0.4-1-1V12z M6,12c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1H7c-0.6,0-1-0.4-1-1V12z M11,12c0-0.6,0.4-1,1-1h2c0.6,0,1,0.4,1,1v2c0,0.6-0.4,1-1,1h-2c-0.6,0-1-0.4-1-1V12z"/></svg>' );
		}

		if ( $config->get( 'post.navigation.arrows.enabled' ) ) {
			$next_text = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;" xml:space="preserve"><path class="st0" d="M4.6,1.6c0.2-0.2,0.5-0.2,0.7,0c0,0,0,0,0,0l6,6c0.2,0.2,0.2,0.5,0,0.7c0,0,0,0,0,0l-6,6c-0.2,0.2-0.5,0.2-0.7,0s-0.2-0.5,0-0.7L10.3,8L4.6,2.4C4.5,2.2,4.5,1.8,4.6,1.6C4.6,1.6,4.6,1.6,4.6,1.6z"/></svg>' .
			             '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'the7mk2' ) . '</span>' .
			             '<span class="screen-reader-text">' . esc_html( $args['next_src_text'] ) . '</span>' .
			             '<span class="post-title h4-size">%title</span>';

			// We use opposite order.
			$next_link = get_next_post_link(
				'%link',
				$next_text,
				$args['in_same_term'],
				$args['excluded_terms'],
				$args['taxonomy']
			);
			$next_link = str_replace( '<a', '<a class="nav-next"', $next_link );

			if ( ! $next_link ) {
				$next_link = '<span class="nav-next disabled"></span>';
			}

			$output .= $next_link;
		}

		if ( $output ) {
			$nav_class = array(
				'navigation',
				'post-navigation',
			);

			if ( ! $config->get( 'post.navigation.arrows.enabled' ) ) {
				$nav_class[] = 'disabled-post-navigation';
			}

			$output = '<nav class="' . esc_attr( implode( ' ', $nav_class ) ) . '" role="navigation"><h2 class="screen-reader-text">' . esc_html( $args['screen_reader_text'] ) . '</h2><div class="nav-links">' . $output . '</div></nav>';
		}

		return $output;
	}

endif;


//add_action( 'presscore_before_content', 'presscore_single_post_navigation_bar', 20 );

if ( ! function_exists( 'dt_get_next_page_button' ) ) :

	/**
	 * Return next page button HTML.
	 *
	 * @param int      $max
	 * @param string   $class
	 * @param int|null $cur_page
	 *
	 * @return string
	 */
	function dt_get_next_page_button( $max, $class = '', $cur_page = null, $button_class = '', $caption = null, $icon = null, $icon_position = 'before' ) {
		if ( ! dt_get_next_posts_url( $max, $cur_page ) ) {
			return '';
		}

		if ( $cur_page === null ) {
			$cur_page = the7_get_paged_var();
		}

		$button_html_class = 'button-load-more ' . $button_class;
		$caption = $caption !== null ? $caption : __( 'Load more', 'the7mk2' );
		if ( presscore_is_lazy_loading() ) {
			$button_html_class .= ' button-lazy-loading';
			$caption = __( 'Loading...', 'the7mk2' );
		}
		$caption = apply_filters( 'dt_get_next_page_button-caption', $caption );
		$class = apply_filters( 'dt_get_next_page_button-wrap_class', $class );

		if ( $icon === null ) {
			$icon = '<span class="stick"></span><span class="stick"></span><span class="stick"></span>';
		}

		$button_caption_tag = '<span class="button-caption">' . esc_html( $caption ) . '</span>';

		if ( $icon_position === 'after' ) {
			$button_caption_tag .= $icon;
		} else {
			$button_caption_tag = $icon . $button_caption_tag;
		}

		return '<div class="' . esc_attr( $class ) . '">
				<a class="' . esc_attr( $button_html_class ) . '" href="javascript:void(0);" data-dt-page="' . esc_attr( $cur_page ) . '" >' . $button_caption_tag . '</a>
			</div>';
	}

endif;

if ( ! function_exists( 'presscore_get_breadcrumbs' ) ) :

	/**
	 * Returns breadcrumbs html
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 *
	 * @return string Breadcrumbs html
	 */
	function presscore_get_breadcrumbs( $args = array() ) {
		global $post, $author;

		$default_args = array(
			'text'              => array(
				'home'     => __( 'Home', 'the7mk2' ),
				'category' => __( 'Category "%s"', 'the7mk2' ),
				'search'   => __( 'Results for "%s"', 'the7mk2' ),
				'tag'      => __( 'Entries tagged with "%s"', 'the7mk2' ),
				'author'   => __( 'Article author %s', 'the7mk2' ),
				'404'      => __( 'Error 404', 'the7mk2' ),
			),
			'showCurrent'       => true,
			'showOnHome'        => true,
			'delimiter'         => '',
			'before'            => '<li class="current" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">',
			'after'             => '</li>',
			'linkBefore'        => '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">',
			'linkAfter'         => '</li>',
			'linkAttr'          => ' itemprop="item"',
			'beforeBreadcrumbs' => '',
			'afterBreadcrumbs'  => '',
			'listAttr'          => ' class="breadcrumbs text-small"',
			'itemMaxChrCount'   => null,
		);

		$args = wp_parse_args( $args, $default_args );

		$breadcrumbs_html = apply_filters( 'presscore_get_breadcrumbs-html', '', $args );
		if ( $breadcrumbs_html ) {
			return $breadcrumbs_html;
		}

		$array_intersect_key = array_intersect_key( $args, $default_args );
		extract( $array_intersect_key, EXTR_OVERWRITE );

		$current_words_num = apply_filters( 'presscore_get_breadcrumbs-current_words_num', 5 );

		$breadcrumbs_parts = array();

		$is_front = is_home() || is_front_page();

		if ( ( $showOnHome && $is_front ) || ! $is_front ) {

			$breadcrumbs_parts[] = array(
				'name' => $text['home'],
				'url'  => trailingslashit( home_url() ),
			);

		}

		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() && class_exists( '\WC_Breadcrumb' ) ) {
			$wc_breadcrumbs      = new \WC_Breadcrumb();
			$wc_breadcrumbs_list = $wc_breadcrumbs->generate();
			$the_last_index      = count( $wc_breadcrumbs_list ) - 1;

			// Remove the last link.
			if ( isset( $wc_breadcrumbs_list[ $the_last_index ] ) ) {
				$wc_breadcrumbs_list[ $the_last_index ][1] = null;
			}

			foreach ( $wc_breadcrumbs_list as $i => $crumb ) {
				$breadcrumbs_parts[] = array(
					'name' => $crumb[0],
					'url'  => $crumb[1],
				);
			}
		} elseif ( is_category() ) {

			$thisCat = get_category( get_query_var( 'cat' ), OBJECT );

			if ( $thisCat && ! is_wp_error( $thisCat ) && $thisCat->parent !== 0 ) {
				$taxonomy = 'category';
				$parents = get_ancestors( $thisCat->parent, $taxonomy, 'taxonomy' );
				array_unshift( $parents, $thisCat->parent );

				foreach ( array_reverse( $parents ) as $term_id ) {
					$parent_cat = get_term( $term_id, $taxonomy );
					if ( $parent_cat && ! is_wp_error( $parent_cat ) ) {
						$name                = $parent_cat->name;
						$breadcrumbs_parts[] = array(
							'name' => $name,
							'url'  => get_term_link( $parent_cat->term_id, $taxonomy ),
						);
					}
				}

			}

			$breadcrumbs_parts[] = array(
				'name' => sprintf( $text['category'], single_cat_title( '', false ) ),
			);

		} elseif ( is_author() ) {

			$userdata            = get_userdata( $author );
			if ( $userdata ) {
				$breadcrumbs_parts[] = array(
					'name' => sprintf( $text['author'], $userdata->display_name ),
				);
			}

		} elseif ( is_search() ) {

			$breadcrumbs_parts[] = array(
				'name' => sprintf( $text['search'], get_search_query() ),
			);

		} elseif ( is_day() ) {

			$breadcrumbs_parts[] = array(
				'name' => get_the_time( 'Y' ),
				'url'  => get_year_link( get_the_time( 'Y' ) ),
			);
			$breadcrumbs_parts[] = array(
				'name' => get_the_time( 'F' ),
				'url'  => get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
			);
			$breadcrumbs_parts[] = array(
				'name' => get_the_time( 'd' ),
			);

		} elseif ( is_month() ) {

			$breadcrumbs_parts[] = array(
				'name' => get_the_time( 'Y' ),
				'url'  => get_year_link( get_the_time( 'Y' ) ),
			);
			$breadcrumbs_parts[] = array(
				'name' => get_the_time( 'F' ),
			);

		} elseif ( is_year() ) {

			$breadcrumbs_parts[] = array(
				'name' => get_the_time( 'Y' ),
			);

		} elseif ( is_single() && !is_attachment() ) {

			$post_type = get_post_type();
			$post_type_obj = get_post_type_object( $post_type );

			if ( $post_type === 'post' ) {
				$cat = get_the_category();
				if ( $cat ) {
					$term_id = $cat[0]->term_id;
					$taxonomy = 'category';
					$parents = get_ancestors( $term_id, $taxonomy, 'taxonomy' );
					array_unshift( $parents, $term_id );

					foreach ( array_reverse( $parents ) as $term_id ) {
						$parent_cat = get_term( $term_id, $taxonomy, OBJECT );
						if ( $parent_cat && ! is_wp_error( $parent_cat ) ) {
							$name                = $parent_cat->name;
							$breadcrumbs_parts[] = array(
								'name' => $name,
								'url'  => get_term_link( $parent_cat->term_id, $taxonomy ),
							);
						}
					}
				}
			} elseif ( $post_type_obj ) {
				$post_type_name = $post_type_obj->labels->singular_name;

				if ( $post_type === 'dt_portfolio' ) {
					$post_type_name = the7_get_portfolio_breadcrumbs_text( $post_type_name );
				}

				$breadcrumbs_parts[] = array(
					'name' => esc_html( $post_type_name ),
					'url'  => get_post_type_archive_link( $post_type ),
				);
			}

			if ( $showCurrent ) {
				$breadcrumbs_parts[] = array(
					'name' => wp_trim_words( get_the_title(), $current_words_num ),
				);
			}

		} elseif ( ! is_single() && ! is_page() && get_post_type() !== 'post' && ! is_404() ) {

			$post_type = get_post_type();
			$post_type_obj = get_post_type_object( $post_type );

			if ( $post_type_obj ) {
				$post_type_name = $post_type_obj->labels->singular_name;

				if ( $post_type === 'dt_portfolio' ) {
					$post_type_name = the7_get_portfolio_breadcrumbs_text( $post_type_name );
				}

				$breadcrumbs_parts[] = array(
					'name' => esc_html( $post_type_name ),
				);
			}

		} elseif ( is_attachment() ) {

			if ( $showCurrent ) {
				$breadcrumbs_parts[] = array(
					'name' => wp_trim_words( get_the_title(), $current_words_num ),
				);
			}

		} elseif ( is_page() && ! $is_front) {

			if ( $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$page_breadcrumbs = array();

				while ( $parent_id ) {
					$parent_page               = get_post( $parent_id );
					if ( $parent_page ) {
						$page_breadcrumbs[] = array(
							'name' => get_the_title( $parent_page->ID ),
							'url'  => get_permalink( $parent_page->ID ),
						);
						$parent_id          = $parent_page->post_parent;
					} else {
						$parent_id = 0;
					}
				}

				$page_breadcrumbs = array_reverse( $page_breadcrumbs );
				$breadcrumbs_parts = array_merge( $breadcrumbs_parts, $page_breadcrumbs );
			}

			if ( $showCurrent ) {
				$breadcrumbs_parts[] = array(
					'name' => wp_trim_words( get_the_title(), $current_words_num ),
				);
			}

		} elseif ( is_tag() ) {

			$breadcrumbs_parts[] = array(
				'name' => sprintf( $text['tag'], single_tag_title( '', false ) ),
			);

		} elseif ( is_404() ) {

			$breadcrumbs_parts[] = array(
				'name' => $text['404'],
			);

		}

		$breadcrumbs_parts = (array) apply_filters( 'presscore_breadcrumbs_parts', $breadcrumbs_parts );

		$breadcrumbs = array();
		foreach ( $breadcrumbs_parts as $index => $breadcrumb_part ) {
			if ( ! isset( $breadcrumb_part['name'] ) ) {
				continue;
			}

			$item_name = $breadcrumb_part['name'];
			if ( $itemMaxChrCount ) {
				$item_name = substr( $item_name, 0, $itemMaxChrCount );
				if ( $item_name !== $breadcrumb_part['name'] ) {
					$item_name .= '&hellip;';
				}
			}

			$breadcrumb = '<span itemprop="name">' . $item_name . '</span>';
			$position   = $index + 1;
			$position_meta = '<meta itemprop="position" content="' . (int) $position . '" />';
			if ( ! empty( $breadcrumb_part['url'] ) ) {
				$breadcrumb = $linkBefore . '<a' . $linkAttr . ' href="' . esc_url( $breadcrumb_part['url'] ) . '" title="' . esc_attr( $item_name ) . '">' . $breadcrumb . '</a>' . $position_meta . $linkAfter;
			} else {
				$breadcrumb = $before . $breadcrumb . $position_meta . $after;
			}

			$breadcrumbs[] = $breadcrumb;
		}

		$html = '<div class="assistive-text">' . __( 'You are here:', 'the7mk2' ) . '</div>';
		$html .= '<ol' . $listAttr . ' itemscope itemtype="https://schema.org/BreadcrumbList">';
		$html .= implode( $delimiter, $breadcrumbs );
		$html .= '</ol>';

		return apply_filters( 'presscore_get_breadcrumbs', $beforeBreadcrumbs . $html . $afterBreadcrumbs, $args );
	}

endif;

if ( ! function_exists( 'presscore_display_posts_filter' ) ) :

	function presscore_display_posts_filter( $args = array() ) {

		$default_args = array(
			'post_type' => 'post',
			'taxonomy' => 'category',
			'query' => null
		);
		$args = wp_parse_args( $args, $default_args );

		$config = presscore_config();
		$load_style = $config->get('load_style');

		// categorizer
		$filter_args = array();
		if ( $config->get( 'template.posts_filter.terms.enabled' ) ) {

			// $posts_ids = $terms_ids = array();
			$default_display = array(
				'select' => 'all',
				'type' => 'category',
				'terms_ids' => array(),
				'posts_ids' => array(),
			);
			$display = wp_parse_args( $config->get( 'display' ), $default_display );

			// categorizer args
			$filter_args = array(
				'taxonomy'	=> $args['taxonomy'],
				'post_type'	=> $args['post_type'],
				'select'	=> $display['select'],
			);

			if ( 'category' == $display['type'] ) {

				$terms_ids = empty($display['terms_ids']) ? array() : $display['terms_ids'];
				$filter_args['terms'] = $terms_ids;

			} elseif ( 'albums' == $display['type'] ) {

				$posts_ids = isset($display['posts_ids']) ? $display['posts_ids'] : array();
				$filter_args['post_ids'] = $posts_ids;

			}
		}

		$filter_class = '';

		if ( $load_style && 'default' !== $load_style ) {
			$filter_class .= ' with-ajax';
		} elseif ( $load_style ) {
			$filter_class .= ' without-isotope';
		}

		if ( ! $config->get( 'template.posts_filter.orderby.enabled' ) && ! $config->get( 'template.posts_filter.order.enabled' ) ) {
			$filter_class .= ' extras-off';
		}

		// Filter style.
		switch ( $config->get( 'template.posts_filter.style' ) ) {
			case 'minimal':
				$filter_class .= ' filter-bg-decoration';
				break;
			case 'material':
				$filter_class .= ' filter-underline-decoration';
				break;
		}

		// display categorizer
		presscore_get_category_list( array(
			// function located in /in/extensions/core-functions.php
			'data'	=> dt_prepare_categorizer_data( $filter_args ),
			'class'	=> 'filter' . $filter_class
		) );
	}

endif;

/**
 * @param string $default Default text.
 *
 * @return string
 */
function the7_get_portfolio_breadcrumbs_text( $default = '' ) {
	$breadcrumbs_text = The7_Admin_Dashboard_Settings::get( 'portfolio-breadcrumbs-text' );

	if ( ! $breadcrumbs_text ) {
		return $default;
	}

	return apply_filters( 'wpml_translate_single_string', $breadcrumbs_text, 'dt-the7', 'portfolio-breadcrumbs-text' );
}
