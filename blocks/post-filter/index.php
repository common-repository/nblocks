<?php
/**
 * n-block register on server side.
 */
function npub_filtered_posts_block_init() {
	register_block_type(
		__DIR__,
		array(
			'attributes'      => array(
				'categories'  => array(
					'type'    => 'array',
					'default' => array(),
				),
				'offset'      => array(
					'type'    => 'number',
					'default' => 0,
				),
				'ppp'         => array(
					'type'    => 'number',
					'default' => 10,
				),
				'hideExcerpt' => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hideCattext' => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'hideDate'    => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'hideAuth'    => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'author'      => array(
					'type'    => 'array',
					'default' => array(),
				),
				'date'        => array(
					'type'    => 'string',
					'default' => '',
				),
				'order'       => array(
					'type'    => 'string',
					'default' => '',
				),
				'orderBy'     => array(
					'type'    => 'string',
					'default' => '',
				),
				'layout'      => array(
					'type'    => 'string',
					'default' => '',
				),
			),
			'render_callback' => 'npub_filtered_posts_render_callback',
		)
	);

}
add_action( 'init', 'npub_filtered_posts_block_init' );

/**
 * Post filter callback
 *
 * @param  array $attributes Attribute.
 * @return html
 */
function npub_filtered_posts_render_callback( $attributes ) {
	if ( empty( $attributes['layout'] ) ) {
		return;
	}
	// Access className and className props.
	$classname = ( ! empty( $attributes['className'] ) ) ? $attributes['className'] : '';
	ob_start();
	?>
	<div class="<?php echo esc_attr( $classname ); ?>">
		<?php
			load_template( __DIR__ . '/templates/nblock-' . $attributes['layout'] . '.php', false, $attributes );
		?>
	</div>
	<?php
	return ob_get_clean();
}
