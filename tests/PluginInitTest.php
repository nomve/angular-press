<?php


namespace AngularPress\Tests;


class PluginInitTest extends \WP_Mock\Tools\TestCase {
    
    private $pluginInstance;

    public function setUp() {
        parent::setUp();
        $this->pluginInstance = new \AngularPress\Plugin();
    }

    public function tearDown() {
        parent::tearDown();
        unset($this->pluginInstance);
    }


    function testPluginExists() {

        $this->assertFileExists( ANGULAR_PRESS_PLUGIN_FILE );
    }

    /**
     * tests if the plugin file uses the appropriate install hook
     */
    function testPluginActivation() {

        \WP_Mock::wpFunction(
            'register_activation_hook',
            array(
                'times' => 1,
                'args' => array(
                    ANGULAR_PRESS_PLUGIN_FILE,
                    array(
                        $this->pluginInstance,
                        'pluginActivation'
                    )
                ),
            )
        );

        \WP_Mock::wpFunction( 'register_deactivation_hook' );

        require_once ANGULAR_PRESS_PLUGIN_FILE;

        $this->assertTrue( method_exists($this->pluginInstance, 'pluginActivation') );
    }
    /**
     * 
     */
    public function testRegistersOptionsFields() {

        \WP_Mock::wpFunction(
            'add_option',
            array(
                'times' => 1,
                'args' => array(
                    \AngularPress\Plugin::OPTIONS_FIELD,
                    ''
                ),
            )
        );
        $this->pluginInstance->pluginActivation();
    }
    /**
     * tests if the plugin file uses the appropriate uninstall hook
     */
    function testPluginDeactivation() {

        \WP_Mock::wpFunction(
            'register_deactivation_hook',
            array(
                'times' => 1,
                'args' => array(
                    ANGULAR_PRESS_PLUGIN_FILE,
                    array(
                        $this->pluginInstance,
                        'pluginDeactivation'
                    )
                ),
            )
        );

        require ANGULAR_PRESS_PLUGIN_DEACTIVATION_FILE;

        $this->assertTrue( method_exists($this->pluginInstance, 'pluginDeactivation') );
    }
    /**
     * 
     */
    public function testUnegistersOptionsFields() {

        \WP_Mock::wpFunction(
            'delete_option',
            array(
                'times' => 1,
                'args' => array(
                    \AngularPress\Plugin::OPTIONS_FIELD
                ),
            )
        );
        $this->pluginInstance->pluginDeactivation();
    }

}
