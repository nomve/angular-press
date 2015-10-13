<?php


namespace AngularPress;


class Plugin {
    
    const CONTENT_FIELD = 'content';
    
    function __construct() {
        
        add_action( 'rest_api_init', array($this, 'registerPostContentField') );
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
    public function registerPostContentField() {
        
        register_api_field( 'post',
            self::CONTENT_FIELD,
            array(
                'get_callback'    => array(
                    $this,
                    'addAngularFieldToObject'
                ),
                'update_callback' => null,
                'schema'          => null,
            ) 
        ); 
    }
    /**
     * adds a field called angular to the given object[field]
     */
    public function addAngularFieldToObject( $object, $field_name, $request ) {
        
        if ( empty($object['id']) || empty($object[$field_name]) )
            return $object;
    
        $post = get_post($object['id']);
        
        if ( empty($post) )
            return $object[$field_name];
        
        $object[$field_name]['angular'] = $post->post_content;

        return $object[$field_name];    
    }
    
}