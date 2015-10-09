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
                        'PluginInit',
                        'pluginActivation'
                    )
                ),
            )
        );

        require_once ANGULAR_PRESS_PLUGIN_FILE;
    }

    function testPluginDeactivation() {

        \WP_Mock::wpFunction(
            'register_deactivation_hook',
            array(
                'times' => 1,
                'args' => array(
                    ANGULAR_PRESS_PLUGIN_DEACTIVATION_FILE,
                    array(
                        'PluginInit',
                        'pluginDeactivation'
                    )
                ),
            )
        );

        require_once ANGULAR_PRESS_PLUGIN_DEACTIVATION_FILE;
    }

}
