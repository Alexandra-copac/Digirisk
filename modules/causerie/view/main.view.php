<?php
/**
 * Gestion des onglets des causeries
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wrap">
	<h1><?php esc_html_e( 'Causeries', 'digirisk' ); ?></h1>

	<div class="digi-tools-main-container">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active" href="#" data-id="digi-dashboard" ><?php esc_html_e( 'Dashboard', 'digirisk' ); ?></a>
			<a class="nav-tab" href="#" data-id="digi-start-causerie" ><?php esc_html_e( 'Démarrer une causerie', 'digirisk' ); ?></a>
			<a class="nav-tab" href="#" data-id="digi-add-causerie" ><?php esc_html_e( 'Ajouter une causerie', 'digirisk' ); ?></a>
		</h2>

		<div class="digirisk-wrap">

			<div id="digi-dashboard" class="tab-content hidden">
				<?php Causerie_Dashboard_Class::g()->display(); ?>
			</div>

			<div id="digi-start-causerie" class="tab-content">
				<?php Causerie_Start_Class::g()->display(); ?>
			</div>

			<div id="digi-add-causerie" class="tab-content hidden">
				<?php Causerie_Add_Class::g()->display(); ?>
			</div>
		</div>
	</div>
</div>
