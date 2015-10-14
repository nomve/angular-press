<?php

namespace AngularPress;

class ShortcodeParser {

    /**
     *
     */
    public function addFilters() {

        add_filter( 'post_gallery', array($this, 'parseGallery'), 0, 2 );
    }
    /**
     *
     */
    public function parseGallery() {
    }
}