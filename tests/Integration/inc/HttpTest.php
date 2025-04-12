<?php
namespace Workshop\Tests\Integration\inc;
use Workshop\Tests\Integration\TestCase;
class HttpTest extends TestCase
{
    public function set_up() {
        parent::set_up();
        add_filter('pre_http_request', [$this, 'my_callback'], 10, 3);
    }

    public function test() {

    }

    public function my_callback($response, $args, $url) {
        if('my-url' !== $response) {
            return $response;
        }

        return new WP_Error( 'http_request_block', 'disabled ' );
    }

    public function tear_down() {
        remove_filter('pre_http_request', [$this, 'my_callback'], 10);
        parent::tear_down();
    }
}










