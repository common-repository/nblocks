<?php

$attributes = $args;

$args       = array(

	'post_type'   => 'post',

	'post_status' => 'publish',

);

if ( ! empty( $attributes['offset'] ) ) {

	$args['offset'] = $attributes['offset'];

} else {

	$args['offset'] = 0;

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

$args['posts_per_page'] = ( ! empty( $attributes['ppp'] ) ) ? $attributes['ppp'] : 5;

$filter_query           = new WP_Query( $args );

if ( $filter_query->have_posts() ) {

	$first_two_posts = '';

	$third_post      = '';

	$last_two_posts  = '';

	$other_posts     = '';

	while ( $filter_query->have_posts() ) {

		$filter_query->the_post();

		if ( 0 === $filter_query->current_post || 1 === $filter_query->current_post ) {

			ob_start();

			?>

			<div class="col-6 col-md-12 col-xl-10 col-lg-12 footer-post check-in-view">

			<div class="block-box nblock-center-image">

			<?php

			if ( ! $attributes['hideCattext'] ) {

				?>

				<span class="npub-link"><?php echo wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ); ?></span>

				<?php

			}

			?>

			<a class="npub-text title_link" href="<?php echo esc_url( get_the_permalink() ); ?>"><h4><?php echo esc_html( get_the_title() ); ?></h4></a>

			<a class="npub-text" href="<?php echo esc_url( get_the_permalink() ); ?>">Read more<span class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></span> <span class="bg"><svg width="48" height="10" viewBox="0 0 48 10" fill="none" xmlns="http://www.w3.org/2000/svg">

			<path d="M41 0H32.5L38.5 4.5L32.5 9.5H41L47.5 4.5L41 0Z" fill="#3F3BE6"/>

			<path d="M24.5 0H16L22 4.5L16 9.5H24.5L31 4.5L24.5 0Z" fill="#3F3BE6"/>

			<path d="M8.5 0H0L6 4.5L0 9.5H8.5L15 4.5L8.5 0Z" fill="#3F3BE6"/>

			</svg>

			</span></a>

			</div></div>

			<?php

			$first_two_posts .= ob_get_clean();

		}

		if ( 2 === $filter_query->current_post ) {

			ob_start();

			?>

			<div class="post_i,age_data">

				<div class="image">

					<a href="<?php echo esc_url( get_permalink() ); ?>"> 

						<span class="size-npub-large mb-3"><?php echo wp_kses_post( get_the_post_thumbnail( $post->ID, '', array( 'class' => 'featured-article-img' ) ) ); ?></span>

					</a>

				</div>

				<div class="post_metadata">

				<?php

				if ( ! $attributes['hideCattext'] ) {

					?>

					<span class="pe-2 npub-link"><?php echo wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ); ?></span>

					<?php

				}

				if ( ! $attributes['hideAuth'] ) {

					?>

					<p class="d-inline pe-2 npub-secondary-color npub-secondary-title"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></p>

					<?php

				}

				if ( ! $attributes['hideDate'] ) {

					?>

					<p class="d-inline p-0 npub-secondary-color npub-secondary-title"><?php echo esc_html( npub_time_ago() ); ?></p>

					<?php

				}

				if ( ! empty( get_the_title() ) ) {

					?>

					<a href="<?php echo esc_url( get_permalink() ); ?>"><h4><?php echo esc_html( get_the_title() ); ?></h4></a>

					<?php

				}

				if ( ! $attributes['hideExcerpt'] ) {

					?>

					<p class="full-width-1col-exerpt my-0  npub-text-color npub-blog-detail"><?php echo esc_html( get_the_excerpt() ); ?></p>

					<?php

				}

				?>

				</div>

				</div>

			<?php

			$third_post .= ob_get_clean();

		}

		if ( 3 === $filter_query->current_post || 4 === $filter_query->current_post ) {

			ob_start();

			?>

			<div class="col-6 col-md-12 offset-xl-2 col-xl-10 col-lg-12 footer-post check-in-view">

			<div class="block-box nblock-center-image">

			<?php

			if ( ! $attributes['hideCattext'] ) {

				?>

				<span class="npub-link"><?php echo wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ); ?></span>

				<?php

			}

			?>

			<a class="npub-text title_link" href="<?php echo esc_url( get_the_permalink() ); ?>"><h4><?php echo esc_html( get_the_title() ); ?></h4></a>

			<a class="npub-text" href="<?php echo esc_url( get_the_permalink() ); ?>">Read more<span class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></span> <span class="bg"><svg width="48" height="10" viewBox="0 0 48 10" fill="none" xmlns="http://www.w3.org/2000/svg">

			<path d="M41 0H32.5L38.5 4.5L32.5 9.5H41L47.5 4.5L41 0Z" fill="#3F3BE6"/>

			<path d="M24.5 0H16L22 4.5L16 9.5H24.5L31 4.5L24.5 0Z" fill="#3F3BE6"/>

			<path d="M8.5 0H0L6 4.5L0 9.5H8.5L15 4.5L8.5 0Z" fill="#3F3BE6"/>

			</svg>

			</span></a>

			</div></div>

			<?php

			$last_two_posts .= ob_get_clean();

		}

		if ( $filter_query->current_post > 4 ) {

			ob_start();

			?>

			<div class="col-6 col-md-3 col-xl-3 col-lg-3 footer-post check-in-view">

				<div class="block-box nblock-center-image">

				<?php

				if ( ! $attributes['hideCattext'] ) {

					?>

					<span class="npub-link"><?php echo wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ); ?></span>

					<?php

				}

				?>

				<a class="npub-text title_link" href="<?php echo esc_url( get_the_permalink() ); ?>"><h4><?php echo esc_html( get_the_title() ); ?></h4></a>

				<a class="npub-text" href="<?php echo esc_url( get_the_permalink() ); ?>">Read more<span class="screen-reader-text"><?php echo esc_html( get_the_title() ); ?></span> <span class="bg"><svg width="48" height="10" viewBox="0 0 48 10" fill="none" xmlns="http://www.w3.org/2000/svg">

				<path d="M41 0H32.5L38.5 4.5L32.5 9.5H41L47.5 4.5L41 0Z" fill="#3F3BE6"/>

				<path d="M24.5 0H16L22 4.5L16 9.5H24.5L31 4.5L24.5 0Z" fill="#3F3BE6"/>

				<path d="M8.5 0H0L6 4.5L0 9.5H8.5L15 4.5L8.5 0Z" fill="#3F3BE6"/>

				</svg>

				</span></a>

				</div></div>

			<?php

			$other_posts .= ob_get_clean();

		}

	}

	?>

	<div class="nblock_centered_big mx-0 px-0 npub-centered-big npub-center-img-section">

		<div class="row nblock_centered_big npub_main_5posts  px-0 npub-centered-big check-in-view">

			<?php if ( ! empty( $first_two_posts ) ) { ?>

			<div class="col-md-12 col-xl-3 col-lg-12 nblock_5col_masonry nblock_2col_masonry_bigcenter npuf-5col-masonry npub-medium-title npub-left-center-block  odr-1">

				<?php echo wp_kses_post( $first_two_posts ); ?>

			</div>

			<?php }  if ( ! empty( $third_post ) ) { ?>

			<div class="nblock-bigcenter-posts col-lg-12 col-xl-6 col-md-12 col-sm-12 col-xs-4 col-12 pb-4 pb-sm-3 latest-nbolck npub-big-title npub-featured-small npub-big-center-image odr-2">

				<?php echo wp_kses_post( $third_post ); ?>	

			</div>

			<?php }  if ( ! empty( $last_two_posts ) ) { ?>

			<div class=" col-md-12 col-xl-3 col-lg-12  nblock_5col_masonry nblock_2col_masonry_bigcenter npuf-5col-masonry npub-medium-title odr-3">

				<?php echo wp_kses_post( $last_two_posts ); ?>	

			</div>

			<?php } ?>

		</div>

		<?php if ( ! empty( $other_posts ) ) { ?>

		<div class="npub_main_centered_extra_posts extra-post">

			<div class="row nblock_5col_masonry nblock_2col_masonry_bigcenter npuf-5col-masonry npub-medium-title">

				<?php echo wp_kses_post( $other_posts ); ?>

			</div>

		</div>

		<?php } ?>

	</div>

	<?php

} else {

	?>

	<div class="nblocks-notfound">No posts are found..!</div>

	<?php

}

