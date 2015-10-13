<?php


namespace AngularPress\Tests;


class PluginTest extends \WP_Mock\Tools\TestCase {

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
        
        $pluginInstance = new \AngularPress\Plugin;

        \WP_Mock::wpFunction(
            'register_api_field',
            array(
                'times' => 1,
                'args' => array(
                    'post',
                    'content',
                    array(
                        'get_callback'    => array(
                            $pluginInstance,
                            'addAngularFieldToObject'
                        ),
                        'update_callback' => null,
                        'schema'          => null,
                    )  
                ),
            )
        );
        
        $pluginInstance->registerPostContentField();
    }
    
    /**
     * 
     */
    public function testAddingAngularJsonFieldToPostContent() {
        
        $pluginInstance = new \AngularPress\Plugin;
        
        $field = 'content';
        $mockObject = array(
            $field => array(
                'rendered' => 1
            )
        );
        
        $result = $pluginInstance->addAngularFieldToObject( $mockObject, $field, array() );
        
        $this->assertFalse( empty($result['angular']) );
    }
}
