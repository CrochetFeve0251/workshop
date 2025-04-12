<?php
namespace Workshop\Tests\Integration;

define( 'WORKSHOP_PLUGIN_ROOT',
    dirname( dirname( __DIR__ ) ) . DIRECTORY_SEPARATOR
);

// Manually load the plugin being tested.
tests_add_filter(
    'muplugins_loaded',
    function() {
        // Load the plugin.
        require WORKSHOP_PLUGIN_ROOT . '/workshop.php';
    }
);

require WORKSHOP_PLUGIN_ROOT . '/vendor/autoload.php';





