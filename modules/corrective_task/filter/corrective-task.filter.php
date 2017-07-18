<?php
/**
 * Les filtres relatifs aux tâches correctives.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.9.0
 * @copyright 2015-2017 Evarisk
 * @package corrective-task
 * @subpackage filter
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Les filtres relatifs aux tâches correctives.
 */
class Corrective_Task_Filter {

	/**
	 * Constructeur
	 *
	 * @since 0.1
	 * @version 6.2.6.0
	 */
	public function __construct() {
		add_filter( 'risk_duer_additional_data', array( $this, 'callback_risk_duer_additional_data' ), 10, 2 );
	}

	/**
	 * Récupères dans une chaine de caractère le contenu des tâches correctives.
	 *
	 * @param  array      $data_risk Les données des tâches correctives.
	 * @param  Risk_Model $risk      Les données du risque.
	 * @return string                La chaine de caractère mise au bon format pour le ODT.
	 *
	 * @since 0.1
	 * @version 6.2.9.0
	 */
	public function callback_risk_duer_additional_data( $data_risk, $risk ) {
		$data_risk['actionPreventionCompleted'] = '';
		$data_risk['actionPreventionUncompleted'] = '';

		if ( class_exists( 'task_controller_01' ) ) {
			global $task_controller;
			global $point_controller;

			$task = $task_controller->index( array(
				'post_parent' => $risk->id,
			) );

			if ( ! empty( $task ) ) {
				$task = $task[0];

				$list_point_completed = array();
				$list_point_uncompleted = array();

				if ( ! empty( $task->option['task_info']['order_point_id'] ) ) {
					$list_point = $point_controller->index( $task->id, array(
						'orderby' => 'comment__in',
						'comment__in' => $task->option['task_info']['order_point_id'],
						'status' => -34070,
					) );

					$list_point_completed = array_filter( $list_point, function( $point ) {
						return true === $point->option['point_info']['completed'];
					} );

					$list_point_uncompleted = array_filter( $list_point, function( $point ) {
						return false === $point->option['point_info']['completed'];
					} );
				}

				$string = '';

				if ( ! empty( $list_point_completed ) ) {
					foreach ( $list_point_completed as $element ) {
						$string .= Helper_Util::g()->point_to_string( $element );
					}
				}

				$data_risk['actionPreventionCompleted'] = $string;
				$string = '';

				if ( ! empty( $list_point_uncompleted ) ) {
					foreach ( $list_point_uncompleted as $element ) {
						$string .= Helper_Util::g()->point_to_string( $element );
					}
				}

				$data_risk['actionPreventionUncompleted'] = $string;

			} // End if().
		} // End if().

		return $data_risk;
	}
}

new Corrective_Task_Filter();
