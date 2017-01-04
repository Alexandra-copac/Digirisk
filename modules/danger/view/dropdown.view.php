<?php
/**
 * La liste des danger
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package danger
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<input class="input-hidden-danger" type="hidden" name="risk[danger_id]" value='<?php echo esc_attr( $first_danger->id ); ?>' />

<div class="danger categorie-container toggle grid padding" data-parent="categorie-container" data-target="content">

	<div class="action">
		<span><?php esc_html_e( 'Choisir un danger', 'digirisk' ); ?></span>
		<img class="hidden" src="" title="<?php echo esc_attr( 'Choisir un danger', 'digirisk' ); ?>" />
		<i class="icon animated fa fa-angle-down"></i>
	</div>

	<ul class="content">
		<?php foreach ( $danger_category_list as $danger_category ) : ?>
			<?php if ( ! empty( $danger_category->danger ) ) : ?>
				<?php foreach ( $danger_category->danger as $danger ) : ?>
					<li class="item" data-id="<?php echo esc_attr( $danger->id ); ?>">
						<?php echo wp_get_attachment_image( $danger->thumbnail_id, 'thumbnail', false, array( 'title' => $danger->name ) ); ?>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
</div>
