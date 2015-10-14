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
    public function parseGallery($currentValue, $attributes) {

        $ids = explode( ',', $attributes['ids'] );

        if ( empty($ids) )
            return '';

        $imageObjects = array_map( function($id) {
            $obj = new \stdClass;
            $image = wp_get_attachment_image_src( $id, 'full' );
            $obj->src = $image[0];
            $obj->width = $image[1];
            $obj->height = $image[2];
            return $obj;
        }, $ids);

        return '<gallery images="' . json_encode($imageObjects) . '"></gallery>';
    }
}