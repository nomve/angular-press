<?php


namespace AngularPress;


class Plugin {
    
    function __construct() {
        
        add_action( 'rest_api_init', array($this, 'registerPostField') );
    }

    public function pluginActivation() {
        // doesn't save settings at the moment
    }

    public function pluginDeactivation() {
        // no settings atm
    }
    
    /**
     * registers a field in the post content field
     */
    public function registerPostField() {
        
        register_api_field( 'post',
            'content',
            array(
                'get_callback'    => array(
                    $this,
                    'addAngularPostContentField'
                ),
                'update_callback' => null,
                'schema'          => null,
            ) 
        ); 
    }
    /**
     * adds a field in the post content
     */
    public function addAngularPostContentField() {
    }
    
}