<?php

namespace Workshop\Tests\Integration\inc;

use Workshop\Tests\Integration\TestCase;

class ServeSitemapTest extends TestCase
{
    protected $option_value;

    public function set_up()
    {
        parent::set_up();
        add_filter('pre_option_sitemap_sitemap_url', [$this, 'get_sitemap_option']);
    }

    public function tear_down()
    {
        remove_filter('pre_option_sitemap_sitemap_url', [$this, 'get_sitemap_option']);
        parent::tear_down();
    }

    public function testShouldEnqueueNewRule() {
        global $wp_rewrite;

        $this->option_value = 'sitemap.xml';

        do_action('init');

        $this->assertArrayHasKey("^sitemap\.xml$", $wp_rewrite->extra_rules_top);
        $this->assertSame('index.php?sitemap=index', $wp_rewrite->extra_rules_top["^sitemap\.xml$"]);
    }

    public function testEmptyOptionShouldNotEnqueue() {
        global $wp_rewrite;
        $this->option_value = '';

        $original_size = count($wp_rewrite->extra_rules_top);

        do_action('init');

        $this->assertCount($original_size, $wp_rewrite->extra_rules_top);
    }

    public function get_sitemap_option() {
        return $this->option_value;
    }
}