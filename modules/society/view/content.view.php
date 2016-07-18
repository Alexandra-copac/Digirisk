<?php
/**
* Display .... Fichier incompréhensible.
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wp-digi-group-sheet wp-digi-sheet" data-id="<?php echo $element->id; ?>"  >
	<div class="wp-digi-global-sheet-header wp-digi-global-sheet-header">
    <?php apply_filters( 'wpdigi_establishment_identity', $element, true ); ?>

		<input type="hidden" name="group_id" value="0" />
		<input type="text" placeholder="" data-target="group_id" data-id="<?php echo $element->id; ?>" class="wpdigi-auto-complete" />
		
		<div class="wp-digi-group-action-container wp-digi-global-action-container hidden">
			<button class="wp-digi-bton-fourth wp-digi-save-identity-button" data-nonce="<?php echo wp_create_nonce( 'ajax_update_group_' . $element->id ); ?>"><?php _e( 'Save', 'digirisk' ); ?></button>
		</div>

		<?php if ( $display_trash ): ?>
			<a class="wp-digi-delete-action" data-id="<?php echo $element->id; ?>"><i class="dashicons dashicons-trash"></i></a>
		<?php endif; ?>
	</div>
	<?php echo do_shortcode( '[digi-tab type="' . $element->type . '" display="' . $tab_to_display . '"]' ); ?>
	<?php apply_filters( 'wpdigi_establishment_tab_content', '', $element, $tab_to_display ); ?>

</div>
