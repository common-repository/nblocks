<?php

$attributes = $args;

$args = array(

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

	$authors  = $attributes['author'];

	$content .= '<div class="row nblock_latest_4col_row  latest-nbolck npub-4col-masonry npub-medium-title">';

	while ( $query->have_posts() ) {

		$query->the_post();

		$author_id = get_post_field( 'post_author', get_the_ID() );

		$content  .= '<div class="col-lg-4 col-xl-3 col-md-4 col-sm-6 col-xs-12 col-6 nblock_latest_4col_col nblock-space check-in-view">';

		$content  .= '<div class="four-col-img"><a href="' . esc_url( get_permalink() ) . '"><span class="size-npub-small-square">' . get_the_post_thumbnail( $post->ID ) . '</span></a></div>';

		if ( ! $attributes['hideCattext'] ) {

			$content .= '<span class="pe-2 npub-link">' . wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ) . '</span>';

		}

		if ( ! $attributes['hideAuth'] ) {

			$content .= '<p class="d-inline pe-2 npub-secondary-color npub-secondary-title">' . esc_html( get_the_author_meta( 'display_name', $author_id ) ) . '</p>';

		}

		if ( ! $attributes['hideDate'] ) {

			$content .= '<p class="d-inline p-0 npub-secondary-color npub-secondary-title"> ' . esc_html( npub_time_ago() ) . '</p>';

		}

		$content .= '<a href="' . esc_url( get_permalink() ) . '"><h4>' . esc_html( get_the_title() ) . '</h4></a>';

		

		$content .= '</div>';

	}

	$content .= '</div>';

} else {

	$content .= '<div class="nblocks-notfound">No posts are found..!</div>';

}

wp_reset_postdata();

echo wp_kses_post( $content );

