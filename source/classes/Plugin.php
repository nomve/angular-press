<?php


namespace AngularPress;


class Plugin {
    
    const NAME = 'Angular-Press';
    const SLUG = 'angular-press';
    const REQUIRED_PERMISSIONS = 'manage_options';
    const CONTENT_FIELD = 'content';

    private $shortcodeParser;

    function __construct() {
        
        $this->shortcodeParser = new ShortcodeParser();
        $this->adminPage = new AdminPage();
        
        add_action( 'rest_api_init', array($this, 'registerPostContentField') );
        add_action( 'admin_menu', array($this, 'addSubmenuPage') );
    }

    public function pluginActivation() {
        add_option( $this->adminPage->getOptionsField(), '' );
    }

    public function pluginDeactivation() {
        delete_option( $this->adminPage->getOptionsField() );
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

        $this->adjustContentForAngular();

        $object[$field_name]['angular'] = do_shortcode( $post->post_content );

        return $object[$field_name];    
    }

    private function adjustContentForAngular() {

        $this->shortcodeParser->addFilters();
    }
    /**
     * 
     */
    public function addSubmenuPage() {
        
        add_submenu_page( 
            'options-general.php',
            sprintf('%s Settings', self::NAME),
            self::NAME,
            self::REQUIRED_PERMISSIONS,
            self::SLUG,
            array(
                $this->adminPage,
                'renderOptionsPage'
            )
        );
    }

}