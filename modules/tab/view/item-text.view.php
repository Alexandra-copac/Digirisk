<?php
/**
 * Affiches les contenu d'un onglet de type texte
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package tab
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<li class="tab-element"
		data-action="digi-<?php echo esc_attr( $key ); ?>"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_content' ) ); ?>"
		data-title="<?php echo esc_attr( 'risques' ); ?>">
	<span <?php echo ! empty( $element['class'] ) ? 'class="' . esc_attr( $element['class'] ) . '"' : ''; ?>
		><?php echo $element['text']; ?></span> <!-- no esc_html is okay. -->
</li>
