<?php


namespace AngularPress\Tests;


class ShortcodeParserTest extends \WP_Mock\Tools\TestCase {

    private $shortcodeParser;
    private $imageId;
    private $imageSize;
    private $imageWidth;
    private $imageHeight;
    private $imageLink;

    public function setUp() {
        parent::setUp();
        $this->shortcodeParser = new \AngularPress\ShortcodeParser();
        $this->imageId = 4;
        $this->imageSize = 'thumbnail';        
        $this->imageWidth = 100;
        $this->imageHeight = 100;
        $this->imageLink = 'post';
    }

    public function tearDown() {
        parent::tearDown();
        unset($this->shortcodeParser);
        unset($this->imageId);
        unset($this->imageSize);
        unset($this->imageWidth);
        unset($this->imageHeight);
        unset($this->imageLink);
    }
    /**
     * 
     */
    public function testAddedGalleryShortcodeParsing() {

        \WP_Mock::expectFilterAdded(
            'post_gallery',
            array(
                $this->shortcodeParser,
                'galleryCallback'
            ),
            0,
            2
        );

        $this->shortcodeParser->addFilters();
    }
    /**
     *
     */
    public function testGalleryImageHasProperDefaults() {

        $attributes = $this->setupWpGetGalleryAttributes();
        //should use default size
        unset($attributes['size']);
        $this->assertTrue( empty($attributes['size']) );
        $this->assertTrue( $this->imageSize === 'thumbnail' );
        //should use default link
        unset($attributes['link']);
        $this->assertTrue( empty($attributes['link']) );
        
        $this->setupWpGetProperAttachmentImage();
        
        $result = $this->shortcodeParser->galleryCallback(null, $attributes);

        $this->assertTrue( $result === 
                            sprintf(
                                '<gallery images=%1$s[{"src":"path\/to\/%2$s","width":%3$s,"height":%4$s,"href":"%5$s"}]%1$s></gallery>',
                                '\'',
                                $this->imageSize,
                                $this->imageWidth,
                                $this->imageHeight,
                                $this->imageLink
                            )
                         );
    }
    /**
     * 
     */
    public function testGalleryImageHasProperCustomSize() {
        
        $this->imageSize = 'medium';
        $this->imageWidth = 400;
        $this->imageHeight = 300;

        $attributes = $this->setupWpGetGalleryAttributes();
        $this->setupWpGetProperAttachmentImage();
        
        $result = $this->shortcodeParser->galleryCallback(null, $attributes);

        $this->assertTrue( $result === 
                            sprintf(
                                '<gallery images=%1$s[{"src":"path\/to\/%2$s","width":%3$s,"height":%4$s,"href":"%5$s"}]%1$s></gallery>',
                                '\'',
                                $this->imageSize,
                                $this->imageWidth,
                                $this->imageHeight,
                                $this->imageLink
                            )
                         );
    }
    /**
     * 
     */
    public function testGalleryImageHasProperLinkToFile() {

        $this->imageLink = 'file';
        $attributes = $this->setupWpGetGalleryAttributes();
        $this->setupWpGetProperAttachmentImage();
        
        $result = $this->shortcodeParser->galleryCallback(null, $attributes);

        $this->assertTrue( $result === 
                            sprintf(
                                '<gallery images=%1$s[{"src":"path\/to\/%2$s","width":%3$s,"height":%4$s,"href":"%5$s"}]%1$s></gallery>',
                                '\'',
                                $this->imageSize,
                                $this->imageWidth,
                                $this->imageHeight,
                                $this->imageLink
                            )
                         );
    }
    /**
     * 
     */
    public function testGalleryImageHasNoLink() {

        $this->imageLink = 'none';
        $attributes = $this->setupWpGetGalleryAttributes();
        $this->setupWpGetProperAttachmentImage();
        
        $result = $this->shortcodeParser->galleryCallback(null, $attributes);

        $this->assertTrue( $result === 
                            sprintf(
                                '<gallery images=%1$s[{"src":"path\/to\/%2$s","width":%3$s,"height":%4$s}]%1$s></gallery>',
                                '\'',
                                $this->imageSize,
                                $this->imageWidth,
                                $this->imageHeight
                            )
                         );
    }
    /**
     * setup a function call expectation to retrieve images with given params
     * call arguments, what to returns, how many times
     */
    private function setupWpGetAttachmentImage($args = '',$return = '', $times = 0) {

        if ( empty($return) ) {
            $return = array(
                'path', 300, 200
            );
        }

        $options = array(
            'return' => $return
        );

        if ( ! empty($args) )
            $options['args'] = $args;

        if ( ! empty($times) )
            $options['times'] = $times;

        \WP_Mock::wpFunction(
            'wp_get_attachment_image_src',
            $options
        );
    }
    /**
     * sets up two function call expectations to get a wordpress image 
     * one that shouldn't be called
     * one that must be called
     */
    private function setupWpGetProperAttachmentImage() {
        
        $fullsizeTimes = 0;
        
        // mock get_permalink for the image link
        if ( $this->imageLink === 'post' )
            \WP_Mock::wpFunction(
                'get_permalink',
                array(
                    'args' => $this->imageId,
                    'return' => $this->imageLink,
                    'times' => 1
                )
            );
        
        // fullsize - shouldn't be used except for file link
        $this->setupWpGetAttachmentImage(
            array(
                $this->imageId, 'full'
            ),
            array(
                $this->imageLink
            )
        );
        // the expectation that should be used
        $this->setupWpGetAttachmentImage(
            array(
                $this->imageId, $this->imageSize
            ),
            array(
                sprintf('path/to/%s', $this->imageSize),
                $this->imageWidth,
                $this->imageHeight
            ),
            1
        );
    }
    /**
     * 
     */
    private function setupWpGetGalleryAttributes() {
        return array(
            'ids' => $this->imageId,
            'size' => $this->imageSize,
            'link' => $this->imageLink
        );
    }
}
