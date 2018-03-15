<?php
/**
 * Template used to display the pixproof gallery
 * Available vars:
 * string       $client_name
 * string       $event_date
 * int          $number_of_images
 * string       $file
 */
?>
<div id="pixproof_data" class="pixproof-data">
	<div class="grid clearfix">

		<div class="grid__item  one-half  lap-and-up-one-quarter  push-half--bottom">
			<div class="entry__meta-box">
				<span class="meta-box__title"><?php esc_attr_e( 'Client', 'napoli' ); ?></span>
				<span><?php echo esc_html( $client_name ); ?></span>
			</div>
		</div>


		<div class="grid__item  one-half  lap-and-up-one-quarter  push-half--bottom">
			<div class="entry__meta-box">
				<span class="meta-box__title"><?php esc_html_e( 'Event date', 'napoli' ); ?></span>
				<span><?php echo esc_html( $event_date ); ?></span>
			</div>
		</div>


		<div class="grid__item  one-half  lap-and-up-one-quarter">
			<div class="entry__meta-box">
				<span class="meta-box__title"><?php esc_html_e( 'Images', 'napoli' ); ?></span>
				<span><?php echo esc_html( $number_of_images ); ?></span>
			</div>
		</div>


		<div class="grid__item  one-half  lap-and-up-one-quarter">
			<div class="entry__meta-box">
				<?php $page_meta = get_post_meta( get_the_ID(), '_custom_pixpruf_gallery_options' ); ?>
				<?php if (!empty($page_meta[0]['show_zip_button'])) : ?>
				<button class="button-download a-btn-2 js-download"
				        onclick="window.open('<?php echo esc_url( $file ); ?>')"><?php esc_html_e( 'Download ZIP', 'napoli' ); ?>
				</button>
				<?php endif; ?>
				
				<?php if (!empty($page_meta[0]['show_pdf_button'])) : ?>
				<button class="button-download a-btn-2 js-download"
				        onclick="window.open('<?php echo esc_url( get_permalink() . '?download=pdf' ); ?>')"><?php esc_html_e( 'Download PDF', 'napoli' ); ?>
				</button>
				<?php endif; ?>
			</div>
		</div>

	</div>
</div>
