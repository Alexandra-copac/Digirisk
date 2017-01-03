<?php
/**
 * Ajout le shortcode qui permet d'afficher les onglets
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 1.0
 * @version 6.2.3.0
 * @copyright 2015-2016 Eoxia
 * @package tab
 * @subpackage shortcode
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Gestion du shortcode pour afficher les onglets
 */
class Tab_Shortcode {

	/**
	 * Le constructeur
	 */
	public function __construct() {
		add_shortcode( 'digi_tab', array( $this, 'callback_digi_tab' ), 1 );
	}

	/**
	 * Appelle la vue pour afficher les onglets
	 *
	 * @param  array $param Les paramètres du shortcode.
	 * @return void
	 */
	public function callback_digi_tab( $param ) {
		$type = $param['type'];
		$display = $param['display'];

		$list_tab = apply_filters( 'digi_tab', array() );
		view_util::exec( 'tab', 'list', array( 'type' => $type, 'display' => $display, 'list_tab' => $list_tab ) );
	}
}

new Tab_Shortcode();
