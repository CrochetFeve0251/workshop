<?php
/**
 * Plugin Name: Workshop
 */

function sitemap_add_redirect_rule() {
    $sitemap = get_option('sitemap_sitemap_url', '');

    if( ! $sitemap ) {
        return;
    }

    add_rewrite_rule('^' . preg_quote($sitemap) . '$', 'index.php?sitemap=index', 'top');
}

add_action('init', 'sitemap_add_redirect_rule');