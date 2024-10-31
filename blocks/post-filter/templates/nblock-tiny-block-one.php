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

	$authors  = $attributes['author'];

	$content .= '<div class="row nblock_tiny_one_row mt-2 mb-2 mx-0 npub-tiny-block npub-small-title">';

	while ( $query->have_posts() ) {

		$query->the_post();

		$author_id = get_post_field( 'post_author', get_the_ID() );

		$content  .= '<div class="tiny-block-wrapper row m-0 my-2  col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 ps-lg-0 check-in-view">';

		

		$content .= '<div class="col-4 p-0 nblock_latest_3col_col check-in-view">';

		$content .= '<div class="tiny-col-img"><a href="' . esc_url( get_permalink() ) . '"><span class="size-npub-tiny">' . get_the_post_thumbnail( $post->ID ) . '</span></a></div>';

		$content .= '</div>';

		$content .= '<div class="col-8 ps-xs-2">';

		if ( ! $attributes['hideCattext'] ) {

			$content .= '<span class="tiny-h5-category p-0 npub-link">' . wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ) . '</span>';

		}

		$content .= '<a href="' . esc_url( get_permalink() ) . '"><h4>' . esc_html( get_the_title() ) . '</h4></a>';

		$content .= '</div>';

		$content .= '</div>';

	}

	$content .= '</div>';

} else {

	$content .= '<div class="nblocks-notfound">No posts are found..!</div>';

}

wp_reset_postdata();

echo wp_kses_post( $content );

