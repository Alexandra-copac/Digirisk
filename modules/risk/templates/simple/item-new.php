<?php if ( !defined( 'ABSPATH' ) ) exit; ?>
<div class="wp-digi-risk-item wp-digi-risk-item-new wp-digi-list-item <?php $i++; echo ( $i%2 ? 'odd' : 'even' ); ?> wp-digi-bloc-loader" data-risk-id="new" >
	<form method="post" action="<?php echo admin_url( 'admin-ajax.php' ); ?>">
		<ul class="wp-digi-table">
			<li>
				<input type="hidden" name="action" value="wpdigi-create-risk" />
				<input type="hidden" name="digi_method" value="<?php echo $term_evarisk_simple->term_id; ?>" />
				<input type="hidden" class="digi-method-simple" value="<?php echo $term_evarisk_simple->term_id; ?>" />
				<input type="hidden" name="global" value="<?php echo str_replace( 'mdl_01', 'ctr',get_class( $element ) ); ?>" />
				<?php wp_nonce_field( 'ajax_create_risk' ); ?>
				<input type="hidden" name="workunit_id" value="<?php echo $element->id; ?>" />
				<span class="wp-digi-risk-thumbnail wpeo-upload-media" data-nonce="<?php echo wp_create_nonce( 'ajax_file_association_risk' ); ?>" data-id="0" data-type="digi-risk"  >
					<i class="wp-digi-element-thumbnail dashicons dashicons-format-image" ></i>
					<input type="hidden" name="thumbnail_id" value="" />
					<img data-nonce="<?php echo wp_create_nonce( 'ajax_file_association_risk' ); ?>" data-id="0" data-type="digi-risk" width="50" height="50" class="hidden wpeo-upload-media attachment-digirisk-element-miniature size-digirisk-element-miniature wp-post-image" alt="" sizes="(max-width: 50px) 100vw, 50px">
				</span>
				<input type="hidden" class="risk-level" name="risk_evaluation_level" value="1" />
				<span data-risk_level="1" data-target="wp-digi-risk-cotation-chooser" class="digi-toggle wp-digi-risk-list-column-cotation wp-digi-risk-level-1" >
					<div class="wp-digi-risk-level-1 wp-digi-risk-level-new" ><?php echo $wpdigi_evaluation_method_controller->get_value_treshold( 1 ); ?></div>
					<ul class="wp-digi-risk-cotation-chooser digi-popup" style="display: none;" >
						<li data-risk_level="1" data-value="1" data-risk-text="1" class="wp-digi-risk-level-1" >&nbsp;</li>
						<li data-risk_level="2" data-value="48" data-risk-text="48" class="wp-digi-risk-level-2" >&nbsp;</li>
						<li data-risk_level="3" data-value="51" data-risk-text="51" class="wp-digi-risk-level-3" >&nbsp;</li>
						<li data-risk_level="4" data-value="80" data-risk-text="80" class="wp-digi-risk-level-4" >&nbsp;</li>
						<li class="open-method-evaluation-render"><span class="dashicons dashicons-admin-generic"></span></li>
					</ul>
				</span>
				<span class="wp-digi-risk-select"><?php global $wpdigi_danger_category_ctr; $wpdigi_danger_category_ctr->display_category_danger( array( 'with_danger' => true, ) ); ?></span>
				<span class="wp-digi-risk-date"><input type="text" class="wpdigi_date" name="risk_comment_date" value="<?php echo current_time( 'd/m/Y', 0 ); ?>" /></span>
				<span class="wp-digi-risk-comment" ><textarea name="risk_comment" rows="1" placeholder="<?php _e( 'Add a comment for the risk', 'wpdigi-risks-i18n' ); ?>" ></textarea></span>
				<span class="wp-digi-risk-action wp-digi-action wp-digi-action-new" ><a href="#" class="wp-digi-action dashicons dashicons-plus" ></a></span>
			</li>
		</ul>

		<div class="wpdigi-method-evaluation-render"><?php require( wpdigi_utils::get_template_part( WPDIGI_RISKS_DIR, WPDIGI_RISKS_TEMPLATES_MAIN_DIR, 'simple', 'method', 'evaluation-evarisk' ) ); ?></div>
	</form>
</div>