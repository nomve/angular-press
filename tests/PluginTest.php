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
                    \AngularPress\Plugin::CONTENT_FIELD,
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
        
        // post array passed as parameter from wordpress
        $mockObject = array(
            'id' => 1,
            \AngularPress\Plugin::CONTENT_FIELD => array(
                'rendered' => 1
            )
        );
        
        $result = $this->pluginInstance->addAngularFieldToObject(
                                $mockObject,
                                \AngularPress\Plugin::CONTENT_FIELD, array() );
        
        $this->assertFalse( empty($result['angular']) );
    }
    /**
     * 
     */
    public function testSilentlyFailingWhenCallbackUsedIncorrectly() {
        
        $objectOptions = array(
            // no content
            array(),
            // content not an array
            1,
            // no matching key
            array('test'),
            // no id
            array(
                \AngularPress\Plugin::CONTENT_FIELD => array(
                'rendered' => 1
                )
            )
        );
        
        foreach ( $objectOptions as $object ) {
            
            $result = $this->pluginInstance->addAngularFieldToObject(
                                    $object,
                                    \AngularPress\Plugin::CONTENT_FIELD, array() );

            $this->assertTrue( empty($result['angular']) );
        }
    }
}
