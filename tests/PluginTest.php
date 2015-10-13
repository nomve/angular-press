<?php


namespace AngularPress\Tests;


class PluginTest extends \WP_Mock\Tools\TestCase {

    /**
     * 
     */
    public function testRegisteringCallbackToAddJsonField() {
        
        \WP_Mock::expectActionAdded( 'rest_api_init', array(
                new \AngularPress\Plugin,
                'registerPostField'
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
                            'addAngularPostContentField'
                        ),
                        'update_callback' => null,
                        'schema'          => null,
                    )  
                ),
            )
        );
        
        $pluginInstance->registerPostField();
    }
    
    /**
     * 
     */
    public function testAddingAngularJsonFieldToPostContent() {
        
        $pluginInstance = new \AngularPress\Plugin;
        
        $pluginInstance->addAngularPostContentField();
    }
}
