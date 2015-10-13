<?php


namespace AngularPress\Tests;


class PluginTest extends \WP_Mock\Tools\TestCase {
    
    private $pluginInstance;

    public function setUp() {
        parent::setUp();
        $this->pluginInstance = new \AngularPress\Plugin;
    }

    public function tearDown() {
        parent::tearDown();
        unset( $this->pluginInstance );
    }

    /**
     * 
     */
    public function testRegisteringCallbackToAddJsonField() {
        
        \WP_Mock::expectActionAdded( 'rest_api_init', array(
                new \AngularPress\Plugin,
                'registerPostContentField'
            )
        );
        
        new \AngularPress\Plugin();
    }
    
    /**
     * 
     */
    public function testRegisteringFieldToPostContent() {

        \WP_Mock::wpFunction(
            'register_api_field',
            array(
                'times' => 1,
                'args' => array(
                    'post',
                    'content',
                    array(
                        'get_callback'    => array(
                            $this->pluginInstance,
                            'addAngularFieldToObject'
                        ),
                        'update_callback' => null,
                        'schema'          => null,
                    )  
                ),
            )
        );
        
        $this->pluginInstance->registerPostContentField();
    }
    
    /**
     * 
     */
    public function testAddingAngularJsonFieldToPostContent() {
        
        $field = 'content';
        $mockObject = array(
            $field => array(
                'rendered' => 1
            )
        );
        
        $result = $this->pluginInstance->addAngularFieldToObject( $mockObject, $field, array() );
        
        $this->assertFalse( empty($result['angular']) );
    }
}
