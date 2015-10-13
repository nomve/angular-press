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

    /**
     * tests if the plugin file uses the appropriate install hook
     */
    function testPluginActivation() {
        
        $pluginInstance = new \AngularPress\Plugin;

        \WP_Mock::wpFunction(
            'register_activation_hook',
            array(
                'times' => 1,
                'args' => array(
                    ANGULAR_PRESS_PLUGIN_FILE,
                    array(
                        $pluginInstance,
                        'pluginActivation'
                    )
                ),
            )
        );

        require_once ANGULAR_PRESS_PLUGIN_FILE;

        $this->assertTrue( method_exists($pluginInstance, 'pluginActivation') );
    }

    /**
     * tests if the plugin file uses the appropriate uninstall hook
     */
    function testPluginDeactivation() {
        
        $pluginInstance = new \AngularPress\Plugin;

        \WP_Mock::wpFunction(
            'register_deactivation_hook',
            array(
                'times' => 1,
                'args' => array(
                    ANGULAR_PRESS_PLUGIN_DEACTIVATION_FILE,
                    array(
                        $pluginInstance,
                        'pluginDeactivation'
                    )
                ),
            )
        );

        require_once ANGULAR_PRESS_PLUGIN_DEACTIVATION_FILE;

        $this->assertTrue( method_exists($pluginInstance, 'pluginDeactivation') );
    }

}
