<?php
/**
* Affiches le toggle pour sélectionner une cotation avec la méthode simple de digirisk
* Ajoutes également un bouton qui permet d'évaluer avec la méthode complexe de digirisk
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package method_evaluation
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<input type="hidden" name="method_evaluation_id" value="<?php echo $digi_method_id; ?>" />
<input type="hidden" class="risk-level" name="risk_evaluation_level" value="<?php echo $scale; ?>" />

<span data-target="wp-digi-risk-cotation-chooser" class="digi-toggle wp-digi-risk-list-column-cotation" >
	<div class="wp-digi-risk-level-<?php echo $scale; ?> wp-digi-risk-level-new">&nbsp;</div>
	<ul class="wp-digi-risk-cotation-chooser digi-popup" style="display: none;" >
		<li data-level="1" class="wp-digi-risk-level-1" >&nbsp;</li>
		<li data-level="2" class="wp-digi-risk-level-2" >&nbsp;</li>
		<li data-level="3" class="wp-digi-risk-level-3" >&nbsp;</li>
		<li data-level="4" class="wp-digi-risk-level-4" >&nbsp;</li>
		<?php if ( $risk_id === 0 || $digi_method_id === $term_evarisk_complex->term_id ): ?>
		    <li class="open-method-evaluation-render"><span class="dashicons dashicons-admin-generic digi-toggle" data-parent=".form-risk" data-target="wpdigi-method-evaluation-render"></span></li>
    <?php endif; ?>
	</ul>
</span>