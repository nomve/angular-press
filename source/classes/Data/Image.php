<?php

namespace AngularPress\Data;

class Image {
    
    private $id;
    private $size;
    private $link;
    
    function __construct($id, $size, $link ) {
        
        $this->id = $id;
        $this->size = $size;
        $this->link = $link;
        
        $this->setImageWithProperties();
        $this->setImageLink();
    }
    /**
     * 
     */
    private function setImageWithProperties() {
        
        $image = wp_get_attachment_image_src( $this->id,
                                                $this->size );
        
        if ( ! empty($image[0]) )
            $this->src = $image[0];
        
        if ( ! empty($image[1]) )
            $this->width = $image[1];
        
        if ( ! empty($image[2]) )
            $this->height = $image[2];
    }
    /**
     * 
     */
    private function setImageLink() {
        
        if ( $this->link === 'post' ) {
            $this->href = get_permalink($this->id);
        }
        elseif ( $this->link === 'file' ) {
            $imageFile = wp_get_attachment_image_src( $this->id, 'full' );
            $this->href = $imageFile[0];
        }
    }
}