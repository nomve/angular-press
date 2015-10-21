<?php


namespace AngularPress;


class AdminPage {
    
    private $renderer;
    private $options;
    
    const SETTING_GROUP = 'angular-press-settings';
    const SETTING_SHORTCODE_FIELD = 'shortcode';
    
    public function __construct( $renderer = '' ) {
        
        if ( empty($renderer) )
            $renderer = new \Mustache_Engine( array(
                'loader' => new \Mustache_Loader_FilesystemLoader( __DIR__ . '/../views/' )
            ));
        
        $this->renderer = $renderer;
        $this->options = new Options();
        
        add_action( 'admin_init', array( $this, 'optionsPageInit' ) );
    }
    /**
     * 
     */
    public function optionsPageInit() {
        register_setting( self::SETTING_GROUP, self::SETTING_SHORTCODE_FIELD );
    }
    /**
     * 
     */
    public function renderOptionsPage() {
        
        $template = $this->renderer->loadTemplate('admin-options');
        
        echo $template->render(
            array(
                'options' => $this->options->getAll(),
                'title' => 'Angular-Press Settings',
                'settings_fields' => $this->getSettingsFields()
            )
        );
    }
    /**
     * 
     */
    private function getSettingsFields() {
        
        ob_start();
        
        settings_fields( self::SETTING_GROUP );
        $settings_fields = ob_get_contents();
        
        ob_end_clean();
        
        return $settings_fields;
    }
}