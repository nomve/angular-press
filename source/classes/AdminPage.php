<?php


namespace AngularPress;


class AdminPage {
    
    const OPTIONS_FIELD = 'angular_press_options';
    
    /**
     * 
     */
    public function getOptionsField() {
        return self::OPTIONS_FIELD;
    }
    /**
     * 
     */
    public function getGalleryTemplate() {
        $option = get_option( self::OPTIONS_FIELD );
        return $option;
    }
    /**
     * 
     */
    public function renderOptionsPage() {
        
        echo 1;
    }
}