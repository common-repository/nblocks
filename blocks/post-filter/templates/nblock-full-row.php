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

	$content .= '<div class="one-col-container mx-0 latest-nbolck npub-full-row npub-big-title">';

	$authors  = $attributes['author'];

	while ( $query->have_posts() ) {

		$query->the_post();	

		$author_id = get_post_field( 'post_author', get_the_ID() );

		$content  .= '<div class="row one-col-article p-2 my-1 px-sm-2 py-sm-2 my-sm-1 py-md-3 px-lg-2 px-md-3 my-md-1 py-lg-2 px-xl-2 py-xl-2 my-lg-3 d-flex align-items-lg-center align-items-md-top align-items-sm-start align-items-start check-in-view">';

		$content  .= '<div class="col-lg-4 col-md-5 col-sm-4 col-5 m-0 px-sm-2 px-md-1 pt-lg-2 px-lg-2 p-2 pt-md-0  ps-1 check-in-view"><a href="' . esc_url( get_permalink() ) . '"><span class="size-npub-medium">' . get_the_post_thumbnail( $post->ID, '', array( 'class' => 'one-col-article-img' ) ) . '</span></a></div>';

		$content  .= '<div class="col-lg-7 col-md-7 col-sm-8 col-7 p-2 ps-lg-2 ps-md-3 ps-2 ps-sm-2 pt-xs-2 pt-sm-0 check-in-view">';

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

		if ( ! $attributes['hideExcerpt'] ) {

			$content .= '<p class="full-width-1col-exerpt my-0  npub-text-color npub-blog-detail">' . esc_html( get_the_excerpt() ) . '</p>';

		}

		

		$content .= '</div>';

		$content .= '</div>';

	}

	$content .= '</div>';



} else {

	$content .= '<div class="nblocks-notfound">No posts are found..!</div>';

}

wp_reset_postdata();

echo wp_kses_post( $content );

