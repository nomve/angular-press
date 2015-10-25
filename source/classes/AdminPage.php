<?php


namespace AngularPress;


class AdminPage {
    
    private $renderer;
    private $options;
    
    const SETTING_GROUP = 'angular-press-settings';
    
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
        register_setting( self::SETTING_GROUP, $this->options->getOptionsField() );
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
                'settings_fields' => $this->getSettingsFields(),
                'shortcode_field_name' => $this->options->getOptionsField(),
                'shortcodes' => $this->getShortcodes(),
                'submit_button' => $this->getSubmitButton()
            )
        );
    }
    /**
     *
     */
    private function getShortcodes() {

        $availableShortcodes = $this->options->getShortcodes();
        $currentValues = $this->options->getAll();
        $shortcodes = array();

        if ( empty($currentValues[$currentShortcode]) )
            $currentValues[$currentShortcode] = '';

        foreach ( $availableShortcodes as $currentShortcode ) {
            $shortcodes[] = array(
                'name' => $currentShortcode,
                'value' => $currentValues[$currentShortcode]
            );
        }

        return $shortcodes;
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
    /**
     *
     */
    private function getSubmitButton() {

        ob_start();

        submit_button();
        $submit_button = ob_get_contents();

        ob_end_clean();
        return $submit_button;
    }
}