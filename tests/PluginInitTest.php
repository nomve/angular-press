<?php


namespace AngularPress\Tests;


class PluginInitTest extends \WP_Mock\Tools\TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        parent::tearDown();
    }


    function testPluginExists() {

        $this->assertFileExists( ANGULAR_PRESS_PLUGIN_FILE );
    }

    function testPluginActivation() {

        \WP_Mock::wpFunction(
            'register_activation_hook',
            array(
                'times' => 1,
                'args' => array(
                    ANGULAR_PRESS_PLUGIN_FILE,
                    array(
                        '\AngularPress\Plugin',
                        'pluginActivation'
                    )
                ),
            )
        );

        require_once ANGULAR_PRESS_PLUGIN_FILE;

        $this->assertTrue( method_exists('\AngularPress\Plugin', 'pluginActivation') );
    }

    function testPluginDeactivation() {

        \WP_Mock::wpFunction(
            'register_deactivation_hook',
            array(
                'times' => 1,
                'args' => array(
                    ANGULAR_PRESS_PLUGIN_DEACTIVATION_FILE,
                    array(
                        '\AngularPress\Plugin',
                        'pluginDeactivation'
                    )
                ),
            )
        );

        require_once ANGULAR_PRESS_PLUGIN_DEACTIVATION_FILE;

        $this->assertTrue( method_exists('\AngularPress\Plugin', 'pluginDeactivation') );
    }

}
