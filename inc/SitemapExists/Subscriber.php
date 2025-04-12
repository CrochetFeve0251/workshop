<?php

namespace Workshop\SitemapExists;

use Workshop\Kernel\EventManager\SubscriberInterface;

class Subscriber implements SubscriberInterface
{

    /**
     * @inheritDoc
     */
    public static function get_subscribed_events()
    {
        return [
            'admin_init' => 'check_sitemap_exists',
        ];
    }

    public function check_sitemap_exists() {
        $sitemaps = wp_sitemaps_get_server();

        $url = $sitemaps->index->get_index_url();

        $response = wp_remote_get($url);

        if( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
            update_option( 'sitemap_sitemap_exists', false );
            return false;
        }

        $data = wp_remote_retrieve_body( $response );

        libxml_use_internal_errors(true);

        $xml = simplexml_load_string($data);

        if( ! $xml ) {
            update_option( 'sitemap_sitemap_exists', false );
            return false;
        }

        update_option( 'sitemap_sitemap_exists', true );
    }
}