<?php

$attributes = $args;

$args       = array(

	'post_type'   => 'post',

	'post_status' => 'publish',

);

if ( ! empty( $attributes['offset'] ) ) {

	$args['offset'] = $attributes['offset'];

}

if ( ! empty( $attributes['ppp'] ) ) {

	$args['posts_per_page'] = $attributes['ppp'];

}

if ( ! empty( $attributes['categories'] ) ) {

	$args['tax_query'] = array(

		array(

			'taxonomy' => 'category',

			'field'    => 'slug',

			'terms'    => $attributes['categories'],

		),

	);

}

if ( ! empty( $attributes['order'] ) ) {

	$args['order'] = $attributes['order'];

}

if ( ! empty( $attributes['orderBy'] ) ) {

	$args['orderby'] = $attributes['orderBy'];

}

if ( ! empty( $attributes['author'] ) ) {

	$args['author__in'] = $attributes['author'];

}

if ( ! empty( $attributes['date'] ) ) {

	$args['date_query'] = array(

		array(

			'after'     => $attributes['date'],

			'before'    => wp_date( 'Y-m-d\TH:i:s' ),

			'inclusive' => true,

		),

	);	

}

$query   = new WP_Query( $args );

$content = '';

if ( $query->have_posts() ) {

	$content   .= '<div class="row nblock_featured_big mx-0 px-0 latest-nbolck npub-featured-big npub-big-title">';

	$authors    = $attributes['author'];

	$isfirst    = true;

	$firstpost  = '';

	$otherposts = '';

	while ( $query->have_posts() ) {

		$query->the_post();

		$author_id     = get_post_field( 'post_author', get_the_ID() );

		$content_temp  = '';

		$content_temp .= '<div class="">';

		$content_temp .= '<div class="featured-big-image-container check-in-view"><a href="' . esc_url( get_permalink() ) . '"><span class="size-npub-large">' . get_the_post_thumbnail( $post->ID, '', array( 'class' => 'featured-article-img' ) ) . '</span></a></div>';

		$content_temp .= '<div class="">';

		if ( ! $attributes['hideCattext'] ) {

			$content_temp .= '<span class="pe-2 npub-link">' . wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ) . '</span>';

		}

		if ( ! $attributes['hideAuth'] ) {

			$content_temp .= '<p class="d-inline pe-2 npub-secondary-color npub-secondary-title">' . esc_html( get_the_author_meta( 'display_name', $author_id ) ) . '</p>';

		}

		if ( ! $attributes['hideDate'] ) {

			$content_temp .= '<p class="d-inline p-0 npub-secondary-color npub-secondary-title"> ' . esc_html( npub_time_ago() ) . '</p>';

		}

		$content_temp .= '<a href="' . esc_url( get_permalink() ) . '"><h4>' . esc_html( get_the_title() ) . '</h4></a>';

		if ( ! $attributes['hideExcerpt'] ) {

			$content_temp .= '<p class="full-width-1col-exerpt my-0  npub-text-color npub-blog-detail">' . esc_html( get_the_excerpt() ) . '...</p>';

		}



		$content_temp .= '</div>';

		$content_temp .= '</div>';

		if ( $isfirst ) {

			$firstpost .= $content_temp;

		} else {

			$otherposts .= $content_temp;

		}

		$isfirst = false;

	}

	$content .= ( ! empty( $firstpost ) ) ? sprintf( "<div class='nblock-big-post'>%s</div>", $firstpost ) : '';

	$content .= ( ! empty( $otherposts ) ) ? sprintf( "<div class='nblock-small-posts'>%s</div>", $otherposts ) : '';

	$content .= '</div>';

} else {

	$content .= '<div class="nblocks-notfound">No posts are found..!</div>';

}



wp_reset_postdata();



echo wp_kses_post( $content );

