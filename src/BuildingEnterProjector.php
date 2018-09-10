<?php

use Changeset\Event\EventInterface;
use Changeset\Event\ProjectorInterface;
use Doctrine\ORM\EntityManager;

class BuildingEnterProjector implements ProjectorInterface
{
    /** @var EntityManager */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function supports(EventInterface $event): bool
    {
        return $event->getName() == 'enter_building_completed';
    }

    public function process(EventInterface $event)
    {
        $building = $this->em->getRepository(Building::class)->find($event->getAggregateId());

        if( ! $building)
        {
            $building = new Building();
            $building->id = $event->getAggregateId();
            $building->people = '[]';
        }

        $people = json_decode($building->people, true);
        $payload = json_decode($event->getPayload(), true);
        if( ! in_array($payload['user'], $people))
        {
            $people[] = $payload['user'];
            $building->people = json_encode($people);

            $this->em->persist($building);
            $this->em->flush($building);
        }

        printf(
            "There are currently %d person(s) in the %s %s\n",
            count($people), $event->getAggregateId(), $event->getAggregateType()
        );
    }
}