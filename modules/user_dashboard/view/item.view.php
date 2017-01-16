<?php
/**
 * Affichage d'un utilisateur ainsi que les actions pour l'éditer ou le supprimer.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package user_dashboard
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr>
	<td><div class="avatar" style="background-color: #<?php echo esc_attr( $user->avatar_color ); ?>;"><span><?php echo esc_html( $user->initial ); ?></span></div></td>
	<td class="padding"><span><strong><?php echo esc_html( User_Class::g()->element_prefix . $user->id ); ?><strong></span></td>
	<td><span><?php echo esc_html( stripslashes( $user->lastname ) ); ?></span></td>
	<td><span><?php echo esc_html( stripslashes( $user->firstname ) ); ?></span<</td>
	<td><span><?php echo esc_html( $user->email ); ?></span></td>
	<td class="wp-digi-action wp-digi-user wp-digi-user-action">
		<a href="#"
			data-id="<?php echo esc_attr( $user->id ); ?>"
			data-action="load_user"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_user' ) ); ?>"
			class="action-attribute">E</a>

		<a href="#"
			data-id="<?php echo esc_attr( $user->id ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_user' ) ); ?>"
			data-action="delete_user"
			class="action-delete" >D</a>
	</td>
</tr>
