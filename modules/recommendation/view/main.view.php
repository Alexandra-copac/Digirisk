<?php
/**
 * La vue principale des préconisations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package recommendation
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; }

Recommendation_Class::g()->display( $society_id );
\eoxia\View_Util::exec( 'digirisk', 'recommendation', 'item-edit', array( 'society_id' => $society_id, 'recommendation' => $recommendation, 'index' => $index ) );
