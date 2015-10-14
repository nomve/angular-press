<?php

namespace AngularPress\Data;

class Image {
    
    function __construct($id, $size) {
        
        $image = $this->getImageByIdAndSize( $id, $size );
        
        if ( ! empty($image[0]) )
            $this->src = $image[0];
        
        if ( ! empty($image[1]) )
            $this->width = $image[1];
        
        if ( ! empty($image[2]) )
            $this->height = $image[2];
    }
    
    private function getImageByIdAndSize( $id, $size ) {
        
        return wp_get_attachment_image_src( $id, $size );
    }
}