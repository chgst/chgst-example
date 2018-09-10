<?php

use Changeset\Event\EventInterface;
use Changeset\Event\ListenerInterface;

class ConsoleOutListener implements ListenerInterface
{
    public function supports(EventInterface $event): bool
    {
        return true; // let's support every event
    }

    public function process(EventInterface $event)
    {
        printf(
            "An event named: \"%s\" occured on %s with id \"%s\" with payload %s\n",
            $event->getName(), $event->getAggregateType(), $event->getAggregateId(), $event->getPayload()
        );
    }
}