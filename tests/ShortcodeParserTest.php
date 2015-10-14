<?php


namespace AngularPress\Tests;


class ShortcodeParserTest extends \WP_Mock\Tools\TestCase {

    private $shortcodeParser;

    public function setUp() {
        parent::setUp();
        $this->shortcodeParser = new \AngularPress\ShortcodeParser();
    }

    public function tearDown() {
        parent::tearDown();
        unset($this->shortcodeParser);
    }
    /**
     * 
     */
    public function testAddedGalleryShortcodeParsing() {

        \WP_Mock::expectFilterAdded(
            'post_gallery',
            array(
                $this->shortcodeParser,
                'parseGallery'
            ),
            0,
            2
        );

        $this->shortcodeParser->addFilters();
    }
    /**
     *
     */
    public function testAngularGalleryShortcodeParsing() {

        $attributes = array(
            'ids' => 4
        );

        $this->setupWpGetAttachmentImage();

        $result = $this->shortcodeParser->parseGallery(null, $attributes);

        $this->assertTrue( $result === '<gallery images="[{"src":"path","width":300,"height":200}]"></gallery>' );
    }
    /**
     *
     */
    public function testGalleryImageHasProperSize() {

        $imageId = 4;
        $imageSize = 'thumbnail';

        $attributes = array(
            'ids' => $imageId,
            'size' => $imageSize
        );
        // fullsize - shouldn't be used
        $this->setupWpGetAttachmentImage(
            array(
                $imageId, 'fullsize'
            )
        );
        // thumbnail - default size
        $this->setupWpGetAttachmentImage(
            array(
                $imageId, $imageSize
            ),
            array(
                'path/to/thumbnail',
                100,
                100
            ),
            1
        );

        $result = $this->shortcodeParser->parseGallery(null, $attributes);

        $this->assertTrue( $result === '<gallery images="[{"src":"path\/to\/thumbnail","width":100,"height":100}]"></gallery>' );
    }

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
}
