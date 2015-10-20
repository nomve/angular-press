<?php


namespace AngularPress\Tests;


class AdminTest extends \WP_Mock\Tools\TestCase {

    public function setUp() {
        parent::setUp();
    }

    public function tearDown() {
        parent::tearDown();
    }
    /**
     * 
     */
    public function testShowsCurrentlySavedOptions() {
        
        $admin = new \AngularPress\AdminPage();

        \WP_Mock::wpFunction(
            'get_option',
            array(
                'times' => 1,
                'args' => array(
                    $admin->getOptionsField()
                ),
                'return' => 1
            )
        );
        
        $this->assertTrue( $admin->getGalleryTemplate() === 1 );
    }
    
}
