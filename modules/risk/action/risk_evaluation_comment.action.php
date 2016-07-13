<?php
/**
* @TODO : A détailler
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package risk
* @subpackage action
*/

if ( !defined( 'ABSPATH' ) ) exit;

class risk_evaluation_comment_action {
	/**
	* Le constructeur appelle l'action ajax: wp_ajax_save_risk
	*/
	public function __construct() {
		add_action( 'wp_ajax_save_risk', array( $this, 'callback_save_risk' ), 3 );
	}

	/**
  * Enregistres le commentaire d'une evaluation d'un risque
  * Ce callback est hoocké après wp_ajax_save_risk de risk_save_action
  *
  * string $_POST['comment_date'] La date du commentaire
  * string $_POST['comment_content'] Le contenu du commentaire
	*
  * @param array $_POST Les données envoyées par le formulaire
  */
	public function callback_save_risk() {
		check_ajax_referer( 'save_risk' );

    $list_comment_content = !empty( $_POST['comment_content'] ) ? (array) $_POST['comment_content' ] : array();
    $list_comment_date = !empty( $_POST['comment_date'] ) ? (array) $_POST['comment_date' ] : array();
    $list_comment_id = !empty( $_POST['comment_id'] ) ? (array) $_POST['comment_id' ] : array();

		$risk_evaluation_id = risk_evaluation_class::get()->get_last_entry();
		$risk_id = risk_class::get()->get_last_entry();

		if ( !empty( $_POST['risk_id'] ) ) {
			$risk_id = (int) $_POST['risk_id'];
		}

		if ( !empty( $list_comment_content ) ) {
		  foreach ( $list_comment_content as $key => $element ) {
				if ( !empty( $element ) ) {
					// On change les slasles dans la date en virgule
					$comment_date = str_replace( '/', ',', $list_comment_date[$key] );

					$data = array(
						'author_id' => get_current_user_id(),
						'parent_id' => $risk_evaluation_id,
						'post_id' => $risk_id,
						'status' => '-34070',
						'date' => sanitize_text_field( $comment_date ),
						'content' => sanitize_text_field( $element ),
					);

					if ( !empty( $list_comment_id[$key] ) && $list_comment_id[$key] != 0 ) {
						$data['id'] = (int) $list_comment_id[$key];
					}

					risk_evaluation_comment_class::get()->update( $data );
				}
		  }
		}
	}
}

new risk_evaluation_comment_action();
