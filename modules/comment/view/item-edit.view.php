<?php
namespace digi;
if ( !defined( 'ABSPATH' ) ) exit;
?>

<li>
	<?php
	$author_id = !empty( $comment->author_id ) ? $comment->author_id : get_current_user_id();
	$userdata = get_userdata( $author_id );
	?>
	<span><?php echo !empty( $userdata->display_name ) ? $userdata->display_name : ''; ?></span>
	<input type="hidden" name="list_comment[<?php echo $comment->id; ?>][author_id]" value="<?php echo $author_id; ?>" />
	<input type="hidden" name="list_comment[<?php echo $comment->id; ?>][id]" value="<?php echo $comment->id; ?>" />
	<span class="wp-digi-risk-date padded">
		<input type="text" class="eva-date" name="list_comment[<?php echo $comment->id; ?>][date]" value="<?php echo $comment->date; ?>" />
	</span>
	<span class="wp-digi-risk-comment padded">
		<textarea rows="1" name="list_comment[<?php echo $comment->id; ?>][content]"><?php echo $comment->content; ?></textarea>
	</span>

	<?php if ($comment->id > 0): ?>
		<span>
			<a href="#"
				data-id="<?php echo $comment->id; ?>"
				data-nonce="<?php echo wp_create_nonce( 'ajax_delete_comment_' . $comment->id ); ?>"
				data-action="delete_comment"
				class="wp-digi-action wp-digi-action-delete dashicons dashicons-no-alt" ></a>
		</span>
	<?php endif; ?>
</li>
