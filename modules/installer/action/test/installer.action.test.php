<?php

namespace digi;

class Installer_Action_Test extends \WP_UnitTestCase {

	public function test_ajax_installer_save_society_normal_char() {
		$group = Group_Class::g()->update( array(
			 'post_title' => 'Evarisk',
		) );

		$this->assertEquals( 'GP1', $group->unique_identifier );
	}

	public function test_ajax_installer_save_society_wtf_char() {
		$group = Group_Class::g()->update( array(
			 'post_title' => '%@]<?_²/*>',
		) );

		$this->assertEquals( 'GP1', $group->unique_identifier );
	}

	public function test_ajax_installer_components() {
		$default_core_option = array(
			'installed' 									=> false,
			'db_version'									=> '1',
			'danger_installed' 						=> false,
			'recommendation_installed' 		=> false,
			'evaluation_method_installed' => false,
		);

		$core_option = get_option( Config_Util::$init['digirisk']->core_option, $default_core_option );

		if ( ! $core_option['danger_installed'] ) {
			Danger_Default_Data_Class::g()->create();
			$core_option['danger_installed'] = true;
		} elseif ( ! $core_option['recommendation_installed'] ) {
			Recommendation_Default_Data_Class::g()->create();
			$core_option['recommendation_installed'] = true;
		} elseif ( ! $core_option['evaluation_method_installed'] ) {
			Evaluation_Method_Default_Data_Class::g()->create();
			$core_option['evaluation_method_installed'] = true;
			$core_option['installed'] = true;
		}

		$this->assertTrue( update_option( Config_Util::$init['digirisk']->core_option, $core_option ) );
	}
}
