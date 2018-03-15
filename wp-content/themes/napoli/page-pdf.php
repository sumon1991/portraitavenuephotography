<?php 
/* Template for PDF */

require_once get_template_directory() . '/include/lib/vendor/autoload.php';

$dompdf = new \Dompdf\Dompdf();

ob_start();
while ( have_posts() ) : the_post();

	$post = get_post( get_the_ID() );

	if ( post_password_required( $post ) ) {
		esc_html_e('The gallery password is required', 'napoli');
		die();
	}

	// get this gallery's metadata
	$gallery_data = get_post_meta(  get_the_ID(), '_pixproof_main_gallery', true );
	// quit if there is no gallery data
	if ( empty( $gallery_data ) || ! isset( $gallery_data[ 'gallery' ] ) ) {
		 esc_html_e('No gallery data', 'napoli');
		 die();
	}

	$gallery_ids = explode( ',', $gallery_data[ 'gallery' ] );
	if ( empty( $gallery_ids ) ) {
		esc_html_e('Empty gallery', 'napoli');
		die();
	}

	// get attachments
	$attachments = get_posts( array(
		'post_status'    => 'any',
		'post_type'      => 'attachment',
		'post__in'       => $gallery_ids,
		'orderby'        => 'post__in',
		'posts_per_page' => '-1',
	) );

	$image_html = '';
	$images_array = array();

	foreach ( $attachments as $key => $attachment ) {
		$metadata = wp_get_attachment_metadata( $attachment->ID );

		// only those selected
		if ( isset( $metadata[ 'selected' ] ) && $metadata[ 'selected' ] == 'true' ) {
			$image = get_attached_file( $attachment->ID );
			$type = pathinfo($image, PATHINFO_EXTENSION);
			$data = file_get_contents($image);
			$dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);
			$image_html .= '<img style="width:100%" src="'. $dataUri .'">' . "\n";
			$images_array[] = $key;
		}
	}

	$client_name = get_post_meta( get_the_ID(), '_pixproof_client_name', true );
	$event_date  = get_post_meta( get_the_ID(), '_pixproof_event_date', true );
	$number_of_images = count( $images_array );
	?>
	<style type="text/css">
		.entry__meta-box {
		    vertical-align: bottom;
		    line-height: 20px;
		    text-align: left;
		}
		.entry__meta-box .meta-box__title {
		    font-size: 14px!important;
		    line-height: 20px!important; 
		   
		    color: #c0af94;
		    text-transform: uppercase!important;
		    letter-spacing: 2.4px!important;
		    padding-top: 26px!important;
		    padding-right: 10px!important;
		}
		.entry__meta-box span {
		    font-size: 16px;
		    line-height: 20px; 
		    letter-spacing: 1.12px;
		    color: #888888; 
		    padding-top: 20px;
		    padding-right: 40px;
		}
		hr{
			color: #c0af94;
			background: #c0af94;
			height: 2px;
			width: 100%;
			border: 0;
			margin-bottom: 10px;
		}

	</style>
	<div class="entry__meta-box">
		<span class="meta-box__title"><?php esc_attr_e( 'Client', 'napoli' ); ?></span>
		<span><?php echo esc_html( $client_name ); ?></span>
	</div>
	<div class="grid__item  one-half  lap-and-up-one-quarter  push-half--bottom">
		<div class="entry__meta-box">
			<span class="meta-box__title"><?php esc_html_e( 'Event date', 'napoli' ); ?></span>
			<span><?php echo esc_html( $event_date ); ?></span>
		</div>
	</div>
	<div class="entry__meta-box">
		<span class="meta-box__title"><?php esc_html_e( 'Images', 'napoli' ); ?></span>
		<span><?php echo esc_html( $number_of_images ); ?></span>
	</div>
	<hr>

	<?php
	

	if (!empty($image_html)) {
		echo $image_html;
	} else {
		esc_html_e("Don't choose images!", 'napoli');
	}

endwhile;


$dompdf->loadHtml( ob_get_clean() );
$dompdf->set_paper('8.5x11', 'landscape');
$dompdf->render();
$dompdf->stream('gallery');

