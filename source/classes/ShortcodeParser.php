<?php

namespace AngularPress;

class ShortcodeParser {
    
    function __construct() {
        
        add_filter( 'post_gallery', array($this, 'parseGallery'), 0, 2 );
    }
    /**
     * 
     */
    public function parseGallery() {
    }
}