<?php
/**
 * Template used to display the pixproof gallery
 * Available vars:
 * array        $gallery_ids        An array with all attachments ids
 * object       $attachments        An object with all the attachments
 * string       $number_of_images   Count attachments
 * string       $columns            Number of columns
 * string       $thumbnails_size    The size of the thumbnail
 */
?>
<div id="pixproof_gallery"
     class="gallery row gallery-columns-<?php echo esc_attr( $columns ); ?>  cf  js-pixproof-gallery">
	<?php
	$idx = 1;
	foreach ( $attachments as $attachment ) {
		if ( 'selected' == self::get_attachment_class( $attachment ) ) {
			$select_label = esc_html__( 'Deselect', 'napoli' );
		} else {
			$select_label = esc_html__( 'Select', 'napoli' );
		}

		$thumb_img  = wp_get_attachment_image_src( $attachment->ID, $thumbnails_size );
		$image_full = wp_get_attachment_image_src( $attachment->ID, 'full-size' );

		//lets determine what should we display under each image according to settings
		// also what id should we assign to that image so the auto comments linking works
		$image_name   = '';
		$image_id_tag = '';
		if ( isset( $photo_display_name ) ) {
			switch ( $photo_display_name ) {
				case 'unique_ids':
					$image_name   = '#' . $attachment->ID;
					$image_id_tag = 'item-' . $attachment->ID;
					break;
				case 'consecutive_ids':
					$image_name   = '#' . $idx;
					$image_id_tag = 'item-' . $idx;
					break;
				case 'file_name':
					$image_name   = '#' . $attachment->post_name;
					$image_id_tag = 'item-' . $attachment->post_name;
					break;
				case 'unique_ids_photo_title':
					$image_name   = '#' . $attachment->ID . ' ' . $attachment->post_title;
					$image_id_tag = 'item-' . $attachment->ID;
					break;
				case 'consecutive_ids_photo_title':
					$image_name   = $attachment->post_title;
					$image_id_tag = 'item-' . $idx;
					break;
			}
		} else {
			//default to unique ids aka attachment id
			$image_name   = '#' . $attachment->ID;
			$image_id_tag = 'item-' . $attachment->ID;
		} ?>
		<div
			class="proof-photo col-xs-12 col-sm-6 col-md-3  js-proof-photo  gallery-itemA <?php echo esc_attr( self::attachment_class( $attachment ) ); ?>" <?php echo esc_html( self::attachment_data( $attachment ) ); ?>
			id="<?php echo esc_attr($image_id_tag); ?>">
			<div class="proof-photo__bg">
				<div class="proof-photo__container">
					<div class="img-wrap">
						<?php 
						echo napoli_the_lazy_load_flter( $thumb_img[0], array(
							'class' => 's-img-switch',
							'alt'   => $attachment->post_excerpt
						) );
						 ?>
					</div>
					<div class="proof-photo__meta">
						<div class="flexbox">
							<div class="flexbox__item">
								<ul class="actions-nav  nav  nav--stacked">
									<li>
										<a class="meta__action  zoom-action"
										   href="<?php echo esc_url( $image_full[0] ); ?>"
										   data-photoid="<?php echo esc_attr($image_id_tag); ?>">
											<span class="button-text"><?php esc_html_e( 'Zoom', 'napoli' ); ?></span>
										</a>
									</li>
									<li>
										<a class="meta__action  select-action" href="#"
										   data-photoid="<?php echo esc_attr( $image_id_tag ); ?>">
											<span class="button-text"><?php echo esc_attr( $select_label ); ?></span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="proof-photo__status">
						<span class="ticker">&check;</span>
						<span class="spinner"></span>
					</div>
				</div>
				<span class="proof-photo__id"><?php echo esc_attr( $image_name ); ?></span>
			</div>
		</div>
		<?php
		$idx ++;
	} ?>
</div>
