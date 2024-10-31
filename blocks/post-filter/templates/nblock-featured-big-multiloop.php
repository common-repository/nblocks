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

$args['posts_per_page'] = ( ! empty( $attributes['ppp'] ) ) ? $attributes['ppp'] : 3;



$filter_query = new WP_Query( $args );

if ( $filter_query->have_posts() ) {

	$first_posts   = '';

	$last_two_post = '';

	$other_posts   = '';

	while ( $filter_query->have_posts() ) {

		$filter_query->the_post();

		if ( 0 === $filter_query->current_post ) {

			ob_start();

			?>

			<div>

			<div class="image check-in-view">

				<a href="<?php echo esc_url( get_permalink() ); ?>"><span class="size-npub-large mb-3">

					<?php echo wp_kses_post( get_the_post_thumbnail( $post->ID, '', array( 'class' => 'featured-article-img' ) ) ); ?></span>

				</a>

			</div>

			<div>

			<?php

			if ( ! $attributes['hideCattext'] ) {

				?>

				<span class="pe-2 npub-link"><?php echo wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ); ?></span>

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

			if ( ! $attributes['hideAuth'] ) {

				?>

				<p class="d-inline pe-2 npub-secondary-color npub-secondary-title"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></p>

				<?php

			}

			if ( ! $attributes['hideDate'] ) {

				?>

				<p class="d-inline p-0 npub-secondary-color npub-secondary-title"><?php echo esc_html( npub_time_ago() ); ?></p>

			<?php } ?>

			</div>

			</div>

			<?php

			$first_posts .= ob_get_clean();

		}

		if ( 1 === $filter_query->current_post || 2 === $filter_query->current_post ) {

			ob_start();

			?>

			<div class="pb-3 col-xs-6 col-sm-6 col-md-4 col-lg-12 col-xl-12 col-6 nblock-space check-in-view">

				<div class="image">

					<a href="<?php echo esc_url( get_permalink() ); ?>"><span class="size-npub-small mb-3"> 

						<?php echo wp_kses_post( get_the_post_thumbnail( $post->ID, '', array( 'class' => 'featured-article-img' ) ) ); ?></span>

					</a>

				</div>

				<?php if ( ! $attributes['hideCattext'] ) { ?>

					<span class="npub-link pe-2"><?php echo wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ); ?></span>

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

				?>



			</div>

			<?php

			$last_two_post .= ob_get_clean();

		}

		if ( $filter_query->current_post > 2 ) {

			ob_start();

			?>

			<div class="pb-3 col-xs-6 col-sm-6 col-lg-3 col-xl-3 col-md-4 col-6 nblock-space check-in-view">

				<div class="image">

					<a href="<?php echo esc_url( get_permalink() ); ?>"><span class="size-npub-small mb-3"> 

						<?php echo wp_kses_post( get_the_post_thumbnail( $post->ID, '', array( 'class' => 'featured-article-img' ) ) ); ?></span>

					</a>

				</div>

				<?php if ( ! $attributes['hideCattext'] ) { ?>

					<span class="npub-link pe-2"><?php echo wp_kses_post( get_the_category_list( ', ', '', get_the_ID() ) ); ?></span>

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

				?>

			</div>

			<?php

			$other_posts .= ob_get_clean();

		}

	}

	?>

	<div class="row nblock_featured_big mx-0 px-0 npub-featured-big ">

		<?php if ( ! empty( $first_posts ) ) { ?>

		<div class="nblock-big-post col-lg-9 col-md-12 col-sm-12 col-xs-6 col-12 pb-4 pb-sm-0 ps-lg-0 latest-nbolck npub-big-title mb-4 check-in-view">

			<?php echo wp_kses_post( $first_posts ); ?>

		</div>

		<?php }  if ( ! empty( $last_two_post ) ) { ?>

		<div class="nblock-small-posts col-lg-3 col-md-12 col-sm-12 col-xs-4 col-12 pb-4 pb-sm-0 pe-lg-0  latest-nbolck npub-medium-title npub-featured-small check-in-view">

			<div class="row ">

				<?php echo wp_kses_post( $last_two_post ); ?>

			</div>

		</div>

		<?php }  if ( ! empty( $other_posts ) ) { ?>

		<div class="nblock-small-posts  col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 pb-4 pb-sm-0 px-lg-0 latest-nbolck npub-medium-title npub-featured-small check-in-view">

			<div class="row">

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



