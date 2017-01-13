<?php
/**
 * Display .... Fichier incompréhensible.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage view
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="main-header">
	<div class="unit-header">
		<div class="media no-file">
			<i class="add animated fa fa-plus-circle"></i>
			<i class="default-image fa fa-picture-o"></i>
		</div>

		<?php apply_filters( 'society_identity', $element, true ); ?>
		<div
				class="button green action-input save"
				data-parent="unit-header"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'save_society' ) ); ?>"><span><?php esc_html_e( 'Enregistrer', 'digirisk' ); ?></span></div>
	</div>

	<div 	class="tab-element dut button red uppercase"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_content' ) ); ?>"
				data-action="digi_list_duer"
				data-id="<?php echo esc_attr( $element->id ); ?>"><i class="icon fa fa-download"></i><span>Télécharger le document unique</span></div>
</div>

<?php echo do_shortcode( '[digi_tab id="' . $element->id . '" type="' . $element->type . '" display="' . $tab_to_display . '"]' ); ?>
<?php apply_filters( 'tab_content', '', $element->id, $tab_to_display, $title ); ?>
