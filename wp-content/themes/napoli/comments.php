<?php

/**
 *
 * Comment Form
 *
 * @package napoli
 * @since 1.0.0
 * @version 1.1.0
 */

if ( post_password_required() ) {
	return;
}
?>


<?php if ( have_comments() ) : ?>
	<h3 class="comments-title"><?php printf( _nx( 'One Comment', '<span class="count">%1$s Comments</span>', get_comments_number(), 'Comments', 'napoli' ),
			number_format_i18n( get_comments_number() ) ); ?></h3>
	<?php wp_list_comments( array( 'callback' => 'napoli_comment', 'style' => 'ul' ) ); ?>
<?php endif; ?>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'napoli' ); ?></h1>
		<div
			class="nav-previous"><?php previous_comments_link( esc_attr__( '&larr; Older Comments', 'napoli' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( esc_attr__( 'Newer Comments &rarr;', 'napoli' ) ); ?></div>
	</nav>
<?php endif; ?>


<?php

$fields = array(
	'author' => '<input required id="name" type="text" name="author" placeholder="' . esc_attr__( 'Name', 'napoli' ) . '" size="30" tabindex="1" />',
	'email'  => '<input required id="email" type="email" name="email" placeholder="' . esc_attr__( 'Email', 'napoli' ) . '" size="30" tabindex="2" />',
);

$comments_args = array(
	'id_form'              => 'contactform',
	'fields'               =>
		$fields,
	'comment_field'        => '<textarea required id="comment" aria-required="true" name="comment" placeholder="' . esc_attr__( 'Message', 'napoli' ) . '" rows="8" cols="60" tabindex="3"></textarea>',
	'must_log_in'          => '',
	'logged_in_as'         => '',
	'comment_notes_before' => '',
	'comment_notes_after'  => '',
	'title_reply'          => '<strong>' . sprintf( esc_attr__( 'Leave a comment', 'napoli' ) ) . '</strong>',
	'title_reply_to'       => esc_attr__( 'Leave a Reply to %s', 'napoli' ),
	'cancel_reply_link'    => esc_attr__( 'Cancel', 'napoli' ),
	'label_submit'         => esc_attr__( 'send', 'napoli' ),
	'submit_field'         => '<div class="input-wrapper clearfix">%1$s %2$s<span id="message"></span></div>',
);
?>
<div class="comments-form">
	<?php comment_form( $comments_args ); ?>
</div>
