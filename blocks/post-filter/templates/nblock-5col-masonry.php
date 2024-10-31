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

	$content .= '<div class="row nblock_5col_masonry npuf-5col-masonry npub-medium-title">';

	while ( $query->have_posts() ) {

		$query->the_post();

		$author_id = get_post_field( 'post_author', get_the_ID() );	

		$content  .= '<div class="col-12 col-md-3 col-xl-3 col-lg-3 footer-post check-in-view">';

		$content  .= '<div class="block-box">';

		if ( ! $attributes['hideCattext'] ) {

			$content .= '<span class="npub-link">' . wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ) . '</span>';

		}

		$content .= '<a class="npub-text title" href="' . esc_url( get_the_permalink() ) . '"><h4>' . esc_html( get_the_title() ) . '</h4></a>';

		$content .= '<a class="npub-text" href="' . esc_url( get_the_permalink() ) . '">Read more<span class="screen-reader-text">' . esc_html( get_the_title() ) . '</span> <span class="bg"><svg width="48" height="10" viewBox="0 0 48 10" fill="none" xmlns="http://www.w3.org/2000/svg">

		<path d="M41 0H32.5L38.5 4.5L32.5 9.5H41L47.5 4.5L41 0Z" fill="#3F3BE6"/>

		<path d="M24.5 0H16L22 4.5L16 9.5H24.5L31 4.5L24.5 0Z" fill="#3F3BE6"/>

		<path d="M8.5 0H0L6 4.5L0 9.5H8.5L15 4.5L8.5 0Z" fill="#3F3BE6"/>

		</svg>

		</span></a>';

		$content .= '</div>';

		$content .= '</div>';

	}

	$content .= '</div>';

} else {

	$content .= '<div class="nblocks-notfound">No posts are found..!</div>';

}

wp_reset_postdata();

echo wp_kses_post( $content );

