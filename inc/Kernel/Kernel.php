<?php

namespace Workshop\Kernel;

use Workshop\Kernel\EventManager\EventManager;

class Kernel
{
    protected $eventManager;

    public function __construct(EventManager $eventManager) {
        $this->eventManager = $eventManager;
    }

    public function boot(array $subscribers) {
        foreach ( $subscribers as $subscriber ) {
            $this->eventManager->add_subscriber( new $subscriber );
        }
    }
}